<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to proceed with checkout.');
        }

        $cartItems = $this->getUserCartItems();
        $cartTotal = $cartItems->sum('total_price');
        $cartCount = $cartItems->sum('quantity');

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('frontend.checkout.index', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to proceed with checkout.',
            ], 401);
        }

        // Prevent admin users from placing orders
        if (Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin users are not allowed to place orders.',
            ], 403);
        }

        $request->validate([
            'shipping_address' => 'required|array',
            'billing_address' => 'nullable|array',
            'payment_method' => 'required|string|in:cod,cash_on_delivery',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $cartItems = $this->getUserCartItems();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.',
                ], 400);
            }

            // Check stock availability
            foreach ($cartItems as $item) {
                if ($item->variant && !$item->variant->isInStock()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$item->product->name}. Available: {$item->variant->stock_quantity}",
                    ], 400);
                }
            }

            // Calculate totals
            $subtotal = $cartItems->sum('total_price');
            $taxAmount = $subtotal * 0.13; // 13% tax
            $shippingAmount = $subtotal > 1000 ? 0 : 100; // Free shipping over 1000
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
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => $discountAmount,
                'coupon_code' => $couponCode,
                'total_amount' => $totalAmount,
                'currency' => 'BDT',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
                'shipping_address' => $request->shipping_address,
                'shipping_method' => 'standard',
                'notes' => $request->notes,
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
                // Use price from variant or fallback to product price
                $unitPrice = $variant->price ?? $product->price;

                // Check stock availability
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
            
            // If no variant, use product's sale price if available, otherwise use regular price
            if (!$variant) {
                $unitPrice = $product->sale_price ?? $product->price;
            }

            DB::beginTransaction();

            // Calculate totals
            $subtotal = $unitPrice * $request->quantity;
            $taxAmount = $subtotal * 0.13; // 13% tax
            $shippingAmount = $subtotal > 1000 ? 0 : 100; // Free shipping over 1000
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
     * Get cart items for current user
     */
    private function getUserCartItems()
    {
        if (!Auth::check()) {
            return collect();
        }

        return Cart::with(['product', 'variant'])
            ->where('user_id', Auth::id())
            ->where('is_active', true)
            ->get();
    }
}
