<x-admin-layout>
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Order List</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.orders.index') }}">Order List</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <!-- Order Listing Starts -->
    <div class="space-y-4">
        <!-- Order Header Starts -->
        <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
            <!-- Order Search Starts -->
            <form method="GET" action="{{ route('admin.orders.index') }}"
                class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
                <div class="flex h-full items-center px-2">
                    <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
                </div>
                <input name="search" value="{{ request('search') }}"
                    class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
                    type="text" placeholder="Search by order #, customer, status..." />
            </form>
            <!-- Order Search Ends -->

            <!-- Order Action Starts -->
            <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
                <div class="dropdown" data-placement="bottom-end">
                    <div class="flex items-center gap-2">
                        <div class="dropdown-toggle">
                            <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                                <i class="w-4" data-feather="filter"></i>
                                <span>Filter</span>
                                <i class="w-4" data-feather="chevron-down"></i>
                            </button>
                        </div>
                        <div class="dropdown-content w-72 !overflow-visible">
                            <ul class="dropdown-list space-y-4 p-4">
                                <li class="dropdown-list-item">
                                    <h2 class="my-1 text-sm font-medium">Status</h2>
                                    <select name="status" class="select w-full" onchange="this.form.submit()">
                                        <option value="all" {{ request('status') === 'all' || !request()->has('status') ? 'selected' : '' }}>All Statuses</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <option value="3">Processing</option>
                                    <option value="4">Refounded</option>
                                    <option value="5">Canceled</option>
                                    </select>
                                </li>

                                <li class="dropdown-list-item">
                                    <h2 class="my-1 text-sm font-medium">Ordered Date</h2>
                                    <select class="tom-select w-full" autocomplete="off">
                                        <option value="">Search Date</option>
                                        <option value="1">01 May 2022</option>
                                        <option value="2">20 Jun 2022</option>
                                        <option value="3">19 Aug 2022</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <a class="btn btn-primary" href="#" role="button">
                    <i data-feather="plus" height="1rem" width="1rem"></i>
                    <span>New Order</span>
                </a>
            </div>
            <!-- Order Action Ends -->
        </div>
        <!-- Order Header Ends -->

        <!-- Order Table Starts -->
        @if($orders->isEmpty())
            <div
                class="rounded-lg border border-slate-200 bg-white p-6 text-center dark:border-slate-600 dark:bg-slate-800">
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400 dark:bg-slate-700">
                    <i data-feather="package" class="h-8 w-8"></i>
                </div>
                <h5 class="mt-4 text-slate-600 dark:text-slate-300">No orders found</h5>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    @if(request()->has('search') || request()->has('status'))
                        No orders match your search criteria. Try adjusting your filters.
                    @else
                        No orders have been placed yet.
                    @endif
                </p>
            </div>
        @else
            <div class="table-responsive whitespace-nowrap rounded-primary">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="w-[5%]">
                                <input class="checkbox" type="checkbox" data-check-all
                                    data-check-all-target=".order-checkbox" />
                            </th>
                            <th class="w-[5%] uppercase">Order</th>
                            <th class="w-[55%] uppercase">Customer</th>
                            <th class="w-[10%] uppercase">Total</th>
                            <th class="w-[10%] uppercase">Ordered At</th>
                            <th class="w-[10%] uppercase">Status</th>
                            <th class="w-[10%] uppercase">Price</th>
                            <th class="w-[5%] !text-right uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <input class="checkbox order-checkbox" type="checkbox" value="{{ $order->id }}" />
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="font-medium text-primary-500 hover:underline">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-full">
                                            @if($order->customer && $order->customer->avatar)
                                                <img src="{{ asset('storage/' . $order->customer->avatar) }}"
                                                    alt="{{ $order->customer->name }}"
                                                    class="h-full w-full rounded-full object-cover" />
                                            @else
                                                <div
                                                    class="flex h-full w-full items-center justify-center rounded-full bg-slate-100 text-xs font-medium text-slate-500 dark:bg-slate-700 dark:text-slate-300">
                                                    {{ $order->customer ? substr($order->customer->name, 0, 2) : 'NA' }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6
                                                class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                                                {{ $order->customer->name ?? 'Guest' }}
                                            </h6>
                                            <span class="text-xs text-slate-500">{{ $order->customer->email ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="h-2 w-2 rounded-full {{ $statusColors[strtolower($order->status)] ?? 'bg-slate-500' }}"></span>
                                        <span class="capitalize">{{ $order->status }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        @if($order->payment_status === 'paid')
                                            <i class="h-4 w-4 text-success-500" data-feather="check-circle"></i>
                                            <span>Paid</span>
                                        @else
                                            <i class="h-4 w-4 text-danger-500" data-feather="x-circle"></i>
                                            <span>Unpaid</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <span class="block text-xs text-slate-500">{{ $order->created_at->format('h:i A') }}</span>
                                </td>
                                <td class="font-medium">
                                    ${{ number_format($order->total_amount, 2) }}
                                </td>
                                <td>
                                    <div class="dropdown" data-placement="bottom-end">
                                        <div class="dropdown-toggle">
                                            <button class="p-2 text-slate-400 hover:text-primary-500">
                                                <i class="w-4" data-feather="more-vertical"></i>
                                            </button>
                                        </div>
                                        <div class="dropdown-content w-40">
                                            <ul class="dropdown-list">
                                                <li class="dropdown-list-item">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="dropdown-link">
                                                        <i data-feather="eye" class="h-4 w-4"></i>
                                                        <span>View</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-list-item">
                                                    <a href="#" class="dropdown-link">
                                                        <i data-feather="printer" class="h-4 w-4"></i>
                                                        <span>Invoice</span>
                                                    </a>
                                                </li>
                                                @if($order->status !== 'cancelled' && $order->status !== 'refunded')
                                                    <li class="dropdown-list-item">
                                                        <form action="{{ route('admin.orders.update-status', $order->id) }}"
                                                            method="POST" class="w-full">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit"
                                                                class="dropdown-link text-danger-500 hover:!text-danger-700"
                                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                                                <i data-feather="x" class="h-4 w-4"></i>
                                                                <span>Cancel</span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Order Table Ends -->

            @if($orders->hasPages())
                <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
                    <p class="text-sm font-normal text-slate-500">
                        Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
                    </p>
                    {{ $orders->withQueryString()->links('vendor.pagination.custom') }}
                </div>
            @endif
        @endif
        <!-- Order Pagination Ends -->
    </div>
    <!-- Order Listing Ends -->
    @push('scripts')
        <script>
            // Initialize tooltips and other JS functionality
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize all tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Handle bulk actions
                const checkAll = document.querySelector('[data-check-all]');
                if (checkAll) {
                    checkAll.addEventListener('change', function () {
                        const checkboxes = document.querySelectorAll('.order-checkbox');
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = checkAll.checked;
                        });
                    });
                }
            });
        </script>
    @endpush

    @php
        // Status color mapping
        $statusColors = [
            'completed' => 'bg-success-500',
            'delivered' => 'bg-success-500',
            'paid' => 'bg-success-500',
            'pending' => 'bg-warning-500',
            'cancelled' => 'bg-danger-500',
            'failed' => 'bg-danger-500',
            'refunded' => 'bg-danger-500',
            'processing' => 'bg-info-500',
            'shipped' => 'bg-info-500'
        ];
    @endphp
</x-admin-layout>