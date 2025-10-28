<x-admin-layout>
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Create Product</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.products.index') }}">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Create Product</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Create Product Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.products.store') }}" method="POST"
          enctype="multipart/form-data">
          @csrf

          <!-- Product Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Information</h6>

            <!-- Category Selection -->
            <div class="space-y-2">
              <label for="product_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Category <span class="text-danger">*</span>
              </label>
              <select id="product_category" name="category_id" class="select @error('category_id') is-invalid @enderror"
                required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Subcategory Selection -->
            <div class="space-y-2">
              <label for="product_subcategory" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Subcategory
              </label>
              <select id="product_subcategory" name="subcategory_id"
                class="select @error('subcategory_id') is-invalid @enderror">
                <option value="">Select Subcategory</option>
                <!-- Will be populated by JavaScript based on category selection -->
              </select>
              @error('subcategory_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Child Category Selection -->
            <div class="space-y-2">
              <label for="product_child_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Child Category
              </label>
              <select id="product_child_category" name="child_category_id"
                class="select @error('child_category_id') is-invalid @enderror">
                <option value="">Select Child Category</option>
                <!-- Will be populated by JavaScript based on subcategory selection -->
              </select>
              @error('child_category_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Brand Selection -->
            <div class="space-y-2">
              <label for="product_brand" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Brand
              </label>
              <select id="product_brand" name="brand_id" class="select @error('brand_id') is-invalid @enderror">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                  <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                  </option>
                @endforeach
              </select>
              @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Product Name -->
              <div class="space-y-2">
                <label for="product_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Product Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="product_name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="Enter product name" value="{{ old('name') }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Product SKU -->
              <div class="space-y-2">
                <label for="product_sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  SKU <span class="text-danger">*</span>
                </label>
                <input type="text" id="product_sku" name="sku" class="input @error('sku') is-invalid @enderror"
                  placeholder="Enter product SKU" value="{{ old('sku') }}" required />
                @error('sku')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Product Description -->
            <div class="space-y-2">
              <label for="product_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description <span class="text-danger">*</span>
              </label>
              <textarea id="product_description" name="description"
                class="textarea @error('description') is-invalid @enderror" rows="4"
                placeholder="Enter product description" required>{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Product Short Description -->
            <div class="space-y-2">
              <label for="product_short_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Short Description
              </label>
              <textarea id="product_short_description" name="short_description"
                class="textarea @error('short_description') is-invalid @enderror" rows="2"
                placeholder="Enter short description">{{ old('short_description') }}</textarea>
              @error('short_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Main Image Upload -->
            <div class="space-y-2">
              <label for="product_main_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Main Image
              </label>
              <input type="file" id="product_main_image" name="main_image"
                class="input @error('main_image') is-invalid @enderror" accept="image/*" required />
              @error('main_image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 800x600px, Max file size: 2MB
              </p>
            </div>
          </div>

          <!-- Product Pricing -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Pricing</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
              <!-- Regular Price -->
              <div class="space-y-2">
                <label for="product_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Regular Price <span class="text-danger">*</span>
                </label>
                <input type="number" id="product_price" name="price" class="input @error('price') is-invalid @enderror"
                  placeholder="0.00" step="0.01" min="0" value="{{ old('price') }}" required />
                @error('price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Sale Price -->
              <div class="space-y-2">
                <label for="product_sale_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Sale Price
                </label>
                <input type="number" id="product_sale_price" name="sale_price"
                  class="input @error('sale_price') is-invalid @enderror" placeholder="0.00" step="0.01" min="0"
                  value="{{ old('sale_price') }}" />
                @error('sale_price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Cost Price -->
              <div class="space-y-2">
                <label for="product_cost_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Cost Price
                </label>
                <input type="number" id="product_cost_price" name="cost_price"
                  class="input @error('cost_price') is-invalid @enderror" placeholder="0.00" step="0.01" min="0"
                  value="{{ old('cost_price') }}" />
                @error('cost_price')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

           <!-- Stock Management -->
           <div class="space-y-4">
             <div class="flex items-center justify-between">
               <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Stock Management</h6>
               <a href="#" class="btn btn-sm btn-outline-primary"
                 onclick="alert('Stock is managed per variant. Go to Product Details > Manage Variants to set stock for each color/size combination.')">
                 <i data-feather="info" class="w-4 h-4"></i>
                 Manage Variants
               </a>
             </div>

             <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
               <div class="flex">
                 <div class="flex-shrink-0">
                   <i data-feather="info" class="h-5 w-5 text-blue-400"></i>
                 </div>
                 <div class="ml-3">
                   <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                     Variant-Based Stock Management
                   </h3>
                   <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                     <p>This product uses variant-based stock management. Stock quantities are managed per color and size
                       combination through product variants.</p>
                     <p class="mt-1">You can create one variant now or add more variants later through <strong>Product Details > Manage Variants</strong>.</p>
                   </div>
                 </div>
               </div>
             </div>

             <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
               <!-- Track Inventory -->
               <div class="space-y-2">
                 <label for="product_track_inventory" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Track Inventory
                 </label>
                 <select id="product_track_inventory" name="track_inventory"
                   class="select @error('track_inventory') is-invalid @enderror">
                   <option value="1" {{ old('track_inventory', 1) == 1 ? 'selected' : '' }}>Yes</option>
                   <option value="0" {{ old('track_inventory') == 0 ? 'selected' : '' }}>No</option>
                 </select>
                 @error('track_inventory')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                 <p class="text-xs text-slate-500 dark:text-slate-400">
                   Enable inventory tracking for this product
                 </p>
               </div>

               <!-- Min Stock Level -->
               <div class="space-y-2">
                 <label for="product_min_stock_level" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Min Stock Level (Global)
                 </label>
                 <input type="number" id="product_min_stock_level" name="min_stock_level"
                   class="input @error('min_stock_level') is-invalid @enderror" placeholder="0" min="0"
                   value="{{ old('min_stock_level', 0) }}" />
                 @error('min_stock_level')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                 <p class="text-xs text-slate-500 dark:text-slate-400">
                   Global minimum stock level (applied to all variants)
                 </p>
               </div>
             </div>

             <!-- Create Variant Option -->
             <div class="space-y-2">
               <label class="flex items-center">
                 <input type="checkbox" id="create_variant" name="create_variant" value="1"
                   class="rounded border-slate-300 text-primary focus:ring-primary dark:border-slate-600 dark:bg-slate-700"
                   {{ old('create_variant') ? 'checked' : '' }}>
                 <span class="ml-2 text-sm font-medium text-slate-600 dark:text-slate-400">
                   Create one variant now
                 </span>
               </label>
               <p class="text-xs text-slate-500 dark:text-slate-400">
                 Check this to add a single variant during product creation. You can add more variants later.
               </p>
             </div>
           </div>

           <!-- Variant Information (shown when create_variant is checked) -->
           <div id="variant_section" class="space-y-4" style="display: none;">
             <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Variant Information</h6>

             <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
               <!-- Variant Name -->
               <div class="space-y-2">
                 <label for="variant_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Variant Name <span class="text-danger">*</span>
                 </label>
                 <input type="text" id="variant_name" name="variant_name"
                   class="input @error('variant_name') is-invalid @enderror"
                   placeholder="e.g., Red - Large" value="{{ old('variant_name') }}" />
                 @error('variant_name')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>

               <!-- Variant SKU -->
               <div class="space-y-2">
                 <label for="variant_sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Variant SKU <span class="text-danger">*</span>
                 </label>
                 <input type="text" id="variant_sku" name="variant_sku"
                   class="input @error('variant_sku') is-invalid @enderror"
                   placeholder="Unique variant SKU" value="{{ old('variant_sku') }}" />
                 @error('variant_sku')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>
             </div>

             <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
               <!-- Variant Color -->
               <div class="space-y-2">
                 <label for="variant_color_id" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Color
                 </label>
                 <select id="variant_color_id" name="variant_color_id"
                   class="select @error('variant_color_id') is-invalid @enderror">
                   <option value="">Select Color</option>
                   @foreach($colors as $color)
                     <option value="{{ $color->id }}" {{ old('variant_color_id') == $color->id ? 'selected' : '' }}>
                       {{ $color->name }}
                     </option>
                   @endforeach
                 </select>
                 @error('variant_color_id')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>

               <!-- Variant Size -->
               <div class="space-y-2">
                 <label for="variant_size_id" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Size
                 </label>
                 <select id="variant_size_id" name="variant_size_id"
                   class="select @error('variant_size_id') is-invalid @enderror">
                   <option value="">Select Size</option>
                   @foreach($sizes as $size)
                     <option value="{{ $size->id }}" {{ old('variant_size_id') == $size->id ? 'selected' : '' }}>
                       {{ $size->name }}
                     </option>
                   @endforeach
                 </select>
                 @error('variant_size_id')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>
             </div>

             <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
               <!-- Variant Price -->
               <div class="space-y-2">
                 <label for="variant_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Variant Price
                 </label>
                 <input type="number" id="variant_price" name="variant_price"
                   class="input @error('variant_price') is-invalid @enderror"
                   placeholder="0.00" step="0.01" min="0" value="{{ old('variant_price') }}" />
                 @error('variant_price')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>

               <!-- Variant Sale Price -->
               <div class="space-y-2">
                 <label for="variant_sale_price" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Variant Sale Price
                 </label>
                 <input type="number" id="variant_sale_price" name="variant_sale_price"
                   class="input @error('variant_sale_price') is-invalid @enderror"
                   placeholder="0.00" step="0.01" min="0" value="{{ old('variant_sale_price') }}" />
                 @error('variant_sale_price')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>

               <!-- Variant Stock Quantity -->
               <div class="space-y-2">
                 <label for="variant_stock_quantity" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Stock Quantity <span class="text-danger">*</span>
                 </label>
                 <input type="number" id="variant_stock_quantity" name="variant_stock_quantity"
                   class="input @error('variant_stock_quantity') is-invalid @enderror"
                   placeholder="0" min="0" value="{{ old('variant_stock_quantity') }}" />
                 @error('variant_stock_quantity')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>
             </div>

             <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
               <!-- Variant Weight -->
               <div class="space-y-2">
                 <label for="variant_weight" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Variant Weight (kg)
                 </label>
                 <input type="number" id="variant_weight" name="variant_weight"
                   class="input @error('variant_weight') is-invalid @enderror"
                   placeholder="0.00" step="0.01" min="0" value="{{ old('variant_weight') }}" />
                 @error('variant_weight')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
               </div>

               <!-- Variant Image -->
               <div class="space-y-2">
                 <label for="variant_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                   Variant Image
                 </label>
                 <input type="file" id="variant_image" name="variant_image"
                   class="input @error('variant_image') is-invalid @enderror" accept="image/*" />
                 @error('variant_image')
                   <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
                 <p class="text-xs text-slate-500 dark:text-slate-400">
                   Optional: Upload a specific image for this variant
                 </p>
               </div>
             </div>

             <!-- Variant Status -->
             <div class="space-y-2">
               <label for="variant_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                 Variant Status
               </label>
               <select id="variant_is_active" name="variant_is_active"
                 class="select @error('variant_is_active') is-invalid @enderror">
                 <option value="1" {{ old('variant_is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                 <option value="0" {{ old('variant_is_active') == 0 ? 'selected' : '' }}>Inactive</option>
               </select>
               @error('variant_is_active')
                 <div class="invalid-feedback">{{ $message }}</div>
               @enderror
             </div>
           </div>

          <!-- Product Details -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Details</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Weight -->
              <div class="space-y-2">
                <label for="product_weight" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Weight (kg)
                </label>
                <input type="number" id="product_weight" name="weight"
                  class="input @error('weight') is-invalid @enderror" placeholder="0.00" step="0.01" min="0"
                  value="{{ old('weight') }}" />
                @error('weight')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Dimensions -->
              <div class="space-y-2">
                <label for="product_dimensions" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Dimensions
                </label>
                <input type="text" id="product_dimensions" name="dimensions"
                  class="input @error('dimensions') is-invalid @enderror" placeholder="L x W x H (cm)"
                  value="{{ old('dimensions') }}" />
                @error('dimensions')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Material -->
              <div class="space-y-2">
                <label for="product_material" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Material
                </label>
                <input type="text" id="product_material" name="material"
                  class="input @error('material') is-invalid @enderror" placeholder="Enter material"
                  value="{{ old('material') }}" />
                @error('material')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Color -->
              <div class="space-y-2">
                <label for="product_color" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Color
                </label>
                <input type="text" id="product_color" name="color" class="input @error('color') is-invalid @enderror"
                  placeholder="Enter color" value="{{ old('color') }}" />
                @error('color')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Size Guide -->
            <div class="space-y-2">
              <label for="product_size_guide" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Size Guide
              </label>
              <textarea id="product_size_guide" name="size_guide"
                class="textarea @error('size_guide') is-invalid @enderror" rows="3"
                placeholder="Enter size guide information">{{ old('size_guide') }}</textarea>
              @error('size_guide')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- SEO Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">SEO Information</h6>

            <!-- Meta Title -->
            <div class="space-y-2">
              <label for="product_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Title
              </label>
              <input type="text" id="product_meta_title" name="meta_title"
                class="input @error('meta_title') is-invalid @enderror" placeholder="Enter meta title for SEO"
                value="{{ old('meta_title') }}" />
              @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 50-60 characters for better SEO
              </p>
            </div>

            <!-- Meta Description -->
            <div class="space-y-2">
              <label for="product_meta_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Description
              </label>
              <textarea id="product_meta_description" name="meta_description"
                class="textarea @error('meta_description') is-invalid @enderror" rows="3"
                placeholder="Enter meta description for SEO">{{ old('meta_description') }}</textarea>
              @error('meta_description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Recommended: 150-160 characters for better SEO
              </p>
            </div>

            <!-- Meta Keywords -->
            <div class="space-y-2">
              <label for="product_meta_keywords" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Meta Keywords
              </label>
              <input type="text" id="product_meta_keywords" name="meta_keywords"
                class="input @error('meta_keywords') is-invalid @enderror"
                placeholder="Enter keywords separated by commas"
                value="{{ old('meta_keywords') ? (is_array(old('meta_keywords')) ? implode(', ', old('meta_keywords')) : old('meta_keywords')) : '' }}" />
              @error('meta_keywords')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- Product Settings -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Settings</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
              <!-- Status -->
              <div class="space-y-2">
                <label for="product_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Status
                </label>
                <select id="product_is_active" name="is_active" class="select @error('is_active') is-invalid @enderror">
                  <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Featured -->
              <div class="space-y-2">
                <label for="product_is_featured" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Featured
                </label>
                <select id="product_is_featured" name="is_featured"
                  class="select @error('is_featured') is-invalid @enderror">
                  <option value="1" {{ old('is_featured') == 1 ? 'selected' : '' }}>Yes</option>
                  <option value="0" {{ old('is_featured') == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('is_featured')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Digital Product -->
              <div class="space-y-2">
                <label for="product_is_digital" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Digital Product
                </label>
                <select id="product_is_digital" name="is_digital"
                  class="select @error('is_digital') is-invalid @enderror">
                  <option value="1" {{ old('is_digital') == 1 ? 'selected' : '' }}>Yes</option>
                  <option value="0" {{ old('is_digital') == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('is_digital')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row ">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Create Product</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Create Product Ends -->
   @push('scripts')
     <script>
       document.addEventListener('DOMContentLoaded', function () {
         const categorySelect = document.getElementById('product_category');
         const subcategorySelect = document.getElementById('product_subcategory');
         const childCategorySelect = document.getElementById('product_child_category');
         const createVariantCheckbox = document.getElementById('create_variant');
         const variantSection = document.getElementById('variant_section');

         // Function to toggle variant section visibility
         function toggleVariantSection() {
           if (createVariantCheckbox.checked) {
             variantSection.style.display = 'block';
           } else {
             variantSection.style.display = 'none';
           }
         }

         // Initial check on page load
         toggleVariantSection();

         // Listen for checkbox changes
         createVariantCheckbox.addEventListener('change', toggleVariantSection);

         // Filter subcategories based on selected category
         categorySelect.addEventListener('change', function () {
           const selectedCategoryId = this.value;

           // Reset subcategory and child category selections
           subcategorySelect.value = '';
           childCategorySelect.value = '';

           if (selectedCategoryId) {
             // Fetch subcategories for selected category
             fetch(`/admin/get-subcategories?category_id=${selectedCategoryId}`)
               .then(response => response.json())
               .then(data => {
                 subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                 data.forEach(subcategory => {
                   const option = document.createElement('option');
                   option.value = subcategory.id;
                   option.textContent = subcategory.name;
                   subcategorySelect.appendChild(option);
                 });
               })
               .catch(error => {
                 console.error('Error fetching subcategories:', error);
               });
           } else {
             subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
             childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
           }
         });

         // Filter child categories based on selected subcategory
         subcategorySelect.addEventListener('change', function () {
           const selectedSubcategoryId = this.value;

           // Reset child category selection
           childCategorySelect.value = '';

           if (selectedSubcategoryId) {
             // Fetch child categories for selected subcategory
             fetch(`/admin/get-child-categories?subcategory_id=${selectedSubcategoryId}`)
               .then(response => response.json())
               .then(data => {
                 childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
                 data.forEach(childCategory => {
                   const option = document.createElement('option');
                   option.value = childCategory.id;
                   option.textContent = childCategory.name;
                   childCategorySelect.appendChild(option);
                 });
               })
               .catch(error => {
                 console.error('Error fetching child categories:', error);
               });
           } else {
             childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
           }
         });
       });
     </script>
   @endpush
</x-admin-layout>
