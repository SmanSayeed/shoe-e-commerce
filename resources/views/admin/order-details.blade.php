<x-admin-layout title="Order Details">
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Order Details #{{ $order->order_number }}</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.orders.index') }}">Orders</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">#{{ $order->order_number }}</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Order Summary -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="w-[5%] uppercase">#</th>
                                    <th class="w-[60%] uppercase">Product</th>
                                    <th class="w-[15%] text-right uppercase">Price</th>
                                    <th class="w-[10%] text-center uppercase">Qty</th>
                                    <th class="w-[20%] text-right uppercase">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                @if ($item->product && $item->product->images->count() > 0)
                                                    <img src="{{ asset($item->product->main_image) }}"
                                                        alt="{{ $item->name }}"
                                                        class="h-12 w-12 rounded border object-cover">
                                                @endif
                                                <div>
                                                    <h6 class="font-medium text-slate-700">{{ $item->name }}</h6>
                                                    @if ($item->variant)
                                                        <p class="text-xs text-slate-500">
                                                            {{ $item->variant->color->name ?? '' }}
                                                            {{ $item->variant->size->name ?? '' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">৳{{ number_format(round((float) $item->unit_price), 0) }}
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">
                                            ৳{{ number_format(round((float) $item->total_price), 0) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            <div class="card mt-6">
                <div class="card-header">
                    <h5>Order Notes</h5>
                </div>
                <div class="card-body">
                    @if (!empty($order->notes))
                        <div class="mb-4">
                            <h6 class="font-medium text-slate-700">Customer Note:</h6>
                            <p class="mt-1 text-slate-600 whitespace-pre-wrap">{{ $order->notes }}</p>
                        </div>
                    @else
                        <div class="mb-4">
                            <h6 class="font-medium text-slate-700">Customer Note:</h6>
                            <p class="mt-1 text-slate-400 italic">No customer notes</p>
                        </div>
                    @endif

                    @if (!empty($order->admin_notes))
                        <div>
                            <h6 class="font-medium text-slate-700">Admin Note:</h6>
                            <p class="mt-1 text-slate-600 whitespace-pre-wrap">{{ $order->admin_notes }}</p>
                        </div>
                    @else
                        <div>
                            <h6 class="font-medium text-slate-700">Admin Note:</h6>
                            <p class="mt-1 text-slate-400 italic">No admin notes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Details Sidebar -->
        <div class="space-y-6">
            <!-- Order Actions & Payment Status -->
            <div class="card">
                <div class="card-header">
                    <h5>Order Management</h5>
                </div>
                <div class="card-body space-y-4">
                    <!-- Payment Status Change -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <i data-feather="credit-card" class="h-4 w-4 inline mr-1"></i>
                            Payment Status
                        </label>
                        <form action="{{ route('admin.orders.update-payment-status', $order->id) }}" method="POST"
                            id="payment-status-form" class="space-y-2">
                            @csrf
                            @method('PATCH')
                            <select name="payment_status" id="payment_status" class="form-select w-full"
                                onchange="document.getElementById('payment-status-form').submit();">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="partially_paid"
                                    {{ $order->payment_status === 'partially_paid' ? 'selected' : '' }}>Partially Paid
                                </option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>
                                    Failed</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>
                                    Refunded</option>
                            </select>
                            <p class="text-xs text-slate-500">Current:
                                @if ($order->payment_status === 'paid')
                                    <span class="text-success-600 font-medium">Paid</span>
                                @elseif($order->payment_status === 'partially_paid')
                                    <span class="text-warning-600 font-medium">Partially Paid</span>
                                @elseif($order->payment_status === 'failed')
                                    <span class="text-danger-600 font-medium">Failed</span>
                                @elseif($order->payment_status === 'refunded')
                                    <span class="text-danger-600 font-medium">Refunded</span>
                                @else
                                    <span class="text-warning-600 font-medium">Pending</span>
                                @endif
                            </p>
                        </form>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-slate-200"></div>

                    <!-- Order Actions -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            <i data-feather="settings" class="h-4 w-4 inline mr-1"></i>
                            Order Actions
                        </label>
                        <div class="relative" id="order-actions-dropdown">
                            <button id="order-actions-button" class="btn btn-primary w-full justify-between">
                                <span>Select Action</span>
                                <i data-feather="chevron-down" class="h-4 w-4"></i>
                            </button>

                            <div id="order-actions-menu"
                                class="absolute right-0 left-0 mt-2 w-full origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50"
                                role="menu" aria-orientation="vertical" aria-labelledby="order-actions-button"
                                tabindex="-1">
                                <div class="py-1" role="none">
                                    @if ($order->status !== 'cancelled' && $order->status !== 'refunded')
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                            method="POST" class="block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="processing">
                                            <button type="submit"
                                                class="flex w-full items-center gap-3 px-4 py-2 text-sm hover:bg-slate-100"
                                                role="menuitem">
                                                <i data-feather="check-circle" class="h-4 w-4"></i>
                                                <span>Mark as Processing</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                            method="POST" class="block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="shipped">
                                            <button type="submit"
                                                class="flex w-full items-center gap-3 px-4 py-2 text-sm hover:bg-slate-100"
                                                role="menuitem">
                                                <i data-feather="truck" class="h-4 w-4"></i>
                                                <span>Mark as Shipped</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                            method="POST" class="block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="delivered">
                                            <button type="submit"
                                                class="flex w-full items-center gap-3 px-4 py-2 text-sm hover:bg-slate-100"
                                                role="menuitem">
                                                <i data-feather="check" class="h-4 w-4"></i>
                                                <span>Mark as Delivered</span>
                                            </button>
                                        </form>
                                        <div class="border-t border-slate-200 my-1"></div>
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                            method="POST" class="block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit"
                                                class="flex w-full items-center gap-3 px-4 py-2 text-sm text-danger-600 hover:bg-slate-100"
                                                role="menuitem"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                                <i data-feather="x" class="h-4 w-4"></i>
                                                <span>Cancel Order</span>
                                            </button>
                                        </form>
                                    @endif
                                    <div class="border-t border-slate-200 my-1"></div>
                                    <button onclick="window.print()"
                                        class="flex w-full items-center gap-3 px-4 py-2 text-sm hover:bg-slate-100"
                                        role="menuitem">
                                        <i data-feather="printer" class="h-4 w-4"></i>
                                        <span>Print Invoice</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Current Status:
                            <span class="font-medium capitalize">{{ $order->status }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body space-y-4">
                    <div class="flex items-center justify-between">
                        <span>Order Status:</span>
                        <span class="font-medium">
                            <span class="inline-flex items-center gap-1.5">
                                <span
                                    class="h-2 w-2 rounded-full {{ $statusColors[strtolower($order->status)] ?? 'bg-slate-500' }}"></span>
                                <span class="capitalize">{{ $order->status }}</span>
                            </span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Payment Status:</span>
                        <span class="font-medium">
                            @if ($order->payment_status === 'paid')
                                <span class="text-success-600">Paid</span>
                            @elseif($order->payment_status === 'partially_paid')
                                <span class="text-warning-600">Partially Paid</span>
                            @elseif($order->payment_status === 'failed')
                                <span class="text-danger-600">Failed</span>
                            @elseif($order->payment_status === 'refunded')
                                <span class="text-danger-600">Refunded</span>
                            @else
                                <span class="text-warning-600">Pending</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Order Date:</span>
                        <span class="font-medium">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    @if ($order->shipped_at)
                        <div class="flex items-center justify-between">
                            <span>Shipped On:</span>
                            <span class="font-medium">{{ $order->shipped_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @endif
                    @if ($order->delivered_at)
                        <div class="flex items-center justify-between">
                            <span>Delivered On:</span>
                            <span class="font-medium">{{ $order->delivered_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card">
                <div class="card-header">
                    <h5>Customer Information</h5>
                </div>
                <div class="card-body space-y-4">
                    @php
                        $customerName = $order->customer->name ?? null;
                        $customerEmail = $order->customer->email ?? null;
                        $shippingAddress = $order->shipping_address ?? [];

                        // Get customer info from shipping address if customer is not available
                        if (!$customerName && isset($shippingAddress['name'])) {
                            $customerName = $shippingAddress['name'];
                        } elseif (
                            !$customerName &&
                            (isset($shippingAddress['first_name']) || isset($shippingAddress['last_name']))
                        ) {
                            $customerName = trim(
                                ($shippingAddress['first_name'] ?? '') . ' ' . ($shippingAddress['last_name'] ?? ''),
                            );
                        }

                        if (!$customerEmail && isset($shippingAddress['email'])) {
                            $customerEmail = $shippingAddress['email'];
                        }
                    @endphp

                    <div class="flex items-center gap-3">
                        @if ($order->customer && $order->customer->avatar)
                            <img src="{{ asset('storage/' . $order->customer->avatar) }}"
                                alt="{{ $customerName ?? 'Guest' }}" class="h-10 w-10 rounded-full object-cover">
                        @endif
                        <div>
                            <h6>{{ $customerName ?? 'Guest' }}</h6>
                            @if ($customerEmail)
                                <p class="text-sm text-slate-600">{{ $customerEmail }}</p>
                            @endif
                        </div>
                    </div>

                    @if (!empty($shippingAddress))
                        <div class="mt-4">
                            <h6 class="font-medium mb-2">Shipping Address</h6>
                            <address class="mt-1 not-italic text-sm text-slate-600">
                                @if (isset($shippingAddress['address']) && $shippingAddress['address'])
                                    <div class="mb-1">{{ $shippingAddress['address'] }}</div>
                                @elseif(isset($shippingAddress['address_line_1']) && $shippingAddress['address_line_1'])
                                    <div class="mb-1">{{ $shippingAddress['address_line_1'] }}</div>
                                    @if (isset($shippingAddress['address_line_2']) && $shippingAddress['address_line_2'])
                                        <div class="mb-1">{{ $shippingAddress['address_line_2'] }}</div>
                                    @endif
                                @endif

                                @if (isset($shippingAddress['city']) ||
                                        isset($shippingAddress['district']) ||
                                        isset($shippingAddress['division']) ||
                                        isset($shippingAddress['postal_code']))
                                    <div class="mb-1">
                                        @if (isset($shippingAddress['city']) && $shippingAddress['city'])
                                            {{ $shippingAddress['city'] }}
                                        @elseif(isset($shippingAddress['district']) && $shippingAddress['district'])
                                            {{ $shippingAddress['district'] }}
                                        @endif
                                        @if (isset($shippingAddress['division']) && $shippingAddress['division'])
                                            @if (isset($shippingAddress['city']) || isset($shippingAddress['district']))
                                                ,
                                            @endif
                                            {{ $shippingAddress['division'] }}
                                        @endif
                                        @if (isset($shippingAddress['postal_code']) && $shippingAddress['postal_code'])
                                            @if (isset($shippingAddress['city']) || isset($shippingAddress['district']) || isset($shippingAddress['division']))
                                                ,
                                            @endif
                                            {{ $shippingAddress['postal_code'] }}
                                        @endif
                                    </div>
                                @elseif(isset($shippingAddress['city']) || isset($shippingAddress['state']))
                                    <div class="mb-1">
                                        @if (isset($shippingAddress['city']) && $shippingAddress['city'])
                                            {{ $shippingAddress['city'] }}
                                        @endif
                                        @if (isset($shippingAddress['state']) && $shippingAddress['state'])
                                            @if (isset($shippingAddress['city']))
                                                ,
                                            @endif
                                            {{ $shippingAddress['state'] }}
                                        @endif
                                        @if (isset($shippingAddress['postal_code']) && $shippingAddress['postal_code'])
                                            @if (isset($shippingAddress['city']) || isset($shippingAddress['state']))
                                                ,
                                            @endif
                                            {{ $shippingAddress['postal_code'] }}
                                        @endif
                                        @if (isset($shippingAddress['country']) && $shippingAddress['country'])
                                            @if (isset($shippingAddress['city']) || isset($shippingAddress['state']) || isset($shippingAddress['postal_code']))
                                                ,
                                            @endif
                                            {{ $shippingAddress['country'] }}
                                        @endif
                                    </div>
                                @endif

                                @if (isset($shippingAddress['phone']) && $shippingAddress['phone'])
                                    <div class="mt-2">
                                        <span class="font-medium">Phone:</span> {{ $shippingAddress['phone'] }}
                                    </div>
                                @endif

                                @if (isset($shippingAddress['email']) &&
                                        $shippingAddress['email'] &&
                                        (!$order->customer || $order->customer->email != $shippingAddress['email']))
                                    <div class="mt-1">
                                        <span class="font-medium">Email:</span> {{ $shippingAddress['email'] }}
                                    </div>
                                @endif
                            </address>
                        </div>
                    @elseif($order->shippingAddress)
                        <div class="mt-4">
                            <h6 class="font-medium mb-2">Shipping Address</h6>
                            <address class="mt-1 not-italic text-sm text-slate-600">
                                {{ $order->shippingAddress->address_line_1 }}<br>
                                @if ($order->shippingAddress->address_line_2)
                                    {{ $order->shippingAddress->address_line_2 }}<br>
                                @endif
                                {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}<br>
                                {{ $order->shippingAddress->postal_code }},
                                {{ $order->shippingAddress->country->name ?? $order->shippingAddress->country_code }}
                                <br>
                                <span class="mt-1 block">
                                    <span class="font-medium">Phone:</span> {{ $order->shippingAddress->phone }}
                                </span>
                            </address>
                        </div>
                    @endif

                    <!-- Advance Payment Information -->
                    @if ($order->advance_payment_status && $order->bkash_number)
                        <div class="mt-4">
                            <h6 class="font-medium mb-2">Advance Payment Details</h6>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-slate-700">Bkash Number:</span>
                                    <span class="text-slate-900">+88{{ $order->bkash_number }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-slate-700">Paid Amount:</span>
                                    <span
                                        class="text-slate-900 font-semibold">৳{{ number_format(round((float) $order->advance_payment_paid_amount ?? $order->advance_payment_amount), 0) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-medium text-slate-700">Transaction ID:</span>
                                    <span class="text-slate-900 font-mono text-xs">{{ $order->transaction_id }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Total -->
            <div class="card">
                <div class="card-header">
                    <h5>Order Total</h5>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex items-center justify-between">
                        <span>Subtotal:</span>
                        <span class="font-medium">৳{{ number_format(round((float) $order->subtotal), 0) }}</span>
                    </div>
                    @if ($order->discount_amount > 0)
                        <div class="flex items-center justify-between">
                            <span>Discount:</span>
                            <span
                                class="font-medium text-danger-600">-৳{{ number_format(round((float) $order->discount_amount), 0) }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span>Shipping:</span>
                        <span
                            class="font-medium">৳{{ number_format(round((float) $order->shipping_amount), 0) }}</span>
                    </div>
                    <div class="border-t border-slate-200 pt-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">Total:</span>
                            <span
                                class="text-lg font-bold text-primary-600">৳{{ number_format(round((float) $order->total_amount), 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                .card,
                .card * {
                    visibility: visible;
                }

                .card {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                }

                .order-actions-dropdown,
                .breadcrumb,
                .card-header button,
                #order-actions-dropdown {
                    display: none !important;
                }
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropdown = document.getElementById('order-actions-dropdown');
                const button = document.getElementById('order-actions-button');
                const menu = document.getElementById('order-actions-menu');

                if (button && menu) {
                    button.addEventListener('click', () => {
                        menu.classList.toggle('hidden');
                    });

                    // Close dropdown when clicking outside
                    document.addEventListener('click', (event) => {
                        if (dropdown && !dropdown.contains(event.target)) {
                            menu.classList.add('hidden');
                        }
                    });
                }

                // Handle payment status form submission with loading state
                const paymentStatusForm = document.getElementById('payment-status-form');
                if (paymentStatusForm) {
                    paymentStatusForm.addEventListener('submit', function(e) {
                        const select = document.getElementById('payment_status');
                        if (select) {
                            select.disabled = true;
                            const originalValue = select.value;

                            // Show loading state
                            const form = this;
                            const submitBtn = form.querySelector('button[type="submit"]');
                            if (submitBtn) {
                                submitBtn.disabled = true;
                                submitBtn.innerHTML = '<span class="animate-spin">Updating...</span>';
                            }

                            // If form fails, re-enable select
                            setTimeout(() => {
                                if (select.value === originalValue) {
                                    select.disabled = false;
                                }
                            }, 5000);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-admin-layout>
