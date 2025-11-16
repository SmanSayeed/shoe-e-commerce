<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AdvancePaymentSetting;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Display checkout page
     */
    public function index()
    {

        $cartItems = $this->getUserCartItems();
        // Use bcadd for precise decimal arithmetic to avoid floating point precision issues
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return bcadd($carry, (string)$item->total_price, 2);
        }, '0');
        $cartCount = $cartItems->sum('quantity');

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $user = Auth::user();

        // If user is not logged in, pass empty user object for guest checkout form
        if (!$user) {
            $user = new \App\Models\User();
        }

        $advancePaymentSettings = AdvancePaymentSetting::current();

        // Get default shipping charge from database
        $defaultShippingCharge = $this->shippingService->getDefaultShippingCharge();

        return view('frontend.checkout.index', compact('cartItems', 'cartTotal', 'cartCount', 'user', 'advancePaymentSettings', 'defaultShippingCharge'));
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request): JsonResponse
    {
        // Validate guest user information if not logged in
        if (!Auth::check()) {
            // Normalize phone number before validation
            $phone = $request->input('phone');
            $phone = preg_replace('/^\+88/', '', $phone); // Remove +88 prefix if present
            $phone = preg_replace('/\D/', '', $phone); // Remove any non-digit characters
            
            // Replace the phone in request for validation
            $request->merge(['phone' => $phone]);
            
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:255',
                    'regex:/^[a-zA-Z\s]+$/',
                ],
                'phone' => [
                    'required',
                    'regex:/^0(13|14|15|16|17|18|19)\d{8}$/',
                ],
                'address' => 'required|string|max:500',
                'city' => 'nullable|string|max:100',
                'division' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'postal_code' => 'nullable|string|max:20',
            ], [
                'name.required' => 'Full name is required.',
                'name.min' => 'Full name must be at least 2 characters.',
                'name.max' => 'Full name cannot exceed 255 characters.',
                'name.regex' => 'Full name can only contain letters and spaces.',
                'phone.required' => 'Phone number is required.',
                'phone.regex' => 'Please enter a valid Bangladesh mobile number (11 digits starting with 0, e.g., 01712345678).',
            ]);
        }

        // Prevent admin users from placing orders
        if (Auth::check() && Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Admin users are not allowed to place orders.',
            ], 403);
        }

        // Check if advance payment is enabled
        $advancePaymentSettings = AdvancePaymentSetting::current();
        $isAdvancePaymentEnabled = $advancePaymentSettings->advance_payment_status ?? false;

        // Normalize phone number before validation (for logged-in users too)
        $phone = $request->input('phone');
        $phone = preg_replace('/^\+88/', '', $phone); // Remove +88 prefix if present
        $phone = preg_replace('/\D/', '', $phone); // Remove any non-digit characters
        
        // Replace the phone in request for validation
        $request->merge(['phone' => $phone]);
        
        // Base validation rules
        $validationRules = [
            'email' => 'nullable|sometimes|email|max:255',
            'phone' => [
                'required',
                'regex:/^0(13|14|15|16|17|18|19)\d{8}$/',
            ],
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:100',
            'division' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'billing_address' => 'nullable|array',
            'billing_address.name' => 'nullable|string|max:255',
            'billing_address.phone' => 'nullable|regex:/^[0-9]+$/|max:20',
            'billing_address.address' => 'nullable|string|max:500',
            'billing_address.city' => 'nullable|string|max:100',
            'billing_address.postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|string|in:cod,cash_on_delivery',
            'notes' => 'nullable|string|max:500',
        ];

        // Add Bkash validation if advance payment is enabled
        if ($isAdvancePaymentEnabled) {
            $validationRules['bkash_number'] = [
                'required',
                'regex:/^01[3-9]\d{8}$/',
            ];
            $validationRules['transaction_id'] = 'required|string|max:100';
        }

        $validationMessages = [
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid Bangladesh mobile number (11 digits starting with 0, e.g., 01712345678).',
            'billing_address.phone.regex' => 'Billing phone number must contain only numbers.',
        ];

        if ($isAdvancePaymentEnabled) {
            $validationMessages['bkash_number.required'] = 'Bkash mobile number is required when advance payment is enabled.';
            $validationMessages['bkash_number.regex'] = 'Please enter a valid Bkash mobile number (11 digits starting with 01, e.g., 01712345678).';
            $validationMessages['transaction_id.required'] = 'Transaction ID is required when advance payment is enabled.';
        }

        $request->validate($validationRules, $validationMessages);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cartItems = $this->getUserCartItems();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.',
                ], 400);
            }

            // If user is not logged in, create a guest user record or handle as guest
            if (!$user) {
                // Guest user - get data from request
                $name = trim($request->input('name'));
                
                // Validate that name is provided for guests
                if (empty($name)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Full name is required.',
                    ], 422);
                }
                
                // Normalize phone number - remove +88 prefix if present, keep only 11 digits
                $phone = $request->input('phone');
                $phone = preg_replace('/^\+88/', '', $phone); // Remove +88 prefix
                $phone = preg_replace('/\D/', '', $phone); // Remove any non-digit characters
                
                $userData = [
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $request->input('address') ?? $request->input('shipping_address'),
                    'city' => $request->input('city') ?? $request->input('district'), // Use city if provided, otherwise map district to city
                    'state' => $request->input('division'), // Map division to state
                    'postal_code' => $request->input('postal_code'),
                    'is_guest' => true,
                    'password' => bcrypt(uniqid('guest_', true)), // Generate a random password for guest users
                ];

                // Create a new guest user
                $user = \App\Models\User::create($userData);
            } else {
                // Logged-in user - update their information from request if provided
                $updateData = [];
                
                // Only update fields that are provided in the request
                if ($request->has('phone') && !empty($request->input('phone'))) {
                    $updateData['phone'] = $request->input('phone');
                }
                if ($request->has('address') && !empty($request->input('address'))) {
                    $updateData['address'] = $request->input('address');
                }
                if ($request->has('city') && !empty($request->input('city'))) {
                    $updateData['city'] = $request->input('city');
                } elseif ($request->has('district') && !empty($request->input('district'))) {
                    $updateData['city'] = $request->input('district');
                }
                if ($request->has('division') && !empty($request->input('division'))) {
                    $updateData['state'] = $request->input('division');
                }
                if ($request->has('postal_code') && !empty($request->input('postal_code'))) {
                    $updateData['postal_code'] = $request->input('postal_code');
                }
                if ($request->has('email') && !empty($request->input('email'))) {
                    $updateData['email'] = $request->input('email');
                }
                
                // Update user if there's data to update
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            }

            // Ensure user exists (should always be true at this point)
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create or retrieve user account.',
                ], 500);
            }

            // Note: Guest users are NOT automatically logged in
            // They can access their order using the order number or order ID from the confirmation page

            // Check stock availability - verify sufficient quantity for each item
            foreach ($cartItems as $item) {
                if ($item->variant) {
                    if ($item->variant->stock_quantity < $item->quantity) {
                        return response()->json([
                            'success' => false,
                            'message' => "Insufficient stock for {$item->product->name}. Requested: {$item->quantity}, Available: {$item->variant->stock_quantity}",
                        ], 400);
                    }
                } elseif (!$item->product->isInStock()) {
                    return response()->json([
                        'success' => false,
                        'message' => "{$item->product->name} is out of stock.",
                    ], 400);
                }
            }

            // Calculate totals - Use bcadd for precise decimal arithmetic
            $subtotal = $cartItems->reduce(function ($carry, $item) {
                return bcadd($carry, (string)$item->total_price, 2);
            }, '0');
            $taxAmount = '0'; // No tax

            // Calculate shipping using ShippingService
            $shippingAmount = $this->calculateShippingAmount($request, $subtotal);

            $discountAmount = '0';
            $couponCode = null;

            if (session()->has('coupon')) {
                $coupon = session('coupon');
                $discountAmount = (string)$coupon['discount'];
                $couponCode = $coupon['code'];
            }

            // Get advance payment settings (already fetched above, but ensure we have it)
            $advancePaymentAmount = 0;
            $advancePaymentStatus = false;
            $bkashNumber = null;
            $transactionId = null;
            $advancePaymentPaidAmount = 0;

            if ($isAdvancePaymentEnabled) {
                $advancePaymentAmount = $advancePaymentSettings->advance_payment_amount;
                $advancePaymentStatus = true;
                $bkashNumber = $request->input('bkash_number');
                $transactionId = $request->input('transaction_id');
                $advancePaymentPaidAmount = $advancePaymentAmount;
            }

            // Use bcadd/bcsub for precise total calculation
            // NOTE: Total amount is NOT deducted when advance payment is enabled
            // The full amount is shown, and advance payment details are stored separately
            $totalAmount = bcadd($subtotal, $taxAmount, 2);
            $totalAmount = bcadd($totalAmount, (string)$shippingAmount, 2);
            $totalAmount = bcsub($totalAmount, $discountAmount, 2);

            // Prepare shipping address as array with all fields
            // For logged-in users, use user data; for guests, use request data
            // Normalize phone number for shipping address
            $shippingPhone = $user->phone ?? $request->input('phone');
            $shippingPhone = preg_replace('/^\+88/', '', $shippingPhone); // Remove +88 prefix if present
            $shippingPhone = preg_replace('/\D/', '', $shippingPhone); // Remove any non-digit characters
            
            $shippingAddress = [
                'name' => $user->name ?? $request->input('name'),
                'phone' => $shippingPhone,
                'address' => $request->input('address') ?? $request->input('shipping_address') ?? $user->address,
                'city' => $request->input('city') ?? $request->input('district') ?? $user->city,
                'division' => $request->input('division') ?? $user->state,
                'district' => $request->input('district') ?? $user->city,
                'postal_code' => $request->input('postal_code') ?? $user->postal_code,
            ];

            // Prepare billing address - use shipping address as default if not provided
            $billingAddress = $request->input('billing_address');
            if (empty($billingAddress) || !is_array($billingAddress) || empty(array_filter($billingAddress))) {
                // Use shipping address as billing address
                $billingAddress = [
                    'name' => $shippingAddress['name'],
                    'phone' => $shippingAddress['phone'],
                    'address' => $shippingAddress['address'],
                    'city' => $shippingAddress['city'],
                    'postal_code' => $shippingAddress['postal_code'],
                ];
            }

            // Create order - Convert string values from bcadd to float for database storage
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => (float)$subtotal, // decimal:2 column will store with precision
                'tax_amount' => (float)$taxAmount,
                'shipping_amount' => $shippingAmount, // Already float from calculateShippingAmount
                'total_amount' => (float)$totalAmount, // decimal:2 column will store with precision
                'advance_payment_amount' => $advancePaymentAmount,
                'advance_payment_status' => $advancePaymentStatus,
                'bkash_number' => $bkashNumber,
                'transaction_id' => $transactionId,
                'advance_payment_paid_amount' => $advancePaymentPaidAmount,
                'payment_status' => 'pending',
                'payment_method' => $request->input('payment_method'),
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress,
                'notes' => $request->input('notes'),
                'is_guest' => !Auth::check() || $user->is_guest,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_variant_id' => $cartItem->product_variant_id,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price,
                    'total_price' => $cartItem->total_price,
                    'product_attributes' => $cartItem->product_attributes,
                ]);

                // Update product sales count
                $cartItem->product->increment('sales_count', $cartItem->quantity);

                // Reduce stock if variant exists
                if ($cartItem->variant) {
                    $cartItem->variant->decrement('stock_quantity', $cartItem->quantity);
                }
            }

            // Clear cart
            $cartItems->each->delete();

            DB::commit();

            // Send order success notification
            try {
                $notificationService = app(\App\Services\NotificationService::class);
                $notificationService->sendOrderSuccessNotification($order);
            } catch (\Exception $e) {
                // Log error but don't fail the order
                \Log::error('Failed to send order notification: ' . $e->getMessage());
            }

            session()->forget('coupon');

            // Store order ID and order number in session for guest users to access order confirmation
            if (!$user || $user->is_guest || !Auth::check()) {
                $recentOrders = session('recent_guest_orders', []);
                $recentOrders[] = $order->id;
                // Keep only last 5 orders
                if (count($recentOrders) > 5) {
                    $recentOrders = array_slice($recentOrders, -5);
                }
                session(['recent_guest_orders' => $recentOrders]);
                session(['last_order_number' => $order->order_number]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect' => route('orders.show', $order),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to process order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show order confirmation
     */
    public function show(Order $order)
    {
        // Allow access if:
        // 1. User is logged in and owns the order, OR
        // 2. Order is a guest order and order ID is in session (from recent checkout), OR
        // 3. Order number matches session (for guest checkout)
        $canAccess = false;

        if (Auth::check() && $order->user_id === Auth::id()) {
            $canAccess = true;
        } elseif ($order->is_guest) {
            // Check if order ID is in session (from recent checkout)
            $recentOrderIds = session('recent_guest_orders', []);
            if (in_array($order->id, $recentOrderIds)) {
                $canAccess = true;
            }
            // Also allow access if order number matches session
            if (session('last_order_number') === $order->order_number) {
                $canAccess = true;
            }
        }

        if (!$canAccess) {
            abort(403, 'Unauthorized access to order');
        }

        $order->load(['items.product', 'items.variant']);

        return view('frontend.orders.show', compact('order'));
    }

    /**
     * Buy now (quick order from product page)
     */
    public function buyNow(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to place an order.',
                'redirect' => route('login'),
            ], 401);
        }

        try {
            $product = Product::findOrFail($request->product_id);
            $variant = null;
            // Round to nearest integer to match display (BDT doesn't use decimals)
            $unitPrice = round((float)$product->current_price);

            // If variant is specified, get variant details
            if ($request->variant_id) {
                $variant = ProductVariant::findOrFail($request->variant_id);
                // Use product's current price (respects sales) - round to match display
                $unitPrice = round((float)$product->current_price);

                // Check stock availability - must have enough quantity
                if ($variant->stock_quantity < $request->quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock. Available: {$variant->stock_quantity}",
                    ], 400);
                }
            }

            // Check product stock if no variant
            if (!$variant && !$product->isInStock()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock.',
                ], 400);
            }

            DB::beginTransaction();

            // Calculate totals using bcmath for precision
            $subtotal = bcmul((string)$unitPrice, (string)$request->quantity, 2);
            $taxAmount = '0'; // No tax

            // Calculate shipping using ShippingService (convert subtotal to float for the method)
            $shippingAmount = $this->calculateShippingAmount($request, $subtotal);

            // Use bcadd for precise total calculation
            $totalAmount = bcadd($subtotal, $taxAmount, 2);
            $totalAmount = bcadd($totalAmount, (string)$shippingAmount, 2);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => (float)$subtotal, // decimal:2 column will store with precision
                'tax_amount' => (float)$taxAmount,
                'shipping_amount' => $shippingAmount, // Already float from calculateShippingAmount
                'total_amount' => (float)$totalAmount, // decimal:2 column will store with precision
                'currency' => 'BDT',
                'payment_status' => 'pending',
                'payment_method' => 'cash_on_delivery', // Default to cash on delivery
                'billing_address' => [], // Will be collected at checkout
                'shipping_address' => [], // Will be collected at checkout
                'shipping_method' => 'standard',
            ]);

            // Create order item
            $attributes = [];
            if ($variant) {
                $attributes = [
                    'color' => $variant->color ? $variant->color->name : null,
                    'size' => $variant->size ? $variant->size->name : null,
                    'variant_name' => $variant->name,
                ];
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_variant_id' => $request->variant_id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'total_price' => (float)$subtotal, // decimal:2 column will store with precision
                'product_attributes' => $attributes,
            ]);

            // Update product sales count
            $product->increment('sales_count', $request->quantity);

            // Reduce stock if variant exists
            if ($variant) {
                $variant->decrement('stock_quantity', $request->quantity);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect' => route('orders.show', $order),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to place order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get cart items for the current user or session
     */
    private function getUserCartItems()
    {
        $query = Cart::with(['product' => function($query) {
                    $query->with('images');
                }, 'variant'])
                ->where('is_active', true);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $sessionId = $this->getSessionId();
            if ($sessionId) {
                $query->where('session_id', $sessionId);
            } else {
                // Return empty collection if no session
                return collect();
            }
        }

        $cartItems = $query->get();

        \Log::info('Cart items retrieved:', [
            'user_id' => Auth::id(),
            'session_id' => session('cart_session_id'),
            'count' => $cartItems->count(),
            'items' => $cartItems->toArray()
        ]);

        return $cartItems;
    }

    /**
     * Get or generate session ID for guest users
     */
    private function getSessionId()
    {
        if (!Auth::check()) {
            $sessionId = session('cart_session_id');
            if (!$sessionId) {
                $sessionId = \Illuminate\Support\Str::uuid()->toString();
                session(['cart_session_id' => $sessionId]);
            }
            return $sessionId;
        }
        return null;
    }

    /**
     * Calculate shipping charge via AJAX (returns JSON with shipping and advance charges)
     */
    public function calculateShipping(Request $request): JsonResponse
    {
        try {
            // Get cart items to calculate subtotal - Use bcadd for precise decimal arithmetic
            $cartItems = $this->getUserCartItems();
            $subtotal = $cartItems->reduce(function ($carry, $item) {
                return bcadd($carry, (string)$item->total_price, 2);
            }, '0');

            // Calculate shipping charge
            $shippingCharge = $this->calculateShippingAmount($request, $subtotal);

            // Get advance payment settings
            $advancePaymentSettings = AdvancePaymentSetting::current();
            $advanceCharge = 0;
            $advanceRequired = false;

            if ($advancePaymentSettings && $advancePaymentSettings->advance_payment_status) {
                $advanceCharge = (float) $advancePaymentSettings->advance_payment_amount;
                $advanceRequired = true;
            }

            return response()->json([
                'success' => true,
                'shipping_charge' => $shippingCharge,
                'advance_charge' => $advanceCharge,
                'advance_required' => $advanceRequired,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in calculateShipping: ' . $e->getMessage());

            // Return default values on error
            $defaultShipping = $this->shippingService->getDefaultShippingCharge();
            $advancePaymentSettings = AdvancePaymentSetting::current();
            $advanceCharge = 0;
            $advanceRequired = false;

            if ($advancePaymentSettings && $advancePaymentSettings->advance_payment_status) {
                $advanceCharge = (float) $advancePaymentSettings->advance_payment_amount;
                $advanceRequired = true;
            }

            return response()->json([
                'success' => false,
                'error' => 'Unable to calculate shipping charge. Using default.',
                'shipping_charge' => $defaultShipping,
                'advance_charge' => $advanceCharge,
                'advance_required' => $advanceRequired,
            ], 500);
        }
    }

    /**
     * Calculate shipping amount using ShippingService
     */
    private function calculateShippingAmount(Request $request, $subtotal): float
    {
        // Convert subtotal to float if it's a string (from bcadd)
        $subtotalFloat = is_string($subtotal) ? (float)$subtotal : (float)$subtotal;
        
        // Check if free shipping threshold is met (compare as float for threshold check)
        if ($subtotalFloat > 1000) {
            return 0.0;
        }

        // Get shipping address from request
        $division = $request->input('division') ?? $request->input('division_name');
        $district = $request->input('district') ?? $request->input('zone_name');

        // If division or district is missing, fall back to default shipping
        if (empty($division) || empty($district)) {
            return $this->shippingService->getDefaultShippingCharge();
        }

        try {
            return $this->shippingService->calculateShippingCharge($division, $district);
        } catch (\Exception $e) {
            \Log::error('Error calculating shipping charge: ' . $e->getMessage());
            return $this->shippingService->getDefaultShippingCharge();
        }
    }
}
