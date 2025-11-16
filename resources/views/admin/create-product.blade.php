<x-admin-layout title="Create Product">
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
    <!-- Error Messages -->
    @if ($errors->any())
      <div class="card border-l-4 border-red-500 bg-red-50 dark:bg-red-900/20">
        <div class="card-body">
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="flex-1">
              <h3 class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">
                Please fix the following errors:
              </h3>
              <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    @endif

    @if (session('error'))
      <div class="card border-l-4 border-red-500 bg-red-50 dark:bg-red-900/20">
        <div class="card-body">
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
          </div>
        </div>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.products.store') }}" method="POST"
          enctype="multipart/form-data">
          @csrf

          <!-- Product Basic Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Information</h6>

            <!-- Category, Subcategory, Child Category in one row -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
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
            </div>

            <!-- Brand Selection (Legacy) -->
            <div class="space-y-2">
              <label for="product_brand" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Brand (Legacy)
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

            <!-- Brand Name (Text Field) -->
            <div class="space-y-2">
              <label for="product_brand_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Brand Name
              </label>
              <input type="text" id="product_brand_name" name="brand" 
                class="input @error('brand') is-invalid @enderror"
                placeholder="Enter brand name (e.g., Nike, Adidas)" 
                value="{{ old('brand') }}" />
              @error('brand')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Enter the brand name for this product. This will be used in the brands section on the homepage.
              </p>
            </div>

            <!-- Brand Logo Upload -->
            <div class="space-y-2">
              <label for="product_brand_logo" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Brand Logo
              </label>
              <input type="file" id="product_brand_logo" name="brand_logo"
                class="input @error('brand_logo') is-invalid @enderror" 
                accept="image/jpeg,image/png,image/webp,image/gif" />
              @error('brand_logo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Upload the brand logo. Recommended: 200x200px, WebP format. Max file size: 2MB
              </p>
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

              <!-- Product SKU (Auto-generated) -->
              <div class="space-y-2">
                <label for="product_sku" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  SKU <span class="text-xs text-slate-500">(Auto-generated)</span>
                </label>
                <input type="text" id="product_sku" name="sku" class="input bg-slate-50 dark:bg-slate-800 cursor-not-allowed" 
                  placeholder="ST123456 (Auto-generated)" value="" readonly />
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  SKU will be automatically generated in format ST123456 with unique random numbers
                </p>
              </div>
            </div>

            <!-- Product Slug -->
            <div class="space-y-2">
              <label for="product_slug" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Slug
              </label>
              <input type="text" id="product_slug" name="slug" class="input @error('slug') is-invalid @enderror"
                placeholder="product-slug" value="{{ old('slug') }}" />
              @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                URL-friendly version of the product name. Auto-generated from product name, but can be edited.
              </p>
            </div>

            <!-- Product Description (Rich Text Editor) -->
            <div class="space-y-2">
              <label for="product_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Description <span class="text-danger">*</span>
              </label>
              <div id="product_description" style="min-height: 300px;">
                {!! old('description') !!}
              </div>
              <textarea name="description" style="display: none;">{{ old('description') }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Product Specifications (Rich Text Editor) -->
            <div class="space-y-2">
              <label for="product_specifications" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Specifications
              </label>
              <div id="product_specifications" style="min-height: 250px;">
                {!! old('specifications') !!}
              </div>
              <textarea name="specifications" style="display: none;">{{ old('specifications') }}</textarea>
              @error('specifications')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Enter detailed product specifications. Rich text formatting is supported.
              </p>
            </div>

            <!-- YouTube Video URL -->
            <div class="space-y-2">
              <label for="product_video_url" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                YouTube Video URL
              </label>
              <input
                type="url"
                id="product_video_url"
                name="video_url"
                class="input @error('video_url') is-invalid @enderror"
                placeholder="https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID"
                value="{{ old('video_url') }}"
              />
              @error('video_url')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Enter a YouTube video URL to embed a video on the product page.
              </p>
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

            <!-- Color Selection -->
            <div class="space-y-2">
              <label for="color_id" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Color
              </label>
              <select id="color_id" name="color_id" class="input @error('color_id') is-invalid @enderror">
                <option value="">Select Color</option>
                @foreach($colors as $color)
                  <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                    {{ $color->name }}
                  </option>
                @endforeach
              </select>
              @error('color_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Select the color for this product
              </p>
            </div>

            <!-- Additional Images Upload -->
            <div class="space-y-2">
              <label for="additional_images" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Additional Images
              </label>
              <input type="file" id="additional_images" name="additional_images[]" multiple
                class="input @error('additional_images') is-invalid @enderror" accept="image/*" />
              @error('additional_images')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Upload up to 10 additional images. Max file size: 2MB each
              </p>
            </div>
          </div>

          <!-- Product Variants -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Product Variants</h6>
              <button type="button" id="add-variant-btn" class="btn btn-sm btn-primary">
                <i class="w-4 h-4" data-feather="plus"></i> Add Variant
              </button>
            </div>

            <div id="variants-container" class="space-y-4">
              <!-- First variant (required) -->
              <div class="p-4 border rounded-md border-slate-200 dark:border-slate-600 space-y-4">
                <div class="flex items-center justify-between">
                  <h6 class="font-medium">Variant #1</h6>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Size -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Size <span class="text-danger">*</span>
                    </label>
                    <select name="variants[0][size_id]" class="select" required>
                      <option value="">Select Size</option>
                      @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Stock Quantity -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Stock Quantity <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="variants[0][stock_quantity]" min="0" value="0"
                      class="input" required>
                  </div>
                </div>
              </div>
            </div>

            <!-- Hidden template for new variants -->
            <template id="variant-template">
              <div class="p-4 border rounded-md border-slate-200 dark:border-slate-600 space-y-4 variant-row">
                <div class="flex items-center justify-between">
                  <h6 class="font-medium">Variant #<span class="variant-number"></span></h6>
                  <button type="button" class="text-danger remove-variant-btn">
                    <i class="w-4 h-4" data-feather="trash-2"></i>
                  </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <!-- Size -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Size <span class="text-danger">*</span>
                    </label>
                    <select name="variants[INDEX][size_id]" class="select variant-size-select" required>
                      <option value="">Select Size</option>
                      @foreach($sizes as $size)
                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <!-- Stock Quantity -->
                  <div class="space-y-2">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                      Stock Quantity <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="variants[INDEX][stock_quantity]" min="0" value="0"
                      class="input" required>
                  </div>
                </div>
              </div>
            </template>
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
    @push('styles')
      <!-- Quill Editor CSS -->
      <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
      <style>
        .ql-editor {
          min-height: 300px;
        }
        .ql-container {
          font-size: 14px;
        }
      </style>
    @endpush
    @push('scripts')
      <!-- Quill Editor JS -->
      <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          // Initialize Quill Editor for Description
          const descriptionEditor = new Quill('#product_description', {
            theme: 'snow',
            modules: {
              toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'font': [] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                ['clean']
              ]
            },
            placeholder: 'Enter product description'
          });

          // Initialize Quill Editor for Specifications
          const specsEditor = new Quill('#product_specifications', {
            theme: 'snow',
            modules: {
              toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'font': [] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                ['clean']
              ]
            },
            placeholder: 'Enter product specifications'
          });

          // Function to sync Quill content to hidden textarea
          function syncQuillToTextarea() {
            const descTextarea = document.querySelector('textarea[name="description"]');
            const specsTextarea = document.querySelector('textarea[name="specifications"]');
            
            if (descTextarea) {
              descTextarea.value = descriptionEditor.root.innerHTML;
            }
            if (specsTextarea) {
              specsTextarea.value = specsEditor.root.innerHTML;
            }
          }

          // Initial sync on page load
          syncQuillToTextarea();

          // Sync content on every change in Quill editors
          descriptionEditor.on('text-change', function() {
            syncQuillToTextarea();
          });

          specsEditor.on('text-change', function() {
            syncQuillToTextarea();
          });

          // Also sync on editor ready (in case content is loaded after initialization)
          setTimeout(function() {
            syncQuillToTextarea();
          }, 100);

          // Function to check if Quill content is empty (just HTML tags)
          function isQuillContentEmpty(editor) {
            const text = editor.getText().trim();
            const html = editor.root.innerHTML.trim();
            // Check if it's empty or just contains empty HTML tags
            return !text || text === '\n' || html === '<p><br></p>' || html === '<p></p>' || html === '';
          }

          // Update hidden textarea with Quill content before form submission and validate
          const form = document.querySelector('form');
          if (form) {
            form.addEventListener('submit', function(e) {
              // Sync content first
              syncQuillToTextarea();
              
              // Get plain text content (without HTML tags) for validation
              const descriptionText = descriptionEditor.getText().trim();
              const descriptionHtml = descriptionEditor.root.innerHTML.trim();
              
              // Validate description is not empty
              if (isQuillContentEmpty(descriptionEditor)) {
                e.preventDefault();
                e.stopPropagation();
                
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger mb-4';
                errorDiv.innerHTML = '<strong>Error:</strong> Please enter a product description.';
                
                // Insert error message at the top of the form
                const formFirstChild = form.firstElementChild;
                if (formFirstChild) {
                  form.insertBefore(errorDiv, formFirstChild);
                } else {
                  form.prepend(errorDiv);
                }
                
                // Scroll to error
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Focus the editor
                descriptionEditor.focus();
                
                // Remove error after 5 seconds
                setTimeout(function() {
                  if (errorDiv.parentNode) {
                    errorDiv.parentNode.removeChild(errorDiv);
                  }
                }, 5000);
                
                return false;
              }
              
              // Ensure textarea has the content
              const descTextarea = form.querySelector('textarea[name="description"]');
              const specsTextarea = form.querySelector('textarea[name="specifications"]');
              
              if (descTextarea) {
                descTextarea.value = descriptionHtml;
              }
              if (specsTextarea) {
                specsTextarea.value = specsEditor.root.innerHTML;
              }
            });
          }

          // Get category select elements
          const categorySelect = document.getElementById('product_category');
          const subcategorySelect = document.getElementById('product_subcategory');
          const childCategorySelect = document.getElementById('product_child_category');
          const addVariantBtn = document.getElementById('add-variant-btn');
          const variantsContainer = document.getElementById('variants-container');
          const variantTemplate = document.getElementById('variant-template');
          let variantIndex = 1; // Start from 1 because we already have one variant

          // Verify elements exist
          if (!categorySelect) {
            console.error('Category select element not found');
          }
          if (!subcategorySelect) {
            console.error('Subcategory select element not found');
          }
          if (!childCategorySelect) {
            console.error('Child category select element not found');
          }

          // Function to load subcategories
          function loadSubcategories(categoryId) {
            if (!subcategorySelect) return;
            
            // Clear existing options
            subcategorySelect.innerHTML = '<option value="">Loading...</option>';
            subcategorySelect.disabled = true;
            
            // Clear child categories
            if (childCategorySelect) {
              childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
              childCategorySelect.disabled = true;
            }

            if (!categoryId) {
              subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
              subcategorySelect.disabled = false;
              return;
            }

            fetch(`/admin/get-subcategories?category_id=${categoryId}`, {
              method: 'GET',
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => {
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              return response.json();
            })
            .then(data => {
              subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
              if (Array.isArray(data) && data.length > 0) {
                data.forEach(subcategory => {
                  const option = document.createElement('option');
                  option.value = subcategory.id;
                  option.textContent = subcategory.name;
                  subcategorySelect.appendChild(option);
                });
              } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No subcategories available';
                subcategorySelect.appendChild(option);
              }
              subcategorySelect.disabled = false;
            })
            .catch(error => {
              console.error('Error fetching subcategories:', error);
              subcategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
              subcategorySelect.disabled = false;
            });
          }

          // Function to load child categories
          function loadChildCategories(subcategoryId) {
            if (!childCategorySelect) return;
            
            // Clear existing options
            childCategorySelect.innerHTML = '<option value="">Loading...</option>';
            childCategorySelect.disabled = true;

            if (!subcategoryId) {
              childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
              childCategorySelect.disabled = false;
              return;
            }

            fetch(`/admin/get-child-categories?subcategory_id=${subcategoryId}`, {
              method: 'GET',
              headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => {
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              return response.json();
            })
            .then(data => {
              childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
              if (Array.isArray(data) && data.length > 0) {
                data.forEach(childCategory => {
                  const option = document.createElement('option');
                  option.value = childCategory.id;
                  option.textContent = childCategory.name;
                  childCategorySelect.appendChild(option);
                });
              } else {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No child categories available';
                childCategorySelect.appendChild(option);
              }
              childCategorySelect.disabled = false;
            })
            .catch(error => {
              console.error('Error fetching child categories:', error);
              childCategorySelect.innerHTML = '<option value="">Error loading child categories</option>';
              childCategorySelect.disabled = false;
            });
          }

          // Category change event listener
          if (categorySelect) {
            categorySelect.addEventListener('change', function() {
              const selectedCategoryId = this.value;
              loadSubcategories(selectedCategoryId);
            });
          }

          // Subcategory change event listener
          if (subcategorySelect) {
            subcategorySelect.addEventListener('change', function() {
              const selectedSubcategoryId = this.value;
              loadChildCategories(selectedSubcategoryId);
            });
          }

          // Slug auto-generation from product name
          const productNameInput = document.getElementById('product_name');
          const productSlugInput = document.getElementById('product_slug');
          let slugManuallyEdited = false;

          // Function to generate slug from text
          function generateSlug(text) {
            return text
              .toString()
              .toLowerCase()
              .trim()
              .replace(/\s+/g, '-')           // Replace spaces with -
              .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
              .replace(/\-\-+/g, '-')         // Replace multiple - with single -
              .replace(/^-+/, '')             // Trim - from start of text
              .replace(/-+$/, '');            // Trim - from end of text
          }

          // Auto-generate slug when product name changes
          if (productNameInput && productSlugInput) {
            productNameInput.addEventListener('input', function() {
              if (!slugManuallyEdited) {
                const slug = generateSlug(this.value);
                productSlugInput.value = slug;
              }
            });

            // Track if user manually edits slug
            productSlugInput.addEventListener('input', function() {
              slugManuallyEdited = true;
            });

            // Reset manual edit flag when slug is cleared
            productSlugInput.addEventListener('focus', function() {
              if (this.value === '') {
                slugManuallyEdited = false;
              }
            });
          }

          // Function to add a new variant
          function addVariant() {
            if (!variantTemplate) {
              console.error('Variant template not found');
              return;
            }
            const variantRow = variantTemplate.content.cloneNode(true);
            const variantNumber = document.querySelectorAll('.variant-row').length + 1;

            // Update variant number
            variantRow.querySelector('.variant-number').textContent = variantNumber;

            // Update all elements with name containing INDEX
            variantRow.querySelectorAll('[name*="INDEX"]').forEach(element => {
              const newName = element.getAttribute('name').replace(/\[INDEX\]/g, `[${variantIndex}]`);
              element.setAttribute('name', newName);
            });

            // Add remove functionality
            const removeBtn = variantRow.querySelector('.remove-variant-btn');
            removeBtn.addEventListener('click', function() {
              this.closest('.variant-row').remove();
              // Renumber remaining variants
              document.querySelectorAll('.variant-row').forEach((row, index) => {
                row.querySelector('.variant-number').textContent = index + 1;
              });
            });

            variantsContainer.appendChild(variantRow);
            variantIndex++;

            if (typeof feather !== 'undefined') {
              feather.replace();
            }
          }

          // Add variant button click handler
          if (addVariantBtn) {
          addVariantBtn.addEventListener('click', addVariant);
          }
       });
     </script>
   @endpush
</x-admin-layout>
