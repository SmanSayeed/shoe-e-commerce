<x-admin-layout>
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Create Size Variant</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.product-variants.index') }}">Size Variants</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Create</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <!-- Create Product Variant Starts -->
    <div class="space-y-6">
        <!-- Create Variant Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Variant Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product-variants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Variant Name -->
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Variant Name <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="input @error('name') is-invalid @enderror"
                                placeholder="e.g., Small, Red, etc."
                                value="{{ old('name') }}"
                                required
                            />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div class="space-y-2">
                            <label for="sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                SKU <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="sku"
                                name="sku"
                                class="input @error('sku') is-invalid @enderror"
                                placeholder="Unique SKU for this variant"
                                value="{{ old('sku') }}"
                                required
                            />
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Size -->
                        <div class="space-y-2">
                            <label for="size_id" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Size <span class="text-danger">*</span>
                            </label>
                            <select
                                id="size_id"
                                name="size_id"
                                class="input @error('size_id') is-invalid @enderror"
                                required
                            >
                                <option value="">Select Size</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>
                                        {{ $size->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('size_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="space-y-2">
                            <label for="price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Price
                            </label>
                            <input
                                type="number"
                                id="price"
                                name="price"
                                class="input @error('price') is-invalid @enderror"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                                value="{{ old('price') }}"
                            />
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Leave empty to use product price
                            </p>
                        </div>

                        <!-- Sale Price -->
                        <div class="space-y-2">
                            <label for="sale_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Sale Price
                            </label>
                            <input
                                type="number"
                                id="sale_price"
                                name="sale_price"
                                class="input @error('sale_price') is-invalid @enderror"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                                value="{{ old('sale_price') }}"
                            />
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="space-y-2">
                            <label for="stock_quantity" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Stock Quantity <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                id="stock_quantity"
                                name="stock_quantity"
                                class="input @error('stock_quantity') is-invalid @enderror"
                                placeholder="0"
                                min="0"
                                value="{{ old('stock_quantity') }}"
                                required
                            />
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="space-y-2">
                            <label for="image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Variant Image
                            </label>
                            <input
                                type="file"
                                id="image"
                                name="image"
                                class="input @error('image') is-invalid @enderror"
                                accept="image/*"
                            />
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Optional: Specific image for this variant
                            </p>
                        </div>

                        <!-- Weight -->
                        <div class="space-y-2">
                            <label for="weight" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                                Weight (kg)
                            </label>
                            <input
                                type="number"
                                id="weight"
                                name="weight"
                                class="input @error('weight') is-invalid @enderror"
                                placeholder="0.00"
                                step="0.01"
                                min="0"
                                value="{{ old('weight') }}"
                            />
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="space-y-2 md:col-span-2 lg:col-span-3">
                            <label class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" class="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Active</span>
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 gap-3">
                        <a href="{{ route('admin.product-variants.index') }}" class="btn btn-secondary">
                            <i data-feather="x" class="w-4 h-4"></i>
                            <span>Cancel</span>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i data-feather="save" class="w-4 h-4 mr-2"></i>
                            <span>Create Variant</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Create Product Variant Ends -->
</x-admin-layout>