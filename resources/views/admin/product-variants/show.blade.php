<x-admin-layout>
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Size Variant Details</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.product-variants.index') }}">Size Variants</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Details</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <!-- Product Variant Details Starts -->
    <div class="space-y-6">
        <!-- Variant Details Card -->
        <div class="card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <h6 class="card-title">Variant: {{ $variant->name }}</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.product-variants.edit', $variant) }}" class="btn btn-primary btn-sm">
                            <i data-feather="edit" class="w-4 h-4 mr-2"></i>
                            Edit
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="deleteVariant({{ $variant->id }})">
                            <i data-feather="trash-2" class="w-4 h-4 mr-2"></i>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Variant Image -->
                    <div class="space-y-4">
                        <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300">Variant Image</h6>
                        @if($variant->image)
                            <img src="{{ asset($variant->image) }}" alt="{{ $variant->name }}" class="w-full max-w-sm h-64 object-cover rounded-lg" />
                        @else
                            <div class="w-full max-w-sm h-64 bg-slate-100 rounded-lg flex items-center justify-center">
                                <i class="text-slate-400 text-4xl" data-feather="package"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Variant Information -->
                    <div class="space-y-4">
                        <div>
                            <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Basic Information</h6>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-600 dark:text-slate-400">Name:</span>
                                    <span class="font-medium">{{ $variant->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600 dark:text-slate-400">SKU:</span>
                                    <span class="font-mono">{{ $variant->sku }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600 dark:text-slate-400">Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $variant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $variant->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600 dark:text-slate-400">Stock:</span>
                                    <span class="{{ $variant->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                        {{ $variant->stock_quantity }} units
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Size -->
                        @if($variant->size)
                        <div>
                            <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Size</h6>
                            <div class="flex gap-2">
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $variant->size->name }}
                                </span>
                            </div>
                        </div>
                        @endif

                        <!-- Pricing -->
                        <div>
                            <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Pricing</h6>
                            <div class="space-y-2 text-sm">
                                @if($variant->sale_price)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600 dark:text-slate-400">Sale Price:</span>
                                        <span class="text-primary-500 font-medium text-lg">${{ number_format($variant->sale_price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-600 dark:text-slate-400">Regular Price:</span>
                                        <span class="line-through text-slate-400">${{ number_format($variant->price ?? 0, 2) }}</span>
                                    </div>
                                @elseif(isset($variant->price))
                                    <div class="flex justify-between">
                                        <span class="text-slate-600 dark:text-slate-400">Price:</span>
                                        <span class="font-medium text-lg">${{ number_format($variant->price, 2) }}</span>
                                    </div>
                                @endif
                                @if($variant->weight)
                                    <div class="flex justify-between">
                                        <span class="text-slate-600 dark:text-slate-400">Weight:</span>
                                        <span>{{ $variant->weight }} kg</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div>
                            <h6 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Additional Information</h6>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-600 dark:text-slate-400">Created:</span>
                                    <span>{{ $variant->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600 dark:text-slate-400">Last Updated:</span>
                                    <span>{{ $variant->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600 dark:text-slate-400">Sort Order:</span>
                                    <span>{{ $variant->sort_order ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col justify-end gap-3 sm:flex-row">
            <a href="{{ route('admin.product-variants.index') }}" class="btn btn-secondary">
                <i data-feather="arrow-left" class="h-4 w-4"></i>
                <span>Back to Variants</span>
            </a>
            <a href="{{ route('admin.product-variants.edit', $variant) }}" class="btn btn-primary">
                <i data-feather="edit" class="h-4 w-4"></i>
                <span>Edit Variant</span>
            </a>
        </div>
    </div>
    <!-- Product Variant Details Ends -->

    @push('scripts')
    <script>
    function deleteVariant(variantId) {
        if (confirm('Are you sure you want to delete this variant? This action cannot be undone.')) {
            fetch(`{{ url('/admin/product-variants') }}/${variantId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessToast(data.message);
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.product-variants.index") }}';
                    }, 1000);
                } else {
                    showErrorToast('Failed to delete variant');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorToast('An error occurred while deleting the variant');
            });
        }
    }
    </script>
    @endpush
</x-admin-layout>