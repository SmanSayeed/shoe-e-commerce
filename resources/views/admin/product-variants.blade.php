<x-admin-layout>
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Product Variants</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.product-variants.index') }}">Product Variants</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Manage Variants</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <!-- Product Variants Management Starts -->
    <div class="space-y-6">
        @if (!isset($product) || !$product)
            <!-- Variants List Table (when viewing all variants) -->
            <div class="space-y-4">
                <!-- Variants Header Starts -->
                <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
                    <!-- Variant Search Starts -->
                    <form method="GET" action="{{ route('admin.product-variants.index') }}"
                        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
                        <div class="flex h-full items-center px-2">
                            <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
                        </div>
                        <input name="search" value="{{ request('search') }}"
                            class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
                            type="text" placeholder="Search variants" />
                        @if (request('product_id'))
                            <input type="hidden" name="product_id" value="{{ request('product_id') }}" />
                        @endif
                        @if (request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}" />
                        @endif
                        @if (request('stock'))
                            <input type="hidden" name="stock" value="{{ request('stock') }}" />
                        @endif
                    </form>
                    <!-- Variant Search Ends -->

                    <!-- Variant Action Starts -->
                    <div class="flex w-full items-center justify-between gap-x-4 md:w-auto">
                        <div class="flex items-center gap-x-4">
                            <div class="dropdown" data-placement="bottom-end">
                                <div class="dropdown-toggle">
                                    <button type="button" class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                                        <i class="w-4" data-feather="filter"></i>
                                        <span class="hidden sm:inline-block">Filter</span>
                                        <i class="w-4" data-feather="chevron-down"></i>
                                    </button>
                                </div>
                                <div class="dropdown-content w-72 !overflow-visible">
                                    <form method="GET" action="{{ route('admin.product-variants.index') }}">
                                        <ul class="dropdown-list space-y-4 p-4">
                                            <li class="dropdown-list-item">
                                                <h2 class="my-1 text-sm font-medium">Product</h2>
                                                <select name="product_id" class="tom-select w-full" autocomplete="off"
                                                    onchange="this.form.submit()">
                                                    <option value="">All Products</option>
                                                    @foreach ($products as $prod)
                                                        <option value="{{ $prod->id }}"
                                                            {{ request('product_id') == $prod->id ? 'selected' : '' }}>
                                                            {{ $prod->name }}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                            <li class="dropdown-list-item">
                                                <h2 class="my-1 text-sm font-medium">Status</h2>
                                                <select name="status" class="tom-select w-full" autocomplete="off"
                                                    onchange="this.form.submit()">
                                                    <option value="">All Status</option>
                                                    <option value="active"
                                                        {{ request('status') == 'active' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="inactive"
                                                        {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </li>
                                            <li class="dropdown-list-item">
                                                <h2 class="my-1 text-sm font-medium">Stock Status</h2>
                                                <select name="stock" class="tom-select w-full" autocomplete="off"
                                                    onchange="this.form.submit()">
                                                    <option value="">All Stock</option>
                                                    <option value="in_stock"
                                                        {{ request('stock') == 'in_stock' ? 'selected' : '' }}>In Stock
                                                    </option>
                                                    <option value="out_of_stock"
                                                        {{ request('stock') == 'out_of_stock' ? 'selected' : '' }}>Out
                                                        of Stock
                                                    </option>
                                                    <option value="low_stock"
                                                        {{ request('stock') == 'low_stock' ? 'selected' : '' }}>Low
                                                        Stock</option>
                                                </select>
                                            </li>
                                        </ul>
                                        @if (request('search'))
                                            <input type="hidden" name="search" value="{{ request('search') }}" />
                                        @endif
                                    </form>
                                </div>
                            </div>
                            @if (request()->anyFilled(['product_id', 'status', 'stock', 'search']))
                                <a href="{{ route('admin.product-variants.index') }}"
                                    class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
                                    <i class="h-4" data-feather="x"></i>
                                    <span class="hidden sm:inline-block">Clear Filters</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- Variant Action Ends -->
                </div>
                <!-- Variants Header Ends -->

                <!-- Variants Table Starts -->
                <div class="table-responsive whitespace-nowrap rounded-primary">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="w-[5%]">
                                    <input class="checkbox" type="checkbox" data-check-all
                                        data-check-all-target=".variant-checkbox" />
                                </th>
                                <th class="w-[20%] uppercase">Variant</th>
                                <th class="w-[15%] uppercase">Product</th>
                                <th class="w-[10%] uppercase">SKU</th>
                                <th class="w-[10%] uppercase">Size</th>
                                <th class="w-[10%] uppercase">Color</th>
                                <th class="w-[10%] uppercase">Price</th>
                                <th class="w-[10%] uppercase">Stock</th>
                                <th class="w-[5%] uppercase">Status</th>
                                <th class="w-[5%] !text-right uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($variants as $variant)
                                <tr>
                                    <td>
                                        <input class="checkbox variant-checkbox" type="checkbox"
                                            value="{{ $variant->id }}" />
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar avatar-circle">
                                                @if (isset($variant->image) && $variant->image)
                                                    <img class="avatar-img" src="{{ asset($variant->image) }}"
                                                        alt="{{ $variant->name ?? 'Variant' }}" />
                                                @else
                                                    <div
                                                        class="avatar-img bg-slate-200 flex items-center justify-center">
                                                        <i class="text-slate-400" data-feather="package"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h6
                                                    class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                                                    {{ $variant->name ?? 'N/A' }}
                                                </h6>
                                                <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                                                    {{ $variant->sku ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.product-variants.index', ['product_id' => $variant->product_id]) }}"
                                            class="text-sm text-primary-500 hover:underline">
                                            {{ $variant->product->name ?? 'N/A' }}
                                        </a>
                                    </td>
                                    <td>{{ $variant->sku ?? 'N/A' }}</td>
                                    <td>{{ $variant->size->name ?? 'N/A' }}</td>
                                    <td>{{ $variant->color->name ?? 'N/A' }}</td>
                                    <td>
                                        @if (isset($variant->sale_price) && $variant->sale_price)
                                            <span
                                                class="text-primary-500">${{ number_format($variant->sale_price, 2) }}</span>
                                            <span
                                                class="text-xs text-slate-400 line-through">${{ number_format($variant->price ?? 0, 2) }}</span>
                                        @else
                                            <span>${{ number_format($variant->price ?? 0, 2) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ ($variant->stock_quantity ?? 0) > 0 ? 'badge-success-soft' : 'badge-danger-soft' }}">
                                            {{ $variant->stock_quantity ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $variant->is_active ?? false ? 'badge-success-soft' : 'badge-danger-soft' }}">
                                            {{ $variant->is_active ?? false ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex justify-end">
                                            <div class="dropdown" data-placement="bottom-start">
                                                <div class="dropdown-toggle">
                                                    <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                                                </div>
                                                <div class="dropdown-content">
                                                    <ul class="dropdown-list">
                                                        <li class="dropdown-list-item">
                                                            <a href="{{ route('admin.product-variants.edit', $variant) }}"
                                                                class="dropdown-link">
                                                                <i class="h-5 text-slate-400" data-feather="edit"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                        <li class="dropdown-list-item">
                                                            <button type="button"
                                                                class="dropdown-link delete-variant"
                                                                data-id="{{ $variant->id }}"
                                                                data-name="{{ $variant->name ?? 'Variant' }}">
                                                                <i class="h-5 text-slate-400"
                                                                    data-feather="trash"></i>
                                                                <span>Delete</span>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-8">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="w-12 h-12 text-slate-300 mb-4" data-feather="package"></i>
                                            <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No
                                                variants
                                                found</h6>
                                            <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">No variants
                                                match your
                                                search criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Variants Table Ends -->

                <!-- Variants Pagination Starts -->
                @if ($variants->hasPages())
                    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
                        <p class="text-xs font-normal text-slate-400">
                            Showing {{ $variants->firstItem() ?? 0 }} to {{ $variants->lastItem() ?? 0 }} of
                            {{ $variants->total() }} variants
                        </p>
                        <nav class="pagination">
                            <ul class="pagination-list">
                                @if ($variants->onFirstPage())
                                    <li class="pagination-item disabled">
                                        <span class="pagination-link pagination-link-prev-icon">
                                            <i data-feather="chevron-left" width="1em" height="1em"></i>
                                        </span>
                                    </li>
                                @else
                                    <li class="pagination-item">
                                        <a class="pagination-link pagination-link-prev-icon"
                                            href="{{ $variants->previousPageUrl() }}">
                                            <i data-feather="chevron-left" width="1em" height="1em"></i>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($variants->getUrlRange(1, $variants->lastPage()) as $page => $url)
                                    @if ($page == $variants->currentPage())
                                        <li class="pagination-item active">
                                            <span class="pagination-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="pagination-item">
                                            <a class="pagination-link"
                                                href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($variants->hasMorePages())
                                    <li class="pagination-item">
                                        <a class="pagination-link pagination-link-next-icon"
                                            href="{{ $variants->nextPageUrl() }}">
                                            <i data-feather="chevron-right" width="1em" height="1em"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="pagination-item disabled">
                                        <span class="pagination-link pagination-link-next-icon">
                                            <i data-feather="chevron-right" width="1em" height="1em"></i>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
                <!-- Variants Pagination Ends -->
            </div>
        @endif

        <!-- Product Info Card (only show when filtering by specific product) -->
        @if (isset($product) && $product)
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Product: {{ $product->name }}</h6>
                </div>
                <div class="card-body">
                    <div class="flex items-center gap-4">
                        @if ($product->primaryImage())
                            <img src="{{ asset($product->primaryImage()) }}" alt="{{ $product->name }}"
                                class="w-16 h-16 object-cover rounded-lg" />
                        @else
                            <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center">
                                <i class="text-slate-400" data-feather="image"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="text-lg font-medium text-slate-800 dark:text-slate-200">{{ $product->name }}
                            </h6>
                            <p class="text-sm text-slate-500 dark:text-slate-400">SKU: {{ $product->sku }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Add Variant Card (only show when filtering by specific product) -->
        @if (isset($product) && $product)
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Add New Variant</h6>
                </div>
                <div class="card-body">
                    <!-- Error Display Container -->
                    <div id="variantErrors"
                        class="hidden mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-800 dark:text-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i data-feather="alert-circle" class="h-5 w-5 text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium">Please fix the following errors:</h3>
                                <ul id="variantErrorList" class="mt-2 text-sm list-disc list-inside">
                                </ul>
                            </div>
                            <button type="button"
                                onclick="document.getElementById('variantErrors').classList.add('hidden')"
                                class="ml-auto">
                                <i data-feather="x" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>

                    <form id="addVariantForm" action="{{ route('admin.products.variants.store', $product) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <div class="space-y-2">
                                <label for="variant_name"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Variant Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="variant_name" name="name" class="input"
                                    placeholder="e.g., Small, Red, etc." required />
                            </div>

                            <div class="space-y-2">
                                <label for="variant_sku"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Variant SKU <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="variant_sku" name="sku" class="input"
                                    placeholder="Unique SKU for this variant" required />
                            </div>

                            <div class="space-y-2">
                                <label for="variant_size"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Size
                                </label>
                                <select id="variant_size" name="size_id" class="input">
                                    <option value="">Select Size</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}
                                            ({{ $size->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="variant_color"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Color
                                </label>
                                <select id="variant_color" name="color_id" class="input">
                                    <option value="">Select Color</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="variant_price"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Price
                                </label>
                                <input type="number" id="variant_price" name="price" class="input"
                                    placeholder="0.00" step="0.01" min="0" />
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Leave empty to use product price
                                </p>
                            </div>

                            <div class="space-y-2">
                                <label for="variant_sale_price"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Sale Price
                                </label>
                                <input type="number" id="variant_sale_price" name="sale_price" class="input"
                                    placeholder="0.00" step="0.01" min="0" />
                            </div>

                            <div class="space-y-2">
                                <label for="variant_stock"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Stock Quantity <span class="text-danger">*</span>
                                </label>
                                <input type="number" id="variant_stock" name="stock_quantity" class="input"
                                    placeholder="0" min="0" required />
                            </div>

                            <div class="space-y-2">
                                <label for="variant_image"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Variant Image
                                </label>
                                <input type="file" id="variant_image" name="image" class="input"
                                    accept="image/*" />
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Optional: Specific image for this variant
                                </p>
                            </div>

                            <div class="space-y-2">
                                <label for="variant_weight"
                                    class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                    Weight (kg)
                                </label>
                                <input type="number" id="variant_weight" name="weight" class="input"
                                    placeholder="0.00" step="0.01" min="0" />
                            </div>

                            <div class="space-y-2 md:col-span-2 lg:col-span-3">
                                <label class="flex items-center">
                                    <input type="checkbox" id="variant_is_active" name="is_active" class="checkbox"
                                        value="1" checked>
                                    <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Active</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="btn btn-primary" id="addVariantBtn">
                                <i data-feather="plus" class="w-4 h-4 mr-2"></i>
                                <span>Add Variant</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Current Variants (only show when filtering by specific product) -->
        @if (isset($product) && $product)
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Current Variants ({{ $product->variants->count() }} variants)</h6>
                </div>
                <div class="card-body">
                    @if ($product->variants->count() > 0)
                        <div class="space-y-4">
                            @foreach ($product->variants as $variant)
                                <div class="border border-slate-200 rounded-lg p-4 dark:border-slate-700">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            @if (isset($variant->image) && $variant->image)
                                                <img src="{{ asset($variant->image) }}"
                                                    alt="{{ $variant->name ?? 'Variant' }}"
                                                    class="w-12 h-12 object-cover rounded-lg" />
                                            @else
                                                <div
                                                    class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center">
                                                    <i class="text-slate-400" data-feather="package"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="text-sm font-medium text-slate-800 dark:text-slate-200">
                                                    {{ $variant->name ?? 'N/A' }}</h6>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">SKU:
                                                    {{ $variant->sku ?? 'N/A' }}</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                                    @if ($variant->size)
                                                        Size: {{ $variant->size->name }}
                                                    @endif
                                                    @if ($variant->size && $variant->color)
                                                        |
                                                    @endif
                                                    @if ($variant->color)
                                                        Color: {{ $variant->color->name }}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <div class="text-right">
                                                <div class="text-sm font-medium">
                                                    @if (isset($variant->sale_price) && $variant->sale_price)
                                                        <span
                                                            class="text-primary-500">${{ number_format($variant->sale_price, 2) }}</span>
                                                        <span
                                                            class="text-xs text-slate-400 line-through ml-1">${{ number_format($variant->price ?? 0, 2) }}</span>
                                                    @else
                                                        <span>${{ number_format($variant->price ?? 0, 2) }}</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-slate-500">
                                                    {{ $variant->stock_quantity ?? 0 }} in
                                                    stock</div>
                                            </div>

                                            <div class="flex gap-2">
                                                <button class="btn btn-sm btn-outline-primary"
                                                    onclick="editVariant({{ $variant->id }})">
                                                    <i data-feather="edit" class="w-3 h-3"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="deleteVariant({{ $variant->id }})">
                                                    <i data-feather="trash-2" class="w-3 h-3"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="w-12 h-12 text-slate-300 mb-4" data-feather="package"></i>
                            <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No variants created
                            </h6>
                            <p class="text-xs text-slate-400 dark:text-slate-500">Add variants for different sizes,
                                colors, or other attributes.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Action Buttons (only show when filtering by specific product) -->
        @if (isset($product) && $product)
            <div class="flex flex-col justify-end gap-3 sm:flex-row ">
                <a href="{{ route('admin.product-variants.index') }}" class="btn btn-secondary">
                    <i data-feather="arrow-left" class="h-4 w-4"></i>
                    <span>Back to All Variants</span>
                </a>
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">
                    <i data-feather="arrow-left" class="h-4 w-4"></i>
                    <span>Back to Product</span>
                </a>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                    <i data-feather="edit" class="h-4 w-4"></i>
                    <span>Edit Product</span>
                </a>
            </div>
        @endif
    </div>
    <!-- Product Variants Management Ends -->
    @push('scripts')
        <script>
            // Helper function to display validation errors
            function displayErrors(errors) {
                const errorContainer = document.getElementById('variantErrors');
                const errorList = document.getElementById('variantErrorList');

                if (!errorContainer || !errorList) return;

                // Clear previous errors
                errorList.innerHTML = '';

                // Add each error to the list
                Object.values(errors).flat().forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });

                // Show error container
                errorContainer.classList.remove('hidden');

                // Scroll to error container
                errorContainer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                // Reinitialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                const addVariantForm = document.getElementById('addVariantForm');
                const addVariantBtn = document.getElementById('addVariantBtn');

                // Only attach event listener if form exists (when product is selected)
                if (!addVariantForm || !addVariantBtn) {
                    return;
                }

                addVariantForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(addVariantForm);

                    // Check CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        alert('Error: CSRF token not found. Please refresh the page.');
                        return;
                    }

                    // Show loading state
                    addVariantBtn.innerHTML =
                        '<i data-feather="loader" class="w-4 h-4 mr-2 animate-spin"></i><span>Adding...</span>';
                    addVariantBtn.disabled = true;

                    // Construct the full URL
                    @if (isset($product) && $product)
                        const productId = {{ $product->id }};
                        const url = `/admin/products/${productId}/variants`;
                    @else
                        // This should not happen as form only exists when product is set
                        showErrorToast('Product not found. Please refresh the page.');
                        addVariantBtn.disabled = false;
                        addVariantBtn.innerHTML =
                            '<i data-feather="plus" class="w-4 h-4 mr-2"></i><span>Add Variant</span>';
                        if (typeof feather !== 'undefined') feather.replace();
                        return;
                    @endif

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(async response => {
                            const data = await response.json();

                            if (!response.ok) {
                                if (response.status === 422 && data.errors) {
                                    displayErrors(data.errors);
                                    const errorMessages = Object.values(data.errors).flat().join(
                                        '<br>');
                                    throw new Error(errorMessages);
                                } else if (data.message) {
                                    throw new Error(data.message);
                                } else {
                                    throw new Error('Failed to add variant');
                                }
                            }

                            return data;
                        })
                        .then(data => {
                            if (data.success) {
                                document.getElementById('variantErrors').classList.add('hidden');
                                showSuccessToast(data.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                        })
                        .catch(error => {
                            showErrorToast(error.message || 'An error occurred while adding the variant');
                        })
                        .finally(() => {
                            addVariantBtn.innerHTML =
                                '<i data-feather="plus" class="w-4 h-4 mr-2"></i><span>Add Variant</span>';
                            addVariantBtn.disabled = false;
                            if (typeof feather !== 'undefined') {
                                feather.replace();
                            }
                        });
                });
            });

            function editVariant(variantId) {
                window.location.href = `{{ route('admin.product-variants.edit', ':id') }}`.replace(':id', variantId);
            }

            function deleteVariant(variantId) {
                if (confirm('Are you sure you want to delete this variant?')) {
                    fetch(`{{ route('admin.product-variants.destroy', ':id') }}`.replace(':id', variantId), {
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
                                    location.reload();
                                }, 1000);
                            } else {
                                showErrorToast('Failed to delete variant');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showErrorToast(error.message || 'An error occurred while deleting the variant');
                        });
                }
            }

            // Handle delete from table
            document.addEventListener('click', function(e) {
                if (e.target.closest('.delete-variant')) {
                    const button = e.target.closest('.delete-variant');
                    const variantId = button.getAttribute('data-id');
                    const variantName = button.getAttribute('data-name');
                    if (confirm(`Are you sure you want to delete "${variantName}"?`)) {
                        deleteVariant(variantId);
                    }
                }
            });
        </script>
    @endpush
</x-admin-layout>
