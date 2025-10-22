<x-admin-layout>
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <div>
      <h5>Edit Category</h5>
      <p class="text-sm text-slate-500 dark:text-slate-400">Update category information</p>
    </div>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.categories') }}">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Edit Category</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Category Form -->
  <div class="max-w-4xl">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="space-y-6">
        <!-- Basic Information -->
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Basic Information</h6>
          </div>
          <div class="card-body space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Category Name -->
              <div>
                <label for="name" class="form-label">Category Name *</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  class="form-control"
                  value="{{ old('name', $category->name) }}"
                  required
                />
                @error('name')
                  <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
              </div>

              <!-- Category Slug -->
              <div>
                <label for="slug" class="form-label">Slug</label>
                <input
                  type="text"
                  id="slug"
                  name="slug"
                  class="form-control"
                  value="{{ old('slug', $category->slug) }}"
                  placeholder="auto-generated-from-name"
                />
                @error('slug')
                  <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Description -->
            <div>
              <label for="description" class="form-label">Description</label>
              <textarea
                id="description"
                name="description"
                class="form-control"
                rows="4"
                placeholder="Brief description of the category"
              >{{ old('description', $category->description) }}</textarea>
              @error('description')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
              @enderror
            </div>

            <!-- Category Image -->
            <div>
              <label for="image" class="form-label">Category Image</label>
              <input
                type="file"
                id="image"
                name="image"
                class="form-control"
                accept="image/*"
              />
              @error('image')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
              @enderror

              @if($category->image)
                <div class="mt-3">
                  <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Current Image:</p>
                  <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded-lg border border-slate-200 dark:border-slate-700" />
                </div>
              @endif
            </div>
          </div>
        </div>

        <!-- SEO Information -->
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">SEO Information</h6>
          </div>
          <div class="card-body space-y-4">
            <!-- Meta Title -->
            <div>
              <label for="meta_title" class="form-label">Meta Title</label>
              <input
                type="text"
                id="meta_title"
                name="meta_title"
                class="form-control"
                value="{{ old('meta_title', $category->meta_title) }}"
                placeholder="SEO title for search engines"
              />
              @error('meta_title')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
              @enderror
            </div>

            <!-- Meta Description -->
            <div>
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea
                id="meta_description"
                name="meta_description"
                class="form-control"
                rows="3"
                placeholder="SEO description for search engines"
              >{{ old('meta_description', $category->meta_description) }}</textarea>
              @error('meta_description')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Settings -->
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">Settings</h6>
          </div>
          <div class="card-body space-y-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Active Status -->
              <div>
                <label class="form-label">Status</label>
                <div class="space-y-2">
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      name="is_active"
                      value="1"
                      {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                      class="checkbox"
                    />
                    <span class="ml-2 text-sm">Active</span>
                  </label>
                </div>
              </div>

              <!-- Sort Order -->
              <div>
                <label for="sort_order" class="form-label">Sort Order</label>
                <input
                  type="number"
                  id="sort_order"
                  name="sort_order"
                  class="form-control"
                  value="{{ old('sort_order', $category->sort_order) }}"
                  min="0"
                />
                @error('sort_order')
                  <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="card">
          <div class="card-body">
            <div class="flex flex-wrap gap-3">
              <button type="submit" class="btn btn-primary">
                <i data-feather="save" class="w-4 h-4 mr-2"></i>
                Update Category
              </button>
              <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Categories
              </a>
              <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-outline-primary">
                <i data-feather="eye" class="w-4 h-4 mr-2"></i>
                View Details
              </a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</x-admin-layout>
