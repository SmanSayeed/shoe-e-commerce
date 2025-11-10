<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
        $cartTotal = $cartItems->sum('total_price');
        $cartCount = $cartItems->sum('quantity');

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        $user = Auth::user();

        // If user is not logged in, pass empty user object for guest checkout form
        if (!$user) {
            $user = new \App\Models\User();
        }

        return view('frontend.checkout.index', compact('cartItems', 'cartTotal', 'cartCount', 'user'));
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request): JsonResponse
    {
        // Validate guest user information if not logged in

        if (!Auth::check()) {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'shipping_address' => 'required|string|max:500',
                'division' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'postal_code' => 'required|string|max:20',
                'country' => 'required|string|max:100',
            ]);
        }

        // Prevent admin users from placing orders
        if (Auth::check() && Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Admin users are not allowed to place orders.',
            ], 403);
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|array',
            'payment_method' => 'required|string|in:cod,cash_on_delivery',
            'notes' => 'nullable|string|max:500',
        ]);

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
            $userData = [
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('shipping_address'),
                'city' => $request->input('district'), // Map district to city
                'state' => $request->input('division'), // Map division to state
                'postal_code' => $request->input('postal_code'),
                'country' => $request->input('country'),
                'is_guest' => true,
                'password' => bcrypt(uniqid('guest_', true)), // Generate a random password for guest users
            ];

            if (!$user) {
                // Check if user with this email exists
                $user = \App\Models\User::where('email', $userData['email'])->first();

                // If user doesn't exist, create a new guest user
                if (!$user) {
                    $user = \App\Models\User::create($userData);
                } else {
                    // If user exists, update their details for this order
                    $user->update([
                        'first_name' => $userData['first_name'],
                        'last_name' => $userData['last_name'],
                        'phone' => $userData['phone'],
                        'address' => $userData['address'],
                        'city' => $userData['city'],
                        'state' => $userData['state'],
                        'postal_code' => $userData['postal_code'],
                        'country' => $userData['country'],
                    ]);
                }

                if (!$user) {
                    // Create a new user with a random password
                    $user = new \App\Models\User([
                        'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                        'email' => $userData['email'],
                        'password' => bcrypt(Str::random(16)), // Random password
                        'phone' => $userData['phone'],
                        'is_guest' => true,
                    ]);
                    $user->save();
                }

                // Update user address
                $user->update([
                    'address' => $userData['address'],
                    'city' => $request->input('district'), // Map district to city
                    'state' => $request->input('division'), // Map division to state
                    'postal_code' => $userData['postal_code'],
                    'country' => $userData['country'],
                ]);

                // Log in the user for the current session
                Auth::login($user);

            }

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

            // Calculate totals
            $subtotal = $cartItems->sum('total_price');
            $taxAmount = 0; // No tax

            // Calculate shipping using ShippingService
            $shippingAmount = $this->calculateShippingAmount($request, $subtotal);

            $discountAmount = 0;
            $couponCode = null;

            if (session()->has('coupon')) {
                $coupon = session('coupon');
                $discountAmount = $coupon['discount'];
                $couponCode = $coupon['code'];
            }

            $totalAmount = $subtotal + $taxAmount + $shippingAmount - $discountAmount;

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $totalAmount,
                'payment_status' => 'pending',
                'payment_method' => $request->input('payment_method'),
                'billing_address' => $request->input('billing_address'),
                'shipping_address' => $request->input('shipping_address'),
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

            session()->forget('coupon');

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
        // Ensure order belongs to current user
        if ($order->user_id !== Auth::id()) {
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
            $unitPrice = $product->current_price;

            // If variant is specified, get variant details
            if ($request->variant_id) {
                $variant = ProductVariant::findOrFail($request->variant_id);
                // Use product's current price (respects sales)
                $unitPrice = $product->current_price;

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

            // Calculate totals
            $subtotal = $unitPrice * $request->quantity;
            $taxAmount = 0; // No tax

            // Calculate shipping using ShippingService
            $shippingAmount = $this->calculateShippingAmount($request, $subtotal);

            $totalAmount = $subtotal + $taxAmount + $shippingAmount;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $totalAmount,
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
                'total_price' => $subtotal,
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

        $cartItems = $query->get()
            ->map(function ($item) {
                $item->total_price = $item->quantity * $item->unit_price;
                return $item;
            });

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
     * Calculate shipping amount using ShippingService
     */
    private function calculateShippingAmount(Request $request, float $subtotal): float
    {
        // Check if free shipping threshold is met
        if ($subtotal > 1000) {
            return 0;
        }

        // Get shipping address from request
        $division = $request->input('division');
        $district = $request->input('district');

        // If division or district is missing, fall back to default shipping
        if (empty($division) || empty($district)) {
            return (float) config('shipping.default_shipping_charge', 60);
        }

        try {
            return $this->shippingService->calculateShippingCharge($division, $district);
        } catch (\Exception $e) {
            \Log::error('Error calculating shipping charge: ' . $e->getMessage());
            return (float) config('shipping.default_shipping_charge', 60);
        }
    }
}
