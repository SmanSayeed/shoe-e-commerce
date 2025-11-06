<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Success Message -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-600">Thank you for your order. We'll send you shipping updates at {{ $order->shipping_address['email'] ?? 'your email' }}.</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">Order Details</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <p class="text-gray-600 mt-1">Order #{{ $order->order_number }}</p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Order Items -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-4">Order Items</h3>

                        <div class="space-y-4">
                            @foreach($order->items as $item)
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->product->main_image)
                                        <img src="{{ $item->product->main_image }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                                    @if($item->product_attributes)
                                        <div class="text-sm text-gray-500 mt-1">
                                            @if(isset($item->product_attributes['color']))
                                                Color: {{ $item->product_attributes['color'] }}
                                            @endif
                                            @if(isset($item->product_attributes['size']))
                                                @if(isset($item->product_attributes['color'])) , @endif
                                                Size: {{ $item->product_attributes['size'] }}
                                            @endif
                                        </div>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-1">Quantity: {{ $item->quantity }}</p>
                                </div>

                                <div class="text-right">
                                    <div class="font-medium text-gray-900">৳{{ number_format($item->total_price) }}</div>
                                    <div class="text-sm text-gray-500">৳{{ number_format($item->unit_price) }} each</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Summary & Details -->
                    <div class="space-y-6">
                        <!-- Price Breakdown -->
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-4">Order Summary</h3>

                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>৳{{ number_format($order->subtotal, 2) }}</span>
                                </div>


                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span>
                                        @if($order->shipping_amount == 0)
                                            Free
                                        @else
                                            ৳{{ number_format($order->shipping_amount, 2) }}
                                        @endif
                                    </span>
                                </div>

                                <hr class="border-gray-200 my-2">

                                <div class="flex justify-between text-lg font-semibold text-gray-900">
                                    <span>Total</span>
                                    <span>৳{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        @if($order->shipping_address)
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Shipping Address</h3>
                            <div class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                                <p class="font-medium">{{ $order->shipping_address['name'] ?? '' }}</p>
                                <p>{{ $order->shipping_address['phone'] ?? '' }}</p>
                                @if(isset($order->shipping_address['email']))
                                <p>{{ $order->shipping_address['email'] }}</p>
                                @endif
                                <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                                <p>{{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Payment Information -->
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Payment Information</h3>
                            <div class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                                <div class="flex justify-between">
                                    <span>Payment Method:</span>
                                    <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                                </div>
                                <div class="flex justify-between mt-1">
                                    <span>Payment Status:</span>
                                    <span class="capitalize {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ $order->payment_status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        @if($order->notes)
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Order Notes</h3>
                            <div class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                                {{ $order->notes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="p-6 border-t bg-gray-50">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition text-center">
                        Continue Shopping
                    </a>

                    <a href="{{ route('cart.index') }}" class="bg-gray-100 text-gray-900 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition text-center">
                        View Cart
                    </a>

                    <button onclick="window.print()" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-700 transition text-center">
                        Print Order
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Need help? Contact us at
                        <a href="mailto:support@ssbleather.com" class="text-amber-600 hover:text-amber-700">support@ssbleather.com</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="mt-8 bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-900">Order Timeline</h2>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Order Placed</h4>
                            <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    @if($order->status !== 'pending')
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Order Confirmed</h4>
                            <p class="text-sm text-gray-600">Your order has been confirmed and is being processed</p>
                        </div>
                    </div>
                    @endif

                    @if($order->status === 'shipped')
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Order Shipped</h4>
                            <p class="text-sm text-gray-600">Your order has been shipped</p>
                        </div>
                    </div>
                    @endif

                    @if($order->status === 'delivered')
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Order Delivered</h4>
                            <p class="text-sm text-gray-600">Your order has been delivered successfully</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto print functionality (optional)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('print') === '1') {
        setTimeout(() => {
            window.print();
        }, 1000);
    }
});
</script>
@endpush
