<x-admin-layout title="Categories">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Categories List</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Categories</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Categories List</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Categories List Starts -->
  <div class="space-y-4">
    <!-- Category Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <!-- Category Search Starts -->
      <form
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-72">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 placeholder:text-sm focus:border-transparent focus:outline-none focus:ring-0"
          type="text" placeholder="Search categories" />
      </form>
      <!-- Category Search Ends -->

      <!-- Category Action Starts -->
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
              <ul class="dropdown-list space-y-4 p-4">
                <li class="dropdown-list-item">
                  <h2 class="my-1 text-sm font-medium">Status</h2>
                  <select class="tom-select w-full" autocomplete="off">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                  </select>
                </li>
              </ul>
            </div>
          </div>
          <button class="btn bg-white font-medium shadow-sm dark:bg-slate-800">
            <i class="h-4" data-feather="upload"></i>
            <span class="hidden sm:inline-block">Export</span>
          </button>
        </div>

        <a class="btn btn-primary" href="{{ route('admin.categories.create') }}" role="button">
          <i data-feather="plus" height="1rem" width="1rem"></i>
          <span class="hidden sm:inline-block">Add Category</span>
        </a>
      </div>
      <!-- Category Action Ends -->
    </div>
    <!-- Category Header Ends -->

    <!-- View Toggle -->
    <div class="flex justify-end mb-4">
      <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-600">View:</span>
        <div class="flex rounded-lg border border-gray-300 overflow-hidden">
          <button id="table-view-btn" class="px-3 py-1 text-sm bg-blue-600 text-white">Table</button>
          <button id="hierarchy-view-btn" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 hover:bg-gray-200">Hierarchy</button>
        </div>
      </div>
    </div>

    <!-- Table View (Default) -->
    <div id="table-view" class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table">
        <thead>
          <tr>
            <th class="w-[5%]">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".category-checkbox" />
            </th>
            <th class="w-[25%] uppercase">Category</th>
            <th class="w-[25%] uppercase">Subcategories</th>
            <th class="w-[35%] uppercase">Products Count</th>
            <th class="w-[15%] uppercase">Status</th>
            <th class="w-[15%] uppercase">Created Date</th>
            <th class="w-[5%] !text-right uppercase">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $category)
            <tr>
              <td>
                <input class="checkbox category-checkbox" type="checkbox" />
              </td>
              <td>
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-circle">
                    @if($category->image)
                      <img class="avatar-img" src="{{ asset('storage/' . $category->image) }}"
                        alt="{{ $category->name }}" />
                    @else
                      <img class="avatar-img" src="{{ asset('images/placeholder.png') }}"
                        alt="{{ $category->name }}" />
                    @endif
                  </div>
                  <div>
                    <h6 class="whitespace-nowrap text-sm font-medium text-slate-700 dark:text-slate-100">
                      {{ $category->name }}
                    </h6>
                    <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $category->slug }}</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                  {{ $category->subcategories->count() }}
                </p>
              </td>
              <td>
                <p class="truncate text-sm text-slate-600 dark:text-slate-300">
                  {{ $category->products->count() }}
                </p>
              </td>
              <td>
                <div class="badge {{ $category->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                  {{ $category->is_active ? 'Active' : 'Inactive' }}
                </div>
              </td>
              <td>{{ $category->created_at->format('d M Y') }}</td>
              <td>
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-6 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.categories.show', $category->id) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.categories.edit', $category->id) }}" class="dropdown-link">
                            <i class="h-5 text-slate-400" data-feather="edit"></i>
                            <span>Edit</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-link text-red-600 hover:text-red-700">
                              <i class="h-5 text-red-400" data-feather="trash"></i>
                              <span>Delete</span>
                            </button>
                          </form>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-8">
                <p class="text-slate-500 dark:text-slate-400">No categories found</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-4">Create First Category</a>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Hierarchy View (Accordion) -->
    <div id="hierarchy-view" class="hidden space-y-3">
      @forelse($categories as $category)
        <div class="accordion-item bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
          <div class="accordion-header bg-gradient-to-r from-blue-500 to-blue-600 p-4 cursor-pointer flex items-center justify-between"
               onclick="toggleAdminAccordion(this)">
            <div class="flex items-center space-x-4">
              <div class="avatar avatar-circle">
                @if($category->image)
                  <img class="avatar-img w-12 h-12" src="{{ asset('storage/' . $category->image) }}"
                    alt="{{ $category->name }}" />
                @else
                  <img class="avatar-img w-12 h-12" src="{{ asset('images/placeholder.png') }}"
                    alt="{{ $category->name }}" />
                @endif
              </div>
              <div class="text-white">
                <h3 class="font-bold text-lg">{{ $category->name }}</h3>
                <div class="flex items-center space-x-4 text-sm">
                  <span>{{ $category->subcategories->count() }} subcategories</span>
                  <span>{{ $category->products->count() }} products</span>
                  <div class="badge {{ $category->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                  </div>
                </div>
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <div class="dropdown" data-placement="bottom-start">
                <div class="dropdown-toggle">
                  <i class="w-6 text-white cursor-pointer" data-feather="more-horizontal"></i>
                </div>
                <div class="dropdown-content">
                  <ul class="dropdown-list">
                    <li class="dropdown-list-item">
                      <a href="{{ route('admin.categories.show', $category->id) }}" class="dropdown-link">
                        <i class="h-5 text-slate-400" data-feather="external-link"></i>
                        <span>Details</span>
                      </a>
                    </li>
                    <li class="dropdown-list-item">
                      <a href="{{ route('admin.categories.edit', $category->id) }}" class="dropdown-link">
                        <i class="h-5 text-slate-400" data-feather="edit"></i>
                        <span>Edit</span>
                      </a>
                    </li>
                    <li class="dropdown-list-item">
                      <a href="{{ route('admin.subcategories.create') }}?category_id={{ $category->id }}" class="dropdown-link">
                        <i class="h-5 text-slate-400" data-feather="plus"></i>
                        <span>Add Subcategory</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <svg class="w-5 h-5 text-white transition-transform duration-200 accordion-chevron"
                   fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </div>
          </div>

          <div class="accordion-body hidden bg-gray-50">
            @if($category->subcategories->count() > 0)
              <div class="p-4 space-y-3">
                @foreach($category->subcategories as $subcategory)
                  <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="p-3 border-b border-gray-100">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                          <div class="avatar avatar-sm">
                            @if($subcategory->image)
                              <img class="avatar-img" src="{{ asset('storage/' . $subcategory->image) }}"
                                alt="{{ $subcategory->name }}" />
                            @else
                              <div class="avatar-placeholder bg-gray-200 text-gray-600 text-xs">
                                {{ substr($subcategory->name, 0, 1) }}
                              </div>
                            @endif
                          </div>
                          <div>
                            <h4 class="font-medium text-gray-800">{{ $subcategory->name }}</h4>
                            <div class="flex items-center space-x-3 text-sm text-gray-500">
                              <span>{{ $subcategory->childCategories->count() }} children</span>
                              <span>{{ $subcategory->products->count() }} products</span>
                              <div class="badge badge-sm {{ $subcategory->is_active ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="flex items-center space-x-2">
                          <a href="{{ route('admin.subcategories.show', $subcategory->id) }}"
                             class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                          <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}"
                             class="text-green-600 hover:text-green-800 text-sm">Edit</a>
                          <a href="{{ route('admin.child-categories.create') }}?subcategory_id={{ $subcategory->id }}"
                             class="text-purple-600 hover:text-purple-800 text-sm">+ Child</a>
                        </div>
                      </div>
                    </div>

                    @if($subcategory->childCategories->count() > 0)
                      <div class="p-3 bg-gray-25">
                        <h5 class="text-sm font-medium text-gray-700 mb-2">Child Categories:</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                          @foreach($subcategory->childCategories as $childCategory)
                            <div class="flex items-center justify-between bg-white p-2 rounded border border-gray-100">
                              <div class="flex items-center space-x-2">
                                <div class="avatar avatar-xs">
                                  @if($childCategory->image)
                                    <img class="avatar-img" src="{{ asset('storage/' . $childCategory->image) }}"
                                      alt="{{ $childCategory->name }}" />
                                  @else
                                    <div class="avatar-placeholder bg-gray-200 text-gray-600 text-xs w-6 h-6 flex items-center justify-center">
                                      {{ substr($childCategory->name, 0, 1) }}
                                    </div>
                                  @endif
                                </div>
                                <span class="text-sm text-gray-700">{{ $childCategory->name }}</span>
                              </div>
                              <div class="flex items-center space-x-1">
                                <a href="{{ route('admin.child-categories.show', $childCategory->id) }}"
                                   class="text-blue-600 hover:text-blue-800 text-xs">View</a>
                                <a href="{{ route('admin.child-categories.edit', $childCategory->id) }}"
                                   class="text-green-600 hover:text-green-800 text-xs">Edit</a>
                              </div>
                            </div>
                          @endforeach
                        </div>
                      </div>
                    @endif
                  </div>
                @endforeach
              </div>
            @else
              <div class="p-8 text-center text-gray-500">
                <p>No subcategories found for this category.</p>
                <a href="{{ route('admin.subcategories.create') }}?category_id={{ $category->id }}"
                   class="inline-block mt-2 text-blue-600 hover:text-blue-800">
                  Create First Subcategory →
                </a>
              </div>
            @endif
          </div>
        </div>
      @empty
        <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
          <p class="text-slate-500 dark:text-slate-400">No categories found</p>
          <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-4">Create First Category</a>
        </div>
      @endforelse
    </div>
    <!-- Category Table Ends -->

    <!-- Category Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }}
        categories
      </p>
      <!-- Pagination -->
      <nav class="pagination">
        <ul class="pagination-list">
          @if ($categories->onFirstPage())
            <li class="pagination-item disabled">
              <span class="pagination-link pagination-link-prev-icon">
                <i data-feather="chevron-left" width="1em" height="1em"></i>
              </span>
            </li>
          @else
            <li class="pagination-item">
              <a class="pagination-link pagination-link-prev-icon" href="{{ $categories->previousPageUrl() }}">
                <i data-feather="chevron-left" width="1em" height="1em"></i>
              </a>
            </li>
          @endif

          @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
            @if ($page == $categories->currentPage())
              <li class="pagination-item active">
                <span class="pagination-link">{{ $page }}</span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endif
          @endforeach

          @if ($categories->hasMorePages())
            <li class="pagination-item">
              <a class="pagination-link pagination-link-next-icon" href="{{ $categories->nextPageUrl() }}">
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
    <!-- Category Pagination Ends -->
  </div>
  <!-- Categories List Ends -->

  <script>
    // View toggle functionality
    document.getElementById('table-view-btn').addEventListener('click', function() {
      document.getElementById('table-view').classList.remove('hidden');
      document.getElementById('hierarchy-view').classList.add('hidden');
      this.classList.add('bg-blue-600', 'text-white');
      this.classList.remove('bg-gray-100', 'text-gray-700');
      document.getElementById('hierarchy-view-btn').classList.remove('bg-blue-600', 'text-white');
      document.getElementById('hierarchy-view-btn').classList.add('bg-gray-100', 'text-gray-700');
    });

    document.getElementById('hierarchy-view-btn').addEventListener('click', function() {
      document.getElementById('hierarchy-view').classList.remove('hidden');
      document.getElementById('table-view').classList.add('hidden');
      this.classList.add('bg-blue-600', 'text-white');
      this.classList.remove('bg-gray-100', 'text-gray-700');
      document.getElementById('table-view-btn').classList.remove('bg-blue-600', 'text-white');
      document.getElementById('table-view-btn').classList.add('bg-gray-100', 'text-gray-700');
    });

    // Admin accordion toggle function
    function toggleAdminAccordion(header) {
      const body = header.nextElementSibling;
      const chevron = header.querySelector('.accordion-chevron');
      const isOpen = !body.classList.contains('hidden');

      // Close all other accordions
      document.querySelectorAll('.accordion-body').forEach(otherBody => {
        if (otherBody !== body) {
          otherBody.classList.add('hidden');
          const otherChevron = otherBody.previousElementSibling.querySelector('.accordion-chevron');
          if (otherChevron) {
            otherChevron.style.transform = 'rotate(0deg)';
          }
        }
      });

      // Toggle current accordion
      if (isOpen) {
        body.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
      } else {
        body.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
      }
    }
  </script>
</x-admin-layout>
