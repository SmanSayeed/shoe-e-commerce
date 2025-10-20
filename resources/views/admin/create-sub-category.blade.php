<x-admin-layout>
         <!-- Page Title Starts -->
            <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
              <h5>Create Subcategory</h5>

              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="{{ route('admin.categories') }}">Categories</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="{{ route('admin.sub-categories') }}">Subcategories</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#">Create Subcategory</a>
                </li>
              </ol>
            </div>
            <!-- Page Title Ends -->

            <!-- Create Subcategory Starts -->
            <div class="space-y-6">
              <div class="card">
                <div class="card-body">
                  <form class="space-y-6">
                    <!-- Subcategory Basic Information -->
                    <div class="space-y-4">
                      <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Subcategory Information</h6>

                      <!-- Parent Category Selection -->
                      <div class="space-y-2">
                        <label for="parent_category" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Parent Category <span class="text-danger">*</span>
                        </label>
                        <select id="parent_category" name="category_id" class="select" required>
                          <option value="">Select Parent Category</option>
                          <option value="1">Sneakers</option>
                          <option value="2">Boots</option>
                          <option value="3">Sandals</option>
                          <option value="4">Formal Shoes</option>
                        </select>
                      </div>

                      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Subcategory Name -->
                        <div class="space-y-2">
                          <label for="subcategory_name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            Subcategory Name <span class="text-danger">*</span>
                          </label>
                          <input
                            type="text"
                            id="subcategory_name"
                            name="name"
                            class="input"
                            placeholder="Enter subcategory name"
                            required
                          />
                        </div>

                        <!-- Subcategory Slug -->
                        <div class="space-y-2">
                          <label for="subcategory_slug" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            Slug <span class="text-danger">*</span>
                          </label>
                          <input
                            type="text"
                            id="subcategory_slug"
                            name="slug"
                            class="input"
                            placeholder="subcategory-slug"
                            required
                          />
                        </div>
                      </div>

                      <!-- Subcategory Description -->
                      <div class="space-y-2">
                        <label for="subcategory_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Description
                        </label>
                        <textarea
                          id="subcategory_description"
                          name="description"
                          class="textarea"
                          rows="4"
                          placeholder="Enter subcategory description"
                        ></textarea>
                      </div>

                      <!-- Subcategory Image -->
                      <div class="space-y-2">
                        <label for="subcategory_image" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Subcategory Image
                        </label>
                        <input
                          type="file"
                          id="subcategory_image"
                          name="image"
                          class="input"
                          accept="image/*"
                        />
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                          Recommended: 800x600px, Max file size: 2MB
                        </p>
                      </div>
                    </div>

                    <!-- SEO Information -->
                    <div class="space-y-4">
                      <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">SEO Information</h6>

                      <!-- Meta Title -->
                      <div class="space-y-2">
                        <label for="subcategory_meta_title" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Meta Title
                        </label>
                        <input
                          type="text"
                          id="subcategory_meta_title"
                          name="meta_title"
                          class="input"
                          placeholder="Enter meta title for SEO"
                        />
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                          Recommended: 50-60 characters for better SEO
                        </p>
                      </div>

                      <!-- Meta Description -->
                      <div class="space-y-2">
                        <label for="subcategory_meta_description" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                          Meta Description
                        </label>
                        <textarea
                          id="subcategory_meta_description"
                          name="meta_description"
                          class="textarea"
                          rows="3"
                          placeholder="Enter meta description for SEO"
                        ></textarea>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                          Recommended: 150-160 characters for better SEO
                        </p>
                      </div>
                    </div>

                    <!-- Subcategory Settings -->
                    <div class="space-y-4">
                      <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Subcategory Settings</h6>

                      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <!-- Sort Order -->
                        <div class="space-y-2">
                          <label for="subcategory_sort_order" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            Sort Order
                          </label>
                          <input
                            type="number"
                            id="subcategory_sort_order"
                            name="sort_order"
                            class="input"
                            placeholder="0"
                            min="0"
                          />
                          <p class="text-xs text-slate-500 dark:text-slate-400">
                            Lower numbers appear first in the list
                          </p>
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                          <label for="subcategory_is_active" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                            Status
                          </label>
                          <select id="subcategory_is_active" name="is_active" class="select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col justify-end gap-3 sm:flex-row sm:gap-0">
                      <a href="{{ route('admin.sub-categories') }}" class="btn btn-secondary">
                        <i data-feather="x" class="h-4 w-4"></i>
                        <span>Cancel</span>
                      </a>
                      <button type="submit" class="btn btn-primary">
                        <i data-feather="save" class="h-4 w-4"></i>
                        <span>Create Subcategory</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Create Subcategory Ends -->
</x-admin-layout>