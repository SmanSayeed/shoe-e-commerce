<x-app-layout title="Checkout">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
            <p class="text-gray-600">Complete your order</p>
        </div>

        @if ($cartItems->isEmpty())
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5.4M7 13v6a2 2 0 002 2h8a2 2 0 002-2v-6M9 19h6m-6 0v-3m6 3v-3">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Add some products to get started!</p>
                <a href="{{ route('home') }}"
                    class="bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition">
                    Continue Shopping
                </a>
            </div>
        @else
            <!-- Advance Payment Notice -->
            @if ($advancePaymentSettings->advance_payment_status)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Advance Payment Required</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>{{ $advancePaymentSettings->note ?? 'An advance payment of ৳' . number_format(round((float) $advancePaymentSettings->advance_payment_amount), 0) . ' is required via Bkash before order confirmation.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Checkout Form -->
                <div>
                    <form id="checkout-form" class="space-y-6">
                        <!-- Shipping Address -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Address</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @guest
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $user->name ?? '') }}" required minlength="2"
                                            maxlength="255" pattern="[a-zA-Z\s]+"
                                            title="Name can only contain letters and spaces"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                            placeholder="Enter Your Full Name">
                                        @error('name')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Minimum 2 characters, letters and spaces only
                                        </p>
                                    </div>
                                @endguest

                                <div class="{{ Auth::check() ? 'md:col-span-2' : '' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <span class="text-gray-500 text-sm">+88</span>
                                        </div>
                                        <input type="tel" name="phone" id="phone"
                                            value="{{ old('phone', $user->phone ?? '') }}" required inputmode="numeric"
                                            maxlength="11" placeholder="0XXXXXXXXX"
                                            class="w-full border border-gray-300 rounded-lg pl-14 pr-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                                            aria-label="Bangladesh mobile number">
                                    </div>
                                    <div id="phone-validation-message" class="mt-1 text-xs"></div>
                                    <div id="phone-operator-name" class="mt-1 text-xs font-medium"></div>
                                    @error('phone')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Enter 11-digit Bangladesh mobile number
                                        starting with 0 (e.g., 01712345678)</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address
                                        <span class="text-red-500">*</span></label>
                                    <textarea id="address" name="address" rows="3" required placeholder="House no, Street, Area, City, etc."
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200 @error('address') border-red-500 @enderror"
                                        aria-label="Shipping address">{{ old('address', $user->address ?? '') }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- First Row: Division and District -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Division <span
                                            class="text-red-500">*</span></label>
                                    <select name="division" id="division" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('division') border-red-500 @enderror">
                                        <option value="">Select Division</option>
                                        <option value="Dhaka"
                                            {{ old('division', $user->state ?? '') == 'Dhaka' ? 'selected' : '' }}>Dhaka
                                        </option>
                                        <option value="Chittagong"
                                            {{ old('division', $user->state ?? '') == 'Chittagong' ? 'selected' : '' }}>
                                            Chittagong</option>
                                        <option value="Rajshahi"
                                            {{ old('division', $user->state ?? '') == 'Rajshahi' ? 'selected' : '' }}>
                                            Rajshahi</option>
                                        <option value="Khulna"
                                            {{ old('division', $user->state ?? '') == 'Khulna' ? 'selected' : '' }}>
                                            Khulna</option>
                                        <option value="Barisal"
                                            {{ old('division', $user->state ?? '') == 'Barisal' ? 'selected' : '' }}>
                                            Barisal</option>
                                        <option value="Sylhet"
                                            {{ old('division', $user->state ?? '') == 'Sylhet' ? 'selected' : '' }}>
                                            Sylhet</option>
                                        <option value="Rangpur"
                                            {{ old('division', $user->state ?? '') == 'Rangpur' ? 'selected' : '' }}>
                                            Rangpur</option>
                                        <option value="Mymensingh"
                                            {{ old('division', $user->state ?? '') == 'Mymensingh' ? 'selected' : '' }}>
                                            Mymensingh</option>
                                    </select>
                                    @error('division')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">District <span
                                            class="text-red-500">*</span></label>
                                    <select name="district" id="district" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('district') border-red-500 @enderror">
                                        <option value="">Select District</option>
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Please select a division first</p>
                                    @error('district')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Second Row: City and Postal Code -->
                                <div>
                                    <label for="city"
                                        class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input id="city" type="text" name="city"
                                        value="{{ old('city', $user->city ?? '') }}" placeholder="Optional"
                                        maxlength="100"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200 @error('city') border-red-500 @enderror"
                                        aria-label="City (optional)">
                                    @error('city')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code"
                                        class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                    <input id="postal_code" type="text" name="postal_code"
                                        value="{{ old('postal_code', $user->postal_code ?? '') }}"
                                        placeholder="Optional" maxlength="20"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200 @error('postal_code') border-red-500 @enderror"
                                        aria-label="Postal code (optional)">
                                    @error('postal_code')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Billing Address (Optional) -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold text-gray-900">Billing Address</h2>
                                <label class="flex items-center">
                                    <input type="checkbox" id="same-as-shipping" checked class="mr-2">
                                    <span class="text-sm text-gray-600">Same as shipping address</span>
                                </label>
                            </div>

                            <div id="billing-address" class="hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="billing_name"
                                            class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input id="billing_name" type="text" name="billing_address[name]"
                                            placeholder="Optional"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200"
                                            aria-label="Billing full name (optional)">
                                    </div>

                                    <div>
                                        <label for="billing_phone"
                                            class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input id="billing_phone" type="tel" name="billing_address[phone]"
                                            placeholder="Optional" pattern="[0-9]*" inputmode="numeric"
                                            maxlength="20"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200"
                                            aria-label="Billing phone number (optional)">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="billing_address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                        <textarea id="billing_address" name="billing_address[address]" rows="3"
                                            placeholder="Optional - Leave empty to use shipping address"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200"
                                            aria-label="Billing address (optional)"></textarea>
                                    </div>

                                    <div>
                                        <label for="billing_city"
                                            class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <input id="billing_city" type="text" name="billing_address[city]"
                                            placeholder="Optional" maxlength="100"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200"
                                            aria-label="Billing city (optional)">
                                    </div>

                                    <div>
                                        <label for="billing_postal_code"
                                            class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                        <input id="billing_postal_code" type="text"
                                            name="billing_address[postal_code]" placeholder="Optional" maxlength="20"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-colors duration-200"
                                            aria-label="Billing postal code (optional)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Method</h2>

                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" checked
                                        class="mr-3">
                                    <span class="text-gray-700">Cash on Delivery</span>
                                </label>

                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Notes (Optional)</h2>

                            <textarea name="notes" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                placeholder="Add any special instructions for your order..."></textarea>
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div>
                    <div class="bg-white rounded-lg shadow-sm sticky top-6">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>
                        </div>

                        <div class="p-6">
                            <!-- Cart Items Summary -->
                            <div class="space-y-4 mb-6">
                                @foreach ($cartItems as $item)
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if ($item->product->main_image)
                                                <img src="{{ $item->product->main_image }}"
                                                    alt="{{ $item->product->name }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                                    No Image</div>
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                                {{ $item->product->name }}</h4>
                                            @if ($item->variant)
                                                <p class="text-xs text-gray-500">
                                                    {{ $item->variant->color->name ?? '' }}
                                                    {{ $item->variant->size->name ?? '' }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                        </div>

                                        <div class="text-sm font-medium text-gray-900">
                                            ৳{{ number_format(round((float) $item->total_price), 0) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="border-gray-200 mb-4">

                            <!-- Coupon Code -->
                            <div id="coupon-area" class="mb-4">
                                <label for="coupon-code" class="block text-sm font-medium text-gray-700 mb-1">Have a
                                    coupon?</label>
                                <div class="flex space-x-2">
                                    <input type="text" id="coupon-code" name="coupon_code"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent"
                                        placeholder="Enter coupon code">
                                    <button type="button" id="apply-coupon-btn"
                                        class="bg-gray-800 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-900 transition">Apply</button>
                                </div>
                                <p id="coupon-message" class="text-sm mt-2"></p>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $cartCount }} items)</span>
                                    <span id="subtotal">৳{{ number_format(round((float) $cartTotal), 0) }}</span>
                                </div>

                                <!-- Discount Row (hidden by default, shown when coupon is applied) -->
                                <div id="discount-row" class="flex justify-between text-gray-600 hidden">
                                    <span>Discount</span>
                                    <span id="discount-amount" class="text-green-600">- ৳0</span>
                                </div>

                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span id="shipping"
                                        class="shipping shipping-charge">৳{{ number_format(round((float) $cartTotal) > 1000 ? 0 : round((float) $defaultShippingCharge), 0) }}</span>
                                </div>

                                <hr class="border-gray-200 my-2">

                                <div class="flex justify-between text-lg font-semibold text-gray-900">
                                    <span>Total</span>
                                    <span id="total-amount">
                                        ৳{{ number_format(round((float) $cartTotal) + (round((float) $cartTotal) > 1000 ? 0 : round((float) $defaultShippingCharge)), 0) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Advance Payment Section -->
                        @if ($advancePaymentSettings->advance_payment_status)
                            <div class="px-6 pb-6 border-t">
                                <div class="bg-white rounded-lg shadow-sm p-6" id="advance-payment-section">
                                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Advance Payment via Bkash</h2>

                                    @if ($advancePaymentSettings->note)
                                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                            <p class="text-sm text-gray-700">{{ $advancePaymentSettings->note }}</p>
                                        </div>
                                    @endif

                                    <div class="space-y-4">
                                        <div>
                                            <label for="bkash_number"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Bkash Mobile Number <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <span class="text-gray-500 text-sm">+88</span>
                                                </div>
                                                <input type="tel" name="bkash_number" id="bkash_number" required
                                                    inputmode="numeric" maxlength="11" placeholder="01XXXXXXXXX"
                                                    pattern="01[3-9]\d{8}"
                                                    class="w-full border border-gray-300 rounded-lg pl-14 pr-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('bkash_number') border-red-500 @enderror"
                                                    aria-label="Bkash mobile number">
                                            </div>
                                            <div id="bkash-validation-message" class="mt-1 text-xs"></div>
                                            @error('bkash_number')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-gray-500">Enter 11-digit Bkash mobile number
                                                starting with 01 (e.g., 01712345678)</p>
                                        </div>

                                        <div>
                                            <label for="transaction_id"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Transaction ID <span class="text-red-500">*</span>
                                            </label>
                                            <input type="text" name="transaction_id" id="transaction_id" required
                                                maxlength="100" placeholder="Enter Bkash transaction ID"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent @error('transaction_id') border-red-500 @enderror"
                                                aria-label="Bkash transaction ID">
                                            @error('transaction_id')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-gray-500">Enter the transaction ID received
                                                after
                                                making payment via Bkash</p>
                                        </div>

                                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                            <p class="text-sm text-amber-800">
                                                <strong>Advance Payment Amount:</strong>
                                                ৳<span
                                                    id="advance-payment-amount-display">{{ number_format(round((float) $advancePaymentSettings->advance_payment_amount), 0) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="p-6 border-t">
                            <button id="place-order"
                                class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition">
                                Place Order
                            </button>

                            <a href="{{ route('cart.index') }}"
                                class="w-full bg-gray-100 text-gray-900 py-3 px-6 rounded-lg font-medium hover:bg-gray-200 transition text-center block mt-3">
                                Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Checkout page JavaScript loaded');

                // Restrict phone input to numbers only
                const phoneInput = document.getElementById('phone');
                const billingPhoneInput = document.getElementById('billing_phone');

                // Function to restrict input to numbers only
                function restrictToNumbers(input) {
                    if (!input) return;

                    // Prevent non-numeric input
                    input.addEventListener('input', function(e) {
                        // Remove any non-numeric characters
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });

                    // Prevent paste of non-numeric content
                    input.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                        const numericOnly = pastedText.replace(/[^0-9]/g, '');
                        this.value = numericOnly;
                    });

                    // Prevent non-numeric keypress
                    input.addEventListener('keypress', function(e) {
                        const char = String.fromCharCode(e.which);
                        if (!/[0-9]/.test(char)) {
                            e.preventDefault();
                        }
                    });
                }

                // Apply restrictions to both phone inputs
                restrictToNumbers(phoneInput);
                restrictToNumbers(billingPhoneInput);

                // Division and district dropdown functionality
                const divisionSelect = document.getElementById('division');
                const districtSelect = document.getElementById('district');
                const shippingElement = document.getElementById('shipping') || document.querySelector(
                    '.shipping-charge');
                const totalAmountElement = document.getElementById('total-amount');
                const subtotalElement = document.getElementById('subtotal');

                // Verify critical DOM elements exist
                if (!shippingElement) {
                    console.error('Critical error: Shipping element (#shipping or .shipping-charge) not found in DOM');
                }
                if (!totalAmountElement) {
                    console.error('Critical error: Total amount element (#total-amount) not found in DOM');
                }
                if (!subtotalElement) {
                    console.error('Critical error: Subtotal element (#subtotal) not found in DOM');
                }

                // Store current shipping charge
                let currentShippingCharge = 0;
                // Initialize with database value from server
                let defaultShippingCharge = {{ $defaultShippingCharge }};

                // Function to fetch default shipping charge from API (updates the value)
                async function fetchDefaultShippingCharge() {
                    try {
                        const response = await fetch('{{ url('/api/shipping/default-charge') }}', {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            defaultShippingCharge = data.default_shipping_charge;
                            // Update display if no division/district is selected
                            if (!divisionSelect || !divisionSelect.value || !districtSelect || !districtSelect
                                .value) {
                                const advancePaymentSettings = @json($advancePaymentSettings);
                                const advanceCharge = (advancePaymentSettings && advancePaymentSettings
                                        .advance_payment_status) ?
                                    parseFloat(advancePaymentSettings.advance_payment_amount || 0) :
                                    0;
                                const advanceRequired = advancePaymentSettings && advancePaymentSettings
                                    .advance_payment_status;
                                updateShippingDisplay(defaultShippingCharge, advanceCharge, advanceRequired);
                            }
                        } else {
                            console.error('Error fetching default shipping charge:', data.error);
                        }
                    } catch (error) {
                        console.error('Error fetching default shipping charge:', error);
                    }
                }

                // Fetch default shipping charge on page load
                fetchDefaultShippingCharge();

                // Function to show loading state for district dropdown
                function setDistrictLoading(loading) {
                    if (loading) {
                        districtSelect.innerHTML = '<option value="">Loading districts...</option>';
                        districtSelect.disabled = true;
                    } else {
                        districtSelect.disabled = false;
                    }
                }

                // Function to populate districts via API
                async function populateDistricts(division) {
                    if (!division) {
                        districtSelect.innerHTML = '<option value="">Select District</option>';
                        return;
                    }

                    setDistrictLoading(true);

                    try {
                        const response = await fetch(
                            `{{ url('/api/shipping/districts') }}?division_name=${encodeURIComponent(division)}`, {
                                method: 'GET',
                                headers: {
                                    'Accept': 'application/json',
                                }
                            });

                        const data = await response.json();

                        districtSelect.innerHTML = '<option value="">Select District</option>';

                        if (data.success && data.districts && data.districts.length > 0) {
                            data.districts.forEach(district => {
                                const option = document.createElement('option');
                                option.value = district;
                                option.textContent = district;
                                districtSelect.appendChild(option);
                            });
                        } else {
                            districtSelect.innerHTML = '<option value="">No districts available</option>';
                        }
                    } catch (error) {
                        console.error('Error fetching districts:', error);
                        districtSelect.innerHTML = '<option value="">Error loading districts</option>';
                        showNotification('Failed to load districts. Please try again.', 'error');
                    } finally {
                        setDistrictLoading(false);
                    }
                }

                // Function to calculate and update shipping charge
                async function calculateShippingCharge() {
                    const division = divisionSelect.value;
                    const district = districtSelect.value;

                    if (!division) {
                        // Reset to 0 shipping if no division selected
                        updateShippingDisplay(0, 0, false);
                        return;
                    }

                    if (!district) {
                        // Use default shipping charge if division selected but no district
                        updateShippingDisplay(defaultShippingCharge, 0, false);
                        return;
                    }

                    try {
                        const response = await fetch('{{ route('shipping.calculate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                division: division,
                                district: district,
                                division_name: division, // For backward compatibility
                                zone_name: district // For backward compatibility
                            })
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const data = await response.json();

                        // Always update with shipping_charge, even if success is false (fallback values provided)
                        if (data.shipping_charge !== undefined) {
                            const advanceCharge = data.advance_charge || 0;
                            const advanceRequired = data.advance_required || false;
                            updateShippingDisplay(data.shipping_charge, advanceCharge, advanceRequired);
                        } else {
                            console.error('Error: shipping_charge not in response', data);
                            updateShippingDisplay(defaultShippingCharge, 0, false);
                            showNotification('Failed to calculate shipping charge. Using default.', 'error');
                        }

                        // Log error if success is false, but still use the provided values
                        if (!data.success && data.error) {
                            console.warn('Shipping calculation warning:', data.error);
                        }
                    } catch (error) {
                        console.error('Error calculating shipping charge:', error);
                        updateShippingDisplay(defaultShippingCharge, 0, false);
                        showNotification('Failed to calculate shipping charge. Using default.', 'error');
                    }
                }

                // Function to update shipping display and total
                function updateShippingDisplay(charge, advanceCharge = 0, advanceRequired = false) {
                    currentShippingCharge = charge;

                    // Verify shipping element exists
                    if (!shippingElement) {
                        console.error('Shipping element not found in DOM');
                        return;
                    }

                    // Update shipping display
                    if (charge === 0) {
                        shippingElement.textContent = '0';
                    } else {
                        shippingElement.textContent = `৳${charge.toFixed(0)}`;
                    }

                    // Calculate new total (subtotal + shipping)
                    const subtotalText = subtotalElement.textContent.replace('৳', '').replace(/,/g, '');
                    const subtotal = parseFloat(subtotalText) || 0;
                    const newTotal = subtotal + currentShippingCharge;

                    // Update total amount
                    totalAmountElement.textContent = `৳${newTotal.toFixed(0)}`;

                    // Get or create advance payment elements
                    let advancePaymentElement = document.getElementById('advance-payment');
                    let advancePaymentRow = null;
                    let dueAmountElement = document.getElementById('due-amount');
                    let dueAmountRow = null;
                    let advanceHr = null;

                    if (advancePaymentElement) {
                        advancePaymentRow = advancePaymentElement.closest('.flex.justify-between');
                    }
                    if (dueAmountElement) {
                        dueAmountRow = dueAmountElement.closest('.flex.justify-between');
                    }

                    // Find the HR separator if it exists (it's between advance payment and due amount)
                    const priceBreakdown = document.querySelector('.space-y-2.text-sm');
                    if (priceBreakdown) {
                        if (advancePaymentRow && dueAmountRow) {
                            // HR should be between advance payment and due amount
                            let current = advancePaymentRow.nextElementSibling;
                            while (current && current !== dueAmountRow) {
                                if (current.tagName === 'HR') {
                                    advanceHr = current;
                                    break;
                                }
                                current = current.nextElementSibling;
                            }
                        } else {
                            // Look for any HR in price breakdown (should be the one after total)
                            const hrElements = priceBreakdown.querySelectorAll('hr');
                            if (hrElements.length > 0) {
                                advanceHr = hrElements[hrElements.length - 1];
                            }
                        }
                    }

                    if (advanceRequired && advanceCharge > 0) {
                        // Show and update advance payment section
                        if (advancePaymentElement && advancePaymentRow) {
                            // Elements exist in DOM, just update values and show them
                            advancePaymentElement.textContent = `- ৳${advanceCharge.toFixed(0)}`;
                            advancePaymentRow.style.display = 'flex';
                        } else {
                            // Create advance payment row if it doesn't exist
                            if (priceBreakdown) {
                                // Create advance payment row
                                advancePaymentRow = document.createElement('div');
                                advancePaymentRow.className = 'flex justify-between text-gray-600';
                                advancePaymentRow.innerHTML = `
                            <span>Advance Payment</span>
                            <span id="advance-payment">- ৳${advanceCharge.toFixed(0)}</span>
                        `;
                                advancePaymentElement = document.getElementById('advance-payment');

                                // Create HR separator
                                advanceHr = document.createElement('hr');
                                advanceHr.className = 'border-gray-200 my-2';

                                // Create due amount row
                                dueAmountRow = document.createElement('div');
                                dueAmountRow.className = 'flex justify-between text-lg font-semibold text-gray-900';
                                const dueAmount = newTotal - advanceCharge;
                                dueAmountRow.innerHTML = `
                            <span>Due Amount</span>
                            <span id="due-amount">৳${dueAmount.toFixed(0)}</span>
                        `;
                                dueAmountElement = document.getElementById('due-amount');

                                // Insert after the total row
                                const totalRow = totalAmountElement.closest('.flex.justify-between');
                                if (totalRow && totalRow.parentElement) {
                                    // Insert in order: Advance Payment, HR, Due Amount (all after Total)
                                    totalRow.parentElement.insertBefore(advancePaymentRow, totalRow.nextSibling);
                                    totalRow.parentElement.insertBefore(advanceHr, advancePaymentRow.nextSibling);
                                    totalRow.parentElement.insertBefore(dueAmountRow, advanceHr.nextSibling);
                                }
                            }
                        }

                        // Always update due amount (recalculate based on new total)
                        if (dueAmountElement) {
                            const dueAmount = newTotal - advanceCharge;
                            dueAmountElement.textContent = `৳${dueAmount.toFixed(0)}`;
                            if (dueAmountRow) {
                                dueAmountRow.style.display = 'flex';
                            }
                        }

                        // Ensure HR is visible
                        if (advanceHr) {
                            advanceHr.style.display = 'block';
                        }
                    } else {
                        // Hide advance payment section if not required
                        if (advancePaymentRow) {
                            advancePaymentRow.style.display = 'none';
                        }
                        if (dueAmountRow) {
                            dueAmountRow.style.display = 'none';
                        }
                        if (advanceHr) {
                            advanceHr.style.display = 'none';
                        }
                    }

                    // Debug log for verification
                    console.log('Order Summary Updated:', {
                        shipping: charge,
                        subtotal: subtotal,
                        total: newTotal,
                        advanceCharge: advanceCharge,
                        advanceRequired: advanceRequired,
                        dueAmount: advanceRequired && advanceCharge > 0 ? newTotal - advanceCharge : newTotal
                    });
                }

                // Set initial district if division is pre-selected
                const initialDivision = divisionSelect.value;
                if (initialDivision) {
                    populateDistricts(initialDivision).then(() => {
                        // Set district value if it exists in old data
                        const oldDistrict = '{{ old('district', $user->city ?? '') }}';
                        if (oldDistrict) {
                            districtSelect.value = oldDistrict;
                            // Calculate initial shipping charge
                            calculateShippingCharge();
                        } else {
                            // If division selected but no district, use default shipping
                            updateShippingDisplay(defaultShippingCharge, 0, false);
                        }
                    });
                } else {
                    // If no division selected, use default shipping charge
                    // Get advance payment settings from initial page load
                    const advancePaymentSettings = @json($advancePaymentSettings);
                    const advanceCharge = (advancePaymentSettings && advancePaymentSettings.advance_payment_status) ?
                        parseFloat(advancePaymentSettings.advance_payment_amount || 0) :
                        0;
                    const advanceRequired = advancePaymentSettings && advancePaymentSettings.advance_payment_status;
                    updateShippingDisplay(defaultShippingCharge, advanceCharge, advanceRequired);
                }

                // Event listener for division change
                divisionSelect.addEventListener('change', function() {
                    const selectedDivision = this.value;
                    // Remove error styling when division is selected
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-500');

                    populateDistricts(selectedDivision);
                    // Reset district selection and calculate shipping
                    districtSelect.value = '';
                    districtSelect.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
                    calculateShippingCharge();
                });

                // Event listener for district change
                districtSelect.addEventListener('change', function() {
                    // Remove error styling when district is selected
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
                    calculateShippingCharge();
                });

                // Bangladeshi Mobile Operators Configuration
                const bdMobileOperators = [{
                        name: 'Grameenphone',
                        code: 'GP',
                        starting_numbers: ['013', '017']
                    },
                    {
                        name: 'Robi',
                        code: 'Robi',
                        starting_numbers: ['018']
                    },
                    {
                        name: 'Airtel',
                        code: 'Airtel',
                        starting_numbers: ['016']
                    },
                    {
                        name: 'Banglalink',
                        code: 'Banglalink',
                        starting_numbers: ['019', '014']
                    },
                    {
                        name: 'Teletalk',
                        code: 'Teletalk',
                        starting_numbers: ['015']
                    }
                ];

                // Phone number validation function
                function validateBangladeshMobile(phoneNumber) {
                    // Remove any spaces or dashes
                    const cleaned = phoneNumber.replace(/[\s-]/g, '');

                    // Check if it starts with +88 and remove it
                    let number = cleaned.startsWith('+88') ? cleaned.substring(3) : cleaned;

                    // Must be exactly 11 digits starting with 0
                    if (!/^0\d{10}$/.test(number)) {
                        return {
                            valid: false,
                            operator: null,
                            message: 'Phone number must be 11 digits starting with 0'
                        };
                    }

                    // Extract operator code (digits 2-4, i.e., positions 1-3 after the leading 0)
                    // Format: 0 + 13/14/15/16/17/18/19 + 7 more digits
                    const operatorCode = '0' + number.substring(1, 3); // Get digits 1-3 (e.g., "013", "017")

                    // Find matching operator
                    const operator = bdMobileOperators.find(op =>
                        op.starting_numbers.includes(operatorCode)
                    );

                    if (operator) {
                        return {
                            valid: true,
                            operator: operator.name,
                            message: 'Valid Bangladesh mobile number',
                            fullNumber: '+88' + number
                        };
                    } else {
                        return {
                            valid: false,
                            operator: null,
                            message: 'Invalid operator prefix. Must start with 013, 014, 015, 016, 017, 018, or 019'
                        };
                    }
                }

                // Phone input validation with real-time feedback
                // Reuse phoneInput declared earlier (line 368)
                const phoneValidationMessage = document.getElementById('phone-validation-message');
                const phoneOperatorName = document.getElementById('phone-operator-name');

                // Format phone input - only allow digits (phoneInput already declared above)
                if (phoneInput) {
                    phoneInput.addEventListener('input', function(e) {
                        // Remove any non-digit characters
                        let value = e.target.value.replace(/\D/g, '');

                        // Limit to 11 digits
                        if (value.length > 11) {
                            value = value.substring(0, 11);
                        }

                        e.target.value = value;

                        // Real-time validation
                        if (value.length === 0) {
                            if (phoneValidationMessage) phoneValidationMessage.textContent = '';
                            if (phoneOperatorName) phoneOperatorName.textContent = '';
                            phoneInput.classList.remove('border-red-500', 'border-green-500');
                            return;
                        }

                        const validation = validateBangladeshMobile(value);

                        if (validation.valid) {
                            phoneInput.classList.remove('border-red-500');
                            phoneInput.classList.add('border-green-500');
                            if (phoneValidationMessage) {
                                phoneValidationMessage.textContent = '';
                                phoneValidationMessage.classList.remove('text-red-600');
                            }
                            if (phoneOperatorName) {
                                phoneOperatorName.textContent = `✓ ${validation.operator}`;
                                phoneOperatorName.classList.remove('text-red-600');
                                phoneOperatorName.classList.add('text-green-600');
                            }
                        } else {
                            phoneInput.classList.remove('border-green-500');
                            if (value.length >= 3) {
                                phoneInput.classList.add('border-red-500');
                                if (phoneValidationMessage) {
                                    phoneValidationMessage.textContent = validation.message;
                                    phoneValidationMessage.classList.add('text-red-600');
                                }
                            } else {
                                phoneInput.classList.remove('border-red-500');
                                if (phoneValidationMessage) phoneValidationMessage.textContent = '';
                            }
                            if (phoneOperatorName) phoneOperatorName.textContent = '';
                        }
                    });

                    // Validate on blur
                    phoneInput.addEventListener('blur', function() {
                        const value = this.value.replace(/\D/g, '');
                        if (value.length > 0 && value.length < 11) {
                            phoneInput.classList.add('border-red-500');
                            if (phoneValidationMessage) {
                                phoneValidationMessage.textContent =
                                    'Phone number must be 11 digits starting with 0';
                                phoneValidationMessage.classList.add('text-red-600');
                            }
                        } else if (value.length === 11 && !value.startsWith('0')) {
                            phoneInput.classList.add('border-red-500');
                            if (phoneValidationMessage) {
                                phoneValidationMessage.textContent = 'Phone number must start with 0';
                                phoneValidationMessage.classList.add('text-red-600');
                            }
                        }
                    });
                }

                // Bkash number input validation (if advance payment is enabled)
                const bkashNumberInput = document.getElementById('bkash_number');
                const bkashValidationMessage = document.getElementById('bkash-validation-message');
                const advancePaymentEnabled = {{ $advancePaymentSettings->advance_payment_status ? 'true' : 'false' }};

                if (advancePaymentEnabled && bkashNumberInput) {
                    // Restrict to numbers only
                    bkashNumberInput.addEventListener('input', function(e) {
                        // Remove any non-digit characters
                        let value = e.target.value.replace(/\D/g, '');

                        // Limit to 11 digits
                        if (value.length > 11) {
                            value = value.substring(0, 11);
                        }

                        e.target.value = value;

                        // Real-time validation
                        if (value.length === 0) {
                            if (bkashValidationMessage) bkashValidationMessage.textContent = '';
                            bkashNumberInput.classList.remove('border-red-500', 'border-green-500');
                            return;
                        }

                        // Bkash numbers start with 01 (013, 014, 015, 016, 017, 018, 019)
                        if (/^01[3-9]\d{8}$/.test(value)) {
                            bkashNumberInput.classList.remove('border-red-500');
                            bkashNumberInput.classList.add('border-green-500');
                            if (bkashValidationMessage) {
                                bkashValidationMessage.textContent = '✓ Valid Bkash number';
                                bkashValidationMessage.classList.remove('text-red-600');
                                bkashValidationMessage.classList.add('text-green-600');
                            }
                        } else {
                            bkashNumberInput.classList.remove('border-green-500');
                            if (value.length >= 2) {
                                if (!value.startsWith('01')) {
                                    bkashNumberInput.classList.add('border-red-500');
                                    if (bkashValidationMessage) {
                                        bkashValidationMessage.textContent = 'Bkash number must start with 01';
                                        bkashValidationMessage.classList.add('text-red-600');
                                        bkashValidationMessage.classList.remove('text-green-600');
                                    }
                                } else if (value.length === 11) {
                                    bkashNumberInput.classList.add('border-red-500');
                                    if (bkashValidationMessage) {
                                        bkashValidationMessage.textContent = 'Invalid Bkash number format';
                                        bkashValidationMessage.classList.add('text-red-600');
                                        bkashValidationMessage.classList.remove('text-green-600');
                                    }
                                }
                            } else {
                                bkashNumberInput.classList.remove('border-red-500');
                                if (bkashValidationMessage) bkashValidationMessage.textContent = '';
                            }
                        }
                    });

                    // Validate on blur
                    bkashNumberInput.addEventListener('blur', function() {
                        const value = this.value.replace(/\D/g, '');
                        if (value.length > 0 && value.length < 11) {
                            bkashNumberInput.classList.add('border-red-500');
                            if (bkashValidationMessage) {
                                bkashValidationMessage.textContent = 'Bkash number must be 11 digits';
                                bkashValidationMessage.classList.add('text-red-600');
                            }
                        } else if (value.length === 11 && !/^01[3-9]\d{8}$/.test(value)) {
                            bkashNumberInput.classList.add('border-red-500');
                            if (bkashValidationMessage) {
                                bkashValidationMessage.textContent =
                                    'Invalid Bkash number format. Must start with 01 (013-019).';
                                bkashValidationMessage.classList.add('text-red-600');
                            }
                        }
                    });
                }

                // Toggle billing address
                const sameAsShippingCheckbox = document.getElementById('same-as-shipping');
                const billingAddress = document.getElementById('billing-address');

                sameAsShippingCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        billingAddress.classList.add('hidden');
                        // Clear billing address fields when using shipping address
                        const billingInputs = billingAddress.querySelectorAll('input, textarea');
                        billingInputs.forEach(input => {
                            input.value = '';
                            input.removeAttribute('required');
                        });
                    } else {
                        billingAddress.classList.remove('hidden');
                    }
                });

                // Prevent form submission on Enter key
                const form = document.getElementById('checkout-form');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    document.getElementById('place-order').click();
                });

                // Place order
                document.getElementById('place-order').addEventListener('click', function(e) {
                    e.preventDefault();

                    // Get all form fields
                    const division = divisionSelect ? divisionSelect.value : '';
                    const district = districtSelect ? districtSelect.value : '';
                    const addressTextarea = document.getElementById('address');
                    // Reuse phoneInput declared earlier (line 368)
                    const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');

                    // Guest user fields
                    const nameInput = document.getElementById('name');
                    const isGuest = {{ Auth::check() ? 'false' : 'true' }};

                    // Remove previous error styling from all fields
                    const allInputs = form.querySelectorAll('input, textarea, select');
                    allInputs.forEach(input => {
                        input.classList.remove('border-red-500', 'ring-2', 'ring-red-500');
                    });

                    let hasError = false;
                    let firstErrorField = null;

                    // Validate guest user fields
                    if (isGuest) {
                        if (!nameInput || !nameInput.value || nameInput.value.trim() === '') {
                            showNotification('Please enter your full name.', 'error');
                            if (nameInput) {
                                nameInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                                if (!firstErrorField) firstErrorField = nameInput;
                            }
                            hasError = true;
                        } else {
                            // Validate name format (letters and spaces only)
                            const nameValue = nameInput.value.trim();
                            const nameRegex = /^[a-zA-Z\s]+$/;
                            if (!nameRegex.test(nameValue)) {
                                showNotification('Full name can only contain letters and spaces.', 'error');
                                nameInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                                if (!firstErrorField) firstErrorField = nameInput;
                                hasError = true;
                            } else if (nameValue.length < 2) {
                                showNotification('Full name must be at least 2 characters.', 'error');
                                nameInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                                if (!firstErrorField) firstErrorField = nameInput;
                                hasError = true;
                            }
                        }
                    }

                    // Validate phone number (required for all users) - Bangladesh mobile validation
                    // phoneInput is declared earlier (line 368)
                    if (!phoneInput || !phoneInput.value || phoneInput.value.trim() === '') {
                        showNotification('Please enter your Bangladesh mobile number.', 'error');
                        if (phoneInput) {
                            phoneInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                            if (!firstErrorField) firstErrorField = phoneInput;
                        }
                        hasError = true;
                    } else {
                        const phoneValue = phoneInput.value.replace(/\D/g, ''); // Remove non-digits
                        const validation = validateBangladeshMobile(phoneValue);

                        if (!validation.valid) {
                            showNotification(validation.message ||
                                'Please enter a valid Bangladesh mobile number (11 digits starting with 1).',
                                'error');
                            if (phoneInput) {
                                phoneInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                                if (!firstErrorField) firstErrorField = phoneInput;
                            }
                            if (phoneValidationMessage) {
                                phoneValidationMessage.textContent = validation.message;
                                phoneValidationMessage.classList.add('text-red-600');
                            }
                            hasError = true;
                        } else {
                            // Store the 11-digit number (without +88) for backend
                            // Backend will handle normalization
                            phoneInput.value = validation.fullNumber.replace('+88', '');
                        }
                    }

                    // Validate division (required)
                    if (!division || division === '') {
                        showNotification('Please select a division before placing your order.', 'error');
                        divisionSelect.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                        if (!firstErrorField) firstErrorField = divisionSelect;
                        hasError = true;
                    }

                    // Validate district (required)
                    if (!district || district === '') {
                        showNotification('Please select a district before placing your order.', 'error');
                        districtSelect.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                        if (!firstErrorField) firstErrorField = districtSelect;
                        hasError = true;
                    }

                    // Validate address (required)
                    if (!addressTextarea || !addressTextarea.value || addressTextarea.value.trim() === '') {
                        showNotification('Please enter your shipping address.', 'error');
                        addressTextarea.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                        if (!firstErrorField) firstErrorField = addressTextarea;
                        hasError = true;
                    }

                    // Validate payment method (required)
                    if (!paymentMethodInput) {
                        showNotification('Please select a payment method.', 'error');
                        hasError = true;
                    }

                    // Validate Bkash fields if advance payment is enabled
                    if (advancePaymentEnabled) {
                        const bkashNumberInput = document.getElementById('bkash_number');
                        const transactionIdInput = document.getElementById('transaction_id');
                        const bkashValidationMessage = document.getElementById('bkash-validation-message');

                        // Validate Bkash number
                        if (!bkashNumberInput || !bkashNumberInput.value || bkashNumberInput.value.trim() ===
                            '') {
                            showNotification('Please enter your Bkash mobile number.', 'error');
                            if (bkashNumberInput) {
                                bkashNumberInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                                if (!firstErrorField) firstErrorField = bkashNumberInput;
                            }
                            hasError = true;
                        } else {
                            const bkashValue = bkashNumberInput.value.replace(/\D/g, '');
                            // Bkash numbers start with 01 (013, 014, 015, 016, 017, 018, 019)
                            if (!/^01[3-9]\d{8}$/.test(bkashValue)) {
                                showNotification(
                                    'Please enter a valid Bkash mobile number (11 digits starting with 01, e.g., 01712345678).',
                                    'error');
                                bkashNumberInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                                if (bkashValidationMessage) {
                                    bkashValidationMessage.textContent =
                                        'Invalid Bkash number format. Must start with 01 (013-019).';
                                    bkashValidationMessage.classList.add('text-red-600');
                                }
                                if (!firstErrorField) firstErrorField = bkashNumberInput;
                                hasError = true;
                            } else {
                                bkashNumberInput.classList.remove('border-red-500');
                                bkashNumberInput.classList.add('border-green-500');
                                if (bkashValidationMessage) {
                                    bkashValidationMessage.textContent = '';
                                }
                            }
                        }

                        // Validate Transaction ID
                        if (!transactionIdInput || !transactionIdInput.value || transactionIdInput.value
                            .trim() === '') {
                            showNotification('Please enter the Bkash transaction ID.', 'error');
                            if (transactionIdInput) {
                                transactionIdInput.classList.add('border-red-500', 'ring-2', 'ring-red-500');
                                if (!firstErrorField) firstErrorField = transactionIdInput;
                            }
                            hasError = true;
                        } else {
                            transactionIdInput.classList.remove('border-red-500');
                        }
                    }

                    // If there are errors, focus on the first error field and stop
                    if (hasError) {
                        if (firstErrorField) {
                            firstErrorField.focus();
                            firstErrorField.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                        return;
                    }

                    const formData = new FormData(form);

                    // Convert form data to JSON with proper nested structure
                    const data = {};

                    // Helper function to set nested property
                    const setNestedValue = (obj, path, value) => {
                        const keys = path.split('.');
                        const lastKey = keys.pop();
                        const lastObj = keys.reduce((obj, key) => {
                            if (!obj[key]) obj[key] = {};
                            return obj[key];
                        }, obj);
                        lastObj[lastKey] = value;
                    };

                    // Process form data
                    for (let [key, value] of formData.entries()) {
                        // Skip email field completely (not used in checkout)
                        if (key === 'email') {
                            continue;
                        }

                        // Skip other empty values (but allow '0' as valid value)
                        if (!value && value !== '0') continue;

                        // Handle array notation like billing_address[name]
                        const matches = key.match(/^([^\[]+)\[([^\]]+)\]$/);
                        if (matches) {
                            const [, prefix, field] = matches;
                            if (!data[prefix]) data[prefix] = {};
                            data[prefix][field] = value;
                        } else {
                            data[key] = value;
                        }

                        // Debug log
                        console.log(`Form field: ${key} = ${value}`);
                    }

                    // Manually add Bkash fields if advance payment is enabled (they're outside the form)
                    if (advancePaymentEnabled) {
                        const bkashNumberInput = document.getElementById('bkash_number');
                        const transactionIdInput = document.getElementById('transaction_id');

                        if (bkashNumberInput && bkashNumberInput.value) {
                            // Normalize bkash number (remove any non-digit characters)
                            const bkashValue = bkashNumberInput.value.replace(/\D/g, '');
                            data.bkash_number = bkashValue;
                            console.log(`Bkash field: bkash_number = ${bkashValue}`);
                        }

                        if (transactionIdInput && transactionIdInput.value) {
                            data.transaction_id = transactionIdInput.value.trim();
                            console.log(`Bkash field: transaction_id = ${data.transaction_id}`);
                        }
                    }

                    // Update field names for backend compatibility
                    // Map address to shipping_address for backend
                    if (data.address) {
                        data.shipping_address = data.address;
                    }
                    // Map division to state and district to city for existing backend logic
                    if (data.division) {
                        data.state = data.division;
                    }
                    if (data.district) {
                        data.city = data.district;
                    }

                    // Handle billing address - if "same as shipping" is checked, don't send billing address
                    // Backend will use shipping address as default
                    if (sameAsShippingCheckbox.checked) {
                        delete data.billing_address;
                    } else {
                        // If billing address is provided but all fields are empty, remove it
                        if (data.billing_address) {
                            const hasBillingData = Object.values(data.billing_address).some(val => val && val
                                .trim() !== '');
                            if (!hasBillingData) {
                                delete data.billing_address;
                            }
                        }
                    }

                    // Add loading state
                    const button = this;
                    const originalText = button.textContent;
                    button.disabled = true;
                    button.innerHTML =
                        '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Processing...';

                    // Debug log the final data being sent
                    console.log('Sending data to server:', JSON.stringify(data, null, 2));

                    // Make API call
                    fetch('{{ route('checkout.process') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(data),
                        })
                        .then(async response => {
                            // Always try to parse JSON first
                            let responseData;
                            try {
                                responseData = await response.json();
                            } catch (e) {
                                // If JSON parsing fails, create a generic error
                                throw {
                                    status: response.status,
                                    data: {
                                        message: 'An error occurred. Please try again.'
                                    }
                                };
                            }

                            // Check if response is ok
                            if (!response.ok) {
                                // Handle validation errors (422) or other errors
                                throw {
                                    status: response.status,
                                    data: responseData
                                };
                            }

                            return responseData;
                        })
                        .then(data => {
                            if (data.success) {
                                // Redirect to order confirmation
                                if (data.redirect) {
                                    window.location.href = data.redirect;
                                } else {
                                    showNotification('Order placed successfully!', 'success');
                                    button.disabled = false;
                                    button.textContent = originalText;
                                }
                            } else {
                                showNotification(data.message || 'Failed to place order', 'error');
                                button.disabled = false;
                                button.textContent = originalText;
                            }
                        })
                        .catch(error => {
                            console.error('Error placing order:', error);

                            // Handle validation errors (422)
                            if (error.status === 422 && error.data) {
                                // Display validation errors
                                const errorMessages = [];
                                const errorFields = {};

                                // Check if errors object exists
                                if (error.data.errors) {
                                    // Collect all validation errors
                                    Object.keys(error.data.errors).forEach(field => {
                                        const fieldErrors = error.data.errors[field];
                                        if (Array.isArray(fieldErrors) && fieldErrors.length > 0) {
                                            errorMessages.push(fieldErrors[0]);

                                            // Map field names to actual form fields
                                            let fieldElement = null;
                                            if (field === 'name') {
                                                fieldElement = document.getElementById('name');
                                            } else if (field === 'phone') {
                                                // Reuse phoneInput declared earlier (line 368)
                                                fieldElement = phoneInput;
                                                // Also update phone validation message
                                                if (phoneValidationMessage) {
                                                    phoneValidationMessage.textContent =
                                                        fieldErrors[0];
                                                    phoneValidationMessage.classList.add(
                                                        'text-red-600');
                                                    phoneValidationMessage.classList.remove(
                                                        'text-green-600');
                                                }
                                            } else if (field === 'address' || field ===
                                                'shipping_address') {
                                                fieldElement = document.getElementById('address');
                                            } else if (field === 'division') {
                                                fieldElement = document.getElementById('division');
                                            } else if (field === 'district') {
                                                fieldElement = document.getElementById('district');
                                            } else if (field === 'payment_method') {
                                                fieldElement = document.querySelector(
                                                    'input[name="payment_method"]:checked');
                                            }

                                            if (fieldElement) {
                                                fieldElement.classList.add('border-red-500',
                                                    'ring-2',
                                                    'ring-red-500');
                                                errorFields[field] = fieldElement;
                                            }
                                        }
                                    });
                                }

                                // Show error message - prioritize validation errors, then general message
                                if (errorMessages.length > 0) {
                                    // Show all error messages or just the first one
                                    const displayMessage = errorMessages.length === 1 ?
                                        errorMessages[0] :
                                        errorMessages.join('. ');
                                    showNotification(displayMessage, 'error');

                                    // Focus on first error field
                                    const firstErrorField = Object.values(errorFields)[0];
                                    if (firstErrorField) {
                                        firstErrorField.focus();
                                        firstErrorField.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'center'
                                        });
                                    }
                                } else if (error.data.message) {
                                    // Fallback to general error message
                                    showNotification(error.data.message, 'error');
                                } else {
                                    showNotification('Validation failed. Please check your input.',
                                        'error');
                                }
                            } else {
                                // Handle other errors
                                const errorMessage = (error.data && error.data.message) ?
                                    error.data.message :
                                    'Failed to place order. Please try again.';
                                showNotification(errorMessage, 'error');
                            }

                            button.disabled = false;
                            button.textContent = originalText;
                        });
                });

                // Apply coupon
                document.getElementById('apply-coupon-btn').addEventListener('click', function() {
                    const couponCode = document.getElementById('coupon-code').value;
                    const couponMessage = document.getElementById('coupon-message');
                    const button = this;

                    button.disabled = true;
                    button.textContent = 'Applying...';
                    couponMessage.textContent = '';

                    fetch('{{ route('coupon.apply') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                coupon_code: couponCode
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                couponMessage.classList.add('text-green-600');
                                couponMessage.classList.remove('text-red-600', 'text-accent');
                                couponMessage.textContent = data.message;

                                document.getElementById('discount-row').classList.remove('hidden');
                                document.getElementById('discount-amount').textContent = '- ৳' + Math.round(
                                    parseFloat(data.discount)).toLocaleString();

                                document.getElementById('total-amount').textContent = '৳' + Math.round(
                                    parseFloat(data.new_total)).toLocaleString();

                                const advancePaymentElement = document.getElementById('advance-payment');
                                if (advancePaymentElement) {
                                    const advancePayment = parseFloat(advancePaymentElement.textContent
                                        .replace('- ৳', '').replace(/,/g, '')) || 0;
                                    const dueAmount = parseFloat(data.new_total) - advancePayment;
                                    document.getElementById('due-amount').textContent =
                                        `৳${Math.round(dueAmount).toLocaleString()}`;
                                }

                                // Recalculate shipping to update totals properly
                                calculateShippingCharge();
                            } else {
                                couponMessage.classList.add('text-red-600', 'text-accent');
                                couponMessage.classList.remove('text-green-600');
                                couponMessage.textContent = data.message;
                            }
                        })
                        .catch(error => {
                            console.error('Error applying coupon:', error);
                            couponMessage.classList.add('text-red-600');
                            couponMessage.classList.remove('text-green-600');
                            couponMessage.textContent = 'An error occurred. Please try again.';
                        })
                        .finally(() => {
                            button.disabled = false;
                            button.textContent = 'Apply';
                        });
                });
            });

            function showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className =
                    `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

                if (type === 'success') {
                    notification.className += ' bg-green-500 text-white';
                } else if (type === 'error') {
                    notification.className += ' bg-red-500 text-white';
                } else {
                    notification.className += ' bg-blue-500 text-white';
                }

                notification.textContent = message;

                // Add to page
                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            }
        </script>
    @endpush
</x-app-layout>
