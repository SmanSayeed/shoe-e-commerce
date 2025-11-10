<x-app-layout title="Checkout">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
            <p class="text-gray-600">Complete your order</p>
        </div>

        @if($cartItems->isEmpty())
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5.4M7 13v6a2 2 0 002 2h8a2 2 0 002-2v-6M9 19h6m-6 0v-3m6 3v-3"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Add some products to get started!</p>
                <a href="{{ route('home') }}" class="bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition">
                    Continue Shopping
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Checkout Form -->
                <div>
                    <form id="checkout-form" class="space-y-6">
                        <!-- Shipping Address -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Address</h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @guest
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                    <input type="text" name="first_name"
                                           value="{{ old('first_name', $user->first_name ?? '') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                    <input type="text" name="last_name"
                                           value="{{ old('last_name', $user->last_name ?? '') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                                    <input type="email" name="email"
                                           value="{{ old('email', $user->email ?? '') }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>
                                @endguest

                                <div class="{{ Auth::check() ? 'md:col-span-2' : '' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                    <input type="tel" name="phone"
                                           value="{{ old('phone', $user->phone ?? '') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                    <textarea name="shipping_address" rows="3" required
                                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">{{ old('address', $user->address ?? '') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                    <input type="text" name="city"
                                           value="{{ old('city', $user->city ?? '') }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>

                                <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-1">Division *</label>
                                     <select name="division" id="division" required
                                             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                         <option value="">Select Division</option>
                                         <option value="Dhaka" {{ old('division', $user->state ?? '') == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                                         <option value="Chittagong" {{ old('division', $user->state ?? '') == 'Chittagong' ? 'selected' : '' }}>Chittagong</option>
                                         <option value="Rajshahi" {{ old('division', $user->state ?? '') == 'Rajshahi' ? 'selected' : '' }}>Rajshahi</option>
                                         <option value="Khulna" {{ old('division', $user->state ?? '') == 'Khulna' ? 'selected' : '' }}>Khulna</option>
                                         <option value="Barisal" {{ old('division', $user->state ?? '') == 'Barisal' ? 'selected' : '' }}>Barisal</option>
                                         <option value="Sylhet" {{ old('division', $user->state ?? '') == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                                         <option value="Rangpur" {{ old('division', $user->state ?? '') == 'Rangpur' ? 'selected' : '' }}>Rangpur</option>
                                         <option value="Mymensingh" {{ old('division', $user->state ?? '') == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                                     </select>
                                 </div>

                                 <div>
                                     <label class="block text-sm font-medium text-gray-700 mb-1">District *</label>
                                     <select name="district" id="district" required
                                             class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                         <option value="">Select District</option>
                                     </select>
                                 </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                    <input type="text" name="postal_code"
                                           value="{{ old('postal_code', $user->postal_code ?? '') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                    <input type="text" name="country"
                                           value="{{ old('country', $user->country ?? '') }}" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
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
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                        <input type="text" name="billing_address[name]"
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                        <input type="tel" name="billing_address[phone]"
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                                        <textarea name="billing_address[address]" rows="3"
                                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                        <input type="text" name="billing_address[city]"
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                        <input type="text" name="billing_address[postal_code]"
                                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Method</h2>

                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="payment_method" value="cash_on_delivery" checked class="mr-3">
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
                                @foreach($cartItems as $item)
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($item->product->main_image)
                                            <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                        @endif
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</h4>
                                        @if($item->variant)
                                        <p class="text-xs text-gray-500">{{ $item->variant->color->name ?? '' }} {{ $item->variant->size->name ?? '' }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>

                                    <div class="text-sm font-medium text-gray-900">
                                        ৳{{ number_format($item->total_price, 0) }}
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <hr class="border-gray-200 mb-4">

                            <!-- Coupon Code -->
                            <div id="coupon-area" class="mb-4">
                                <label for="coupon-code" class="block text-sm font-medium text-gray-700 mb-1">Have a coupon?</label>
                                <div class="flex space-x-2">
                                    <input type="text" id="coupon-code" name="coupon_code" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Enter coupon code">
                                    <button type="button" id="apply-coupon-btn" class="bg-gray-800 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-900 transition">Apply</button>
                                </div>
                                <p id="coupon-message" class="text-sm mt-2"></p>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal ({{ $cartCount }} items)</span>
                                    <span id="subtotal">৳{{ number_format($cartTotal, 0) }}</span>
                                </div>

                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span id="shipping">৳{{ number_format($cartTotal > 1000 ? 0 : config('shipping.default_shipping_charge', 60), 0) }}</span>
                                </div>

                                <div class="flex justify-between text-lg font-semibold text-gray-900">
                                    <span>Total</span>
                                    <span id="total-amount">
                                        ৳{{ number_format($cartTotal + ($cartTotal > 1000 ? 0 : config('shipping.default_shipping_charge', 60)), 0) }}
                                    </span>
                                </div>

                                @if($advancePaymentSettings->advance_payment_status)
                                <div class="flex justify-between text-gray-600">
                                    <span>Advance Payment</span>
                                    <span id="advance-payment">- ৳{{ number_format($advancePaymentSettings->advance_payment_amount, 0) }}</span>
                                </div>

                                <hr class="border-gray-200 my-2">

                                <div class="flex justify-between text-lg font-semibold text-gray-900">
                                    <span>Due Amount</span>
                                    <span id="due-amount">
                                        ৳{{ number_format($cartTotal + ($cartTotal > 1000 ? 0 : 100) - $advancePaymentSettings->advance_payment_amount, 0) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 border-t">
                            <button id="place-order" class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition">
                                Place Order
                            </button>

                            <a href="{{ route('cart.index') }}" class="w-full bg-gray-100 text-gray-900 py-3 px-6 rounded-lg font-medium hover:bg-gray-200 transition text-center block mt-3">
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
        // Fetch default shipping charge on page load
        fetchDefaultShippingCharge();

        // Division and district dropdown functionality
        const divisionSelect = document.getElementById('division');
        const districtSelect = document.getElementById('district');
        const shippingElement = document.getElementById('shipping');
        const totalAmountElement = document.getElementById('total-amount');
        const subtotalElement = document.getElementById('subtotal');

        // Store current shipping charge
        let currentShippingCharge = 0;
        let defaultShippingCharge = {{ config('shipping.default_shipping_charge') }};

        // Function to fetch default shipping charge from API
        async function fetchDefaultShippingCharge() {
            try {
                const response = await fetch('{{ url("/api/shipping/default-charge") }}', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    defaultShippingCharge = data.default_shipping_charge;
                } else {
                    console.error('Error fetching default shipping charge:', data.error);
                }
            } catch (error) {
                console.error('Error fetching default shipping charge:', error);
            }
        }

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
                const response = await fetch(`{{ url('/api/shipping/districts') }}?division_name=${encodeURIComponent(division)}`, {
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
                const response = await fetch('{{ route("shipping.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        division: division,
                        district: district,
                        division_name: division, // For backward compatibility
                        zone_name: district      // For backward compatibility
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
                shippingElement.textContent = 'Free';
            } else {
                shippingElement.textContent = `৳${charge.toFixed(0)}`;
            }

            // Update total amount
            const subtotalText = subtotalElement.textContent.replace('৳', '').replace(/,/g, '');
            const subtotal = parseFloat(subtotalText) || 0;
            const newTotal = subtotal + currentShippingCharge;
            totalAmountElement.textContent = `৳${newTotal.toFixed(0)}`;

            // Update advance payment display if it exists
            const advancePaymentElement = document.getElementById('advance-payment');
            const advancePaymentRow = advancePaymentElement ? advancePaymentElement.closest('.flex.justify-between') : null;
            const advancePaymentSection = advancePaymentRow ? advancePaymentRow.closest('div').parentElement : null;

            if (advanceRequired && advanceCharge > 0) {
                // Show advance payment section if it exists
                if (advancePaymentElement) {
                    advancePaymentElement.textContent = `- ৳${advanceCharge.toFixed(0)}`;
                    if (advancePaymentRow) {
                        advancePaymentRow.style.display = 'flex';
                    }
                    if (advancePaymentSection) {
                        advancePaymentSection.style.display = 'block';
                    }
                } else {
                    // Create advance payment row if it doesn't exist
                    const priceBreakdown = document.querySelector('.space-y-2.text-sm');
                    if (priceBreakdown && !document.getElementById('advance-payment')) {
                        const hr = document.createElement('hr');
                        hr.className = 'border-gray-200 my-2';
                        
                        const advanceRow = document.createElement('div');
                        advanceRow.className = 'flex justify-between text-gray-600';
                        advanceRow.innerHTML = `
                            <span>Advance Payment</span>
                            <span id="advance-payment">- ৳${advanceCharge.toFixed(0)}</span>
                        `;

                        const dueRow = document.createElement('div');
                        dueRow.className = 'flex justify-between text-lg font-semibold text-gray-900';
                        dueRow.innerHTML = `
                            <span>Due Amount</span>
                            <span id="due-amount">৳${(newTotal - advanceCharge).toFixed(0)}</span>
                        `;

                        // Insert before the total row
                        const totalRow = totalAmountElement.closest('.flex.justify-between');
                        if (totalRow && totalRow.parentElement) {
                            totalRow.parentElement.insertBefore(hr, totalRow);
                            totalRow.parentElement.insertBefore(advanceRow, totalRow);
                            totalRow.parentElement.insertBefore(dueRow, totalRow);
                        }
                    }
                }

                // Update due amount
                const dueAmountElement = document.getElementById('due-amount');
                if (dueAmountElement) {
                    const dueAmount = newTotal - advanceCharge;
                    dueAmountElement.textContent = `৳${dueAmount.toFixed(0)}`;
                }
            } else {
                // Hide advance payment section if not required
                if (advancePaymentRow) {
                    advancePaymentRow.style.display = 'none';
                }
                const dueAmountElement = document.getElementById('due-amount');
                if (dueAmountElement && dueAmountElement.closest('.flex.justify-between')) {
                    dueAmountElement.closest('.flex.justify-between').style.display = 'none';
                }
            }
        }

        // Set initial district if division is pre-selected
        const initialDivision = divisionSelect.value;
        if (initialDivision) {
            populateDistricts(initialDivision).then(() => {
                // Set district value if it exists in old data
                const oldDistrict = '{{ old("district", $user->city ?? "") }}';
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
            const advanceCharge = (advancePaymentSettings && advancePaymentSettings.advance_payment_status) 
                ? parseFloat(advancePaymentSettings.advance_payment_amount || 0) 
                : 0;
            const advanceRequired = advancePaymentSettings && advancePaymentSettings.advance_payment_status;
            updateShippingDisplay(defaultShippingCharge, advanceCharge, advanceRequired);
        }

        // Event listener for division change
        divisionSelect.addEventListener('change', function() {
            const selectedDivision = this.value;
            populateDistricts(selectedDivision);
            // Reset district selection and calculate shipping
            districtSelect.value = '';
            calculateShippingCharge();
        });

        // Event listener for district change
        districtSelect.addEventListener('change', function() {
            calculateShippingCharge();
        });

        // Toggle billing address
        const sameAsShippingCheckbox = document.getElementById('same-as-shipping');
        const billingAddress = document.getElementById('billing-address');

        sameAsShippingCheckbox.addEventListener('change', function() {
            if (this.checked) {
                billingAddress.classList.add('hidden');
            } else {
                billingAddress.classList.remove('hidden');
            }
        });

        // Auto-fill billing address when same as shipping
        const shippingInputs = document.querySelectorAll('input[name^="shipping_address"], textarea[name^="shipping_address"]');
        const billingInputs = document.querySelectorAll('input[name^="billing_address"], textarea[name^="billing_address"]');

        shippingInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (sameAsShippingCheckbox.checked && billingInputs[index]) {
                    billingInputs[index].value = this.value;
                }
            });
        });

        // Place order
        document.getElementById('place-order').addEventListener('click', function() {
            const form = document.getElementById('checkout-form');
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
                // Skip empty values for checkboxes that aren't checked
                if (!value && value !== '0') continue;

                // Handle array notation like shipping_address[name]
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

            // Update field names for backend compatibility
            // Map division to state and district to city for existing backend logic
            if (data.division) {
                data.state = data.division;
            }
            if (data.district) {
                data.city = data.district;
            }

            // Add loading state
            const button = this;
            const originalText = button.textContent;
            button.disabled = true;
            button.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></span>Processing...';

            // Debug log the final data being sent
            console.log('Sending data to server:', JSON.stringify(data, null, 2));

            // Make API call
            fetch('{{ route("checkout.process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
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
                showNotification('Failed to place order. Please try again.', 'error');
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

            fetch('{{ route("coupon.apply") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ coupon_code: couponCode }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    couponMessage.classList.add('text-green-600');
                    couponMessage.classList.remove('text-red-600');
                    couponMessage.textContent = data.message;

                    document.getElementById('discount-row').classList.remove('hidden');
                    document.getElementById('discount-amount').textContent = '- ৳' + data.discount;
                    document.getElementById('total-amount').textContent = '৳' + data.new_total;

                    const advancePaymentElement = document.getElementById('advance-payment');
                    if (advancePaymentElement) {
                        const advancePayment = parseFloat(advancePaymentElement.textContent.replace('- ৳', '').replace(',', '')) || 0;
                        const dueAmount = parseFloat(data.new_total) - advancePayment;
                        document.getElementById('due-amount').textContent = `৳${dueAmount.toFixed(0)}`;
                    }
                } else {
                    couponMessage.classList.add('text-red-600');
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
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full`;

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
