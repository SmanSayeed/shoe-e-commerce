<x-admin-layout>
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Size Variants</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Size Variants</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <!-- Product Variants Management Starts -->
    <div class="space-y-6">
        <!-- Filters and Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Filters & Actions</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.product-variants.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Search -->
                        <div class="space-y-2">
                            <label for="search" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Search
                            </label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                class="input" placeholder="Search variants..." />
                        </div>

                        <!-- Status Filter -->
                        <div class="space-y-2">
                            <label for="status" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Status
                            </label>
                            <select id="status" name="status" class="input">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>

                        <!-- Stock Filter -->
                        <div class="space-y-2">
                            <label for="stock" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Stock Status
                            </label>
                            <select id="stock" name="stock" class="input">
                                <option value="">All Stock</option>
                                <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>In
                                    Stock</option>
                                <option value="out_of_stock"
                                    {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="low_stock" {{ request('stock') === 'low_stock' ? 'selected' : '' }}>Low
                                    Stock</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="search" class="w-4 h-4 mr-2"></i>
                                Filter
                            </button>
                            <a href="{{ route('admin.product-variants.index') }}" class="btn btn-secondary">
                                <i data-feather="x" class="w-4 h-4 mr-2"></i>
                                Clear
                            </a>
                        </div>
                        <a href="{{ route('admin.product-variants.create') }}" class="btn btn-success">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                            Add Variant
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Variants Table -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Variants ({{ $variants->total() }})</h6>
            </div>
            <div class="card-body">
                @if ($variants->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll" class="checkbox">
                                    </th>
                                    <th>Variant</th>
                                    <th>SKU</th>
                                    <th>Size</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($variants as $variant)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="checkbox variant-checkbox"
                                                value="{{ $variant->id }}">
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-3">
                                                @if ($variant->image)
                                                    <img src="{{ asset($variant->image) }}" alt="{{ $variant->name }}"
                                                        class="w-10 h-10 object-cover rounded-lg" />
                                                @else
                                                    <div
                                                        class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                                        <i class="text-slate-400" data-feather="package"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                                        {{ $variant->name }}</h6>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                                        {{ $variant->display_name ?? $variant->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-sm font-mono">{{ $variant->sku }}</span>
                                        </td>
                                        <td>
                                            @if ($variant->size)
                                                <span
                                                    class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs">{{ $variant->size->name }}</span>
                                            @else
                                                <span class="text-xs text-slate-400">No size</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="text-sm {{ $variant->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $variant->stock_quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $variant->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $variant->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex gap-1">
                                                <a href="{{ route('admin.product-variants.show', $variant) }}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i data-feather="eye" class="w-3 h-3"></i>
                                                </a>
                                                <a href="{{ route('admin.product-variants.edit', $variant) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i data-feather="edit" class="w-3 h-3"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteVariant({{ $variant->id }})">
                                                    <i data-feather="trash-2" class="w-3 h-3"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $variants->links() }}
                    </div>

                    <!-- Bulk Actions -->
                    <div class="mt-4 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Selected:</span>
                            <span id="selectedCount" class="text-sm font-medium">0</span>
                        </div>
                        <div class="flex gap-2">
                            <button id="bulkDeleteBtn" class="btn btn-danger" disabled>
                                <i data-feather="trash-2" class="w-4 h-4 mr-2"></i>
                                Delete Selected
                            </button>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="w-12 h-12 text-slate-300 mb-4" data-feather="package"></i>
                        <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No variants found</h6>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Try adjusting your filters or add a new
                            variant.</p>
                        <a href="{{ route('admin.product-variants.create') }}" class="btn btn-primary mt-4">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                            Add First Variant
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Product Variants Management Ends -->

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('selectAll');
                const variantCheckboxes = document.querySelectorAll('.variant-checkbox');
                const selectedCount = document.getElementById('selectedCount');
                const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

                // Handle select all checkbox
                selectAllCheckbox.addEventListener('change', function() {
                    variantCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateSelectedCount();
                });

                // Handle individual checkboxes
                variantCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectedCount();
                    });
                });

                function updateSelectedCount() {
                    const checkedBoxes = document.querySelectorAll('.variant-checkbox:checked');
                    selectedCount.textContent = checkedBoxes.length;
                    bulkDeleteBtn.disabled = checkedBoxes.length === 0;
                }

                // Bulk delete functionality
                bulkDeleteBtn.addEventListener('click', function() {
                    const checkedBoxes = document.querySelectorAll('.variant-checkbox:checked');
                    if (checkedBoxes.length === 0) return;

                    const ids = Array.from(checkedBoxes).map(cb => cb.value);

                    if (confirm(`Are you sure you want to delete ${ids.length} variant(s)?`)) {
                        fetch('{{ route('admin.product-variants.bulk-destroy') }}', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                },
                                body: JSON.stringify({
                                    ids: ids
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    showSuccessToast(data.message);
                                    setTimeout(() => location.reload(), 1000);
                                } else {
                                    showErrorToast('Failed to delete variants');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showErrorToast('An error occurred while deleting variants');
                            });
                    }
                });
            });

            function deleteVariant(variantId) {
                if (confirm('Are you sure you want to delete this variant?')) {
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
                                setTimeout(() => location.reload(), 1000);
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
