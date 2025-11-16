<x-admin-layout title="Products">
  <!-- Page Title Starts -->
  <div class="mb-4 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5 class="text-lg">Products List</h5>

    <ol class="breadcrumb text-xs">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Products List Starts -->
  <div class="space-y-3">
    <!-- Product Header Starts -->
    <div class="flex flex-col items-center justify-between gap-y-3 md:flex-row md:gap-y-0">
      <!-- Search and Filters Starts -->
      <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center gap-2">
          <div class="group flex h-9 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 dark:focus-within:border-primary-500 md:w-64">
            <div class="flex h-full items-center px-2">
              <i class="h-3.5 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
            </div>
            <input
              name="search"
              value="{{ request('search') }}"
              class="h-full w-full border-transparent bg-transparent px-0 text-xs placeholder-slate-400 placeholder:text-xs focus:border-transparent focus:outline-none focus:ring-0"
              type="text" placeholder="Search products" />
            @if(request('category_id') || request('brand_id') || request('status') || request('stock') || request('sort'))
              @foreach(request()->except(['search', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
              @endforeach
            @endif
          </div>
          <button type="submit" class="btn btn-primary h-9 px-3 text-xs">
            <i class="w-3.5" data-feather="search"></i>
          </button>
        </form>

        <!-- Filter Dropdown -->
        <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm">
          <div class="dropdown" data-placement="bottom-end">
            <div class="dropdown-toggle">
              <button type="button" class="btn bg-white text-xs font-medium shadow-sm dark:bg-slate-800 h-9 px-3">
                <i class="w-3.5" data-feather="filter"></i>
                <span class="hidden sm:inline-block">Filter</span>
                <i class="w-3.5" data-feather="chevron-down"></i>
              </button>
            </div>
            <div class="dropdown-content w-72 !overflow-visible">
              <div class="p-3 space-y-3">
                @if(request('search'))
                  <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('sort'))
                  <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                @if(request('direction'))
                  <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif
                <div>
                  <label class="text-xs font-medium mb-1 block">Category</label>
                  <select name="category_id" class="input text-xs h-8">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div>
                  <label class="text-xs font-medium mb-1 block">Brand</label>
                  <select name="brand_id" class="input text-xs h-8">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                      <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div>
                  <label class="text-xs font-medium mb-1 block">Status</label>
                  <select name="status" class="input text-xs h-8">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
                <div>
                  <label class="text-xs font-medium mb-1 block">Stock Status</label>
                  <select name="stock" class="input text-xs h-8">
                    <option value="">All Stock</option>
                    <option value="in_stock" {{ request('stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="out_of_stock" {{ request('stock') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="low_stock" {{ request('stock') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                  </select>
                </div>
                <div class="flex gap-2 pt-2">
                  <button type="submit" class="btn btn-primary btn-sm text-xs flex-1">Apply</button>
                  <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm text-xs">Clear</a>
                </div>
              </div>
            </div>
          </div>
        </form>

        <!-- Sort Dropdown -->
        <div class="dropdown" data-placement="bottom-end">
          <div class="dropdown-toggle">
            <button type="button" class="btn bg-white text-xs font-medium shadow-sm dark:bg-slate-800 h-9 px-3">
              <i class="w-3.5" data-feather="arrow-up-down"></i>
              <span class="hidden sm:inline-block">Sort</span>
              <i class="w-3.5" data-feather="chevron-down"></i>
            </button>
          </div>
          <div class="dropdown-content w-56">
            <ul class="dropdown-list p-2">
              @php
                $currentSort = request('sort', 'created_at');
                $currentDirection = request('direction', 'desc');
                $queryParams = request()->except(['sort', 'direction', 'page']);
                
                // Calculate direction for each sort option
                $createdDirection = ($currentSort == 'created' && $currentDirection == 'desc') ? 'asc' : 'desc';
                $priceDirection = (request('sort') == 'price' && request('direction') == 'desc') ? 'asc' : 'desc';
                $stockDirection = (request('sort') == 'stock' && request('direction') == 'desc') ? 'asc' : 'desc';
                
                // Build query arrays
                $createdQuery = array_merge($queryParams, ['sort' => 'created', 'direction' => $createdDirection]);
                $priceQuery = array_merge($queryParams, ['sort' => 'price', 'direction' => $priceDirection]);
                $stockQuery = array_merge($queryParams, ['sort' => 'stock', 'direction' => $stockDirection]);
              @endphp
              <li class="dropdown-list-item">
                <a href="{{ request()->fullUrlWithQuery($createdQuery) }}" class="dropdown-link text-xs">
                  <span>Created Date</span>
                  @if(request('sort') == 'created')
                    <i class="w-3.5" data-feather="{{ request('direction') == 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                  @endif
                </a>
              </li>
              <li class="dropdown-list-item">
                <a href="{{ request()->fullUrlWithQuery($priceQuery) }}" class="dropdown-link text-xs">
                  <span>Price</span>
                  @if(request('sort') == 'price')
                    <i class="w-3.5" data-feather="{{ request('direction') == 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                  @endif
                </a>
              </li>
              <li class="dropdown-list-item">
                <a href="{{ request()->fullUrlWithQuery($stockQuery) }}" class="dropdown-link text-xs">
                  <span>Stock</span>
                  @if(request('sort') == 'stock')
                    <i class="w-3.5" data-feather="{{ request('direction') == 'asc' ? 'arrow-up' : 'arrow-down' }}"></i>
                  @endif
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Search and Filters Ends -->

      <!-- Product Action Starts -->
      <div class="flex items-center gap-2">
        <button class="btn bg-white text-xs font-medium shadow-sm dark:bg-slate-800 h-9 px-3 bulk-delete-btn">
          <i class="h-3.5" data-feather="trash-2"></i>
          <span class="hidden sm:inline-block">Delete</span>
        </button>
        <a class="btn btn-primary text-xs h-9 px-3" href="{{ route('admin.products.create') }}" role="button">
          <i data-feather="plus" height="0.875rem" width="0.875rem"></i>
          <span class="hidden sm:inline-block">Add Product</span>
        </a>
      </div>
      <!-- Product Action Ends -->
    </div>
    <!-- Product Header Ends -->

    <!-- Product Table Starts -->
    <div class="table-responsive whitespace-nowrap rounded-primary">
      <table class="table text-xs">
        <thead>
          <tr>
            <th class="w-[4%] py-2">
              <input class="checkbox" type="checkbox" data-check-all data-check-all-target=".product-checkbox" />
            </th>
            <th class="w-[28%] uppercase py-2">Product</th>
            <th class="w-[12%] uppercase py-2">Price</th>
            <th class="w-[12%] uppercase py-2">Stock</th>
            <th class="w-[10%] uppercase py-2">Brand</th>
            <th class="w-[10%] uppercase py-2">Category</th>
            <th class="w-[8%] uppercase py-2">Featured</th>
            <th class="w-[8%] uppercase py-2">Created</th>
            <th class="w-[8%] !text-right uppercase py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
              <td class="py-2">
                <input class="checkbox product-checkbox" type="checkbox" value="{{ $product->id }}" />
              </td>
              <td class="py-2">
                <div class="flex items-center gap-2">
                  <div class="avatar avatar-circle w-8 h-8">
                    @if($product->primaryImage())
                      <img class="avatar-img" src="{{ asset($product->primaryImage()) }}" alt="{{ $product->name }}" />
                    @else
                      <div class="avatar-img bg-slate-200 flex items-center justify-center">
                        <i class="text-slate-400 text-xs" data-feather="image"></i>
                      </div>
                    @endif
                  </div>
                  <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-1.5">
                      <h6 class="whitespace-nowrap text-xs font-medium text-slate-700 dark:text-slate-100 truncate">
                        {{ $product->name }}
                      </h6>
                      <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-primary-500 hover:text-primary-600 transition-colors" title="View Product">
                        <i class="w-3.5 h-3.5" data-feather="external-link"></i>
                      </a>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $product->sku }}</p>
                    <div class="mt-0.5">
                      @if($product->is_active)
                        <span class="badge badge-soft-success text-xs py-0 px-1.5">Active</span>
                      @else
                        <span class="badge badge-soft-danger text-xs py-0 px-1.5">Inactive</span>
                      @endif
                    </div>
                  </div>
                </div>
              </td>
              <td class="py-2">
                @if($product->sale_price)
                  <div>
                    <span class="text-xs font-semibold text-primary-500">${{ number_format($product->sale_price, 2) }}</span>
                    <br>
                    <span class="text-xs text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                  </div>
                @else
                  <span class="text-xs font-semibold">${{ number_format($product->price, 2) }}</span>
                @endif
              </td>
              <td class="py-2">
                <div class="flex flex-col">
                  <div class="flex items-center gap-1">
                    <span class="text-xs font-medium">{{ $product->totalStock() }} pcs</span>
                    <span class="text-xs text-slate-500">({{ $product->variants->count() }})</span>
                  </div>
                  @php
                    $inStockVariants = $product->variants->where('stock_quantity', '>', 0)->count();
                    $lowStockVariants = $product->variants->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', ($product->min_stock_level ?? 5))->count();
                    $outOfStockVariants = $product->variants->where('stock_quantity', 0)->count();
                  @endphp
                  @if($product->track_inventory)
                    @if($outOfStockVariants == $product->variants->count())
                      <span class="text-xs text-red-500">Out of Stock</span>
                    @elseif($lowStockVariants > 0)
                      <span class="text-xs text-orange-500">Low Stock</span>
                    @else
                      <span class="text-xs text-green-500">In Stock</span>
                    @endif
                  @else
                    <span class="text-xs text-blue-500">No Tracking</span>
                  @endif
                </div>
              </td>
              <td class="py-2">
                <span class="badge badge-soft-primary text-xs py-0.5 px-1.5">{{ $product->brand->name ?? 'N/A' }}</span>
              </td>
              <td class="py-2">
                <span class="badge badge-soft-secondary text-xs py-0.5 px-1.5">{{ $product->category->name ?? 'N/A' }}</span>
              </td>
              <td class="py-2">
                @if($product->is_featured)
                  <span class="badge badge-soft-success text-xs py-0.5 px-1.5">Yes</span>
                @else
                  <span class="badge badge-soft-secondary text-xs py-0.5 px-1.5">No</span>
                @endif
              </td>
              <td class="py-2 text-xs">{{ $product->created_at->format('d M Y') }}</td>
              <td class="py-2">
                <div class="flex justify-end">
                  <div class="dropdown" data-placement="bottom-start">
                    <div class="dropdown-toggle">
                      <i class="w-4 text-slate-400" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-content">
                      <ul class="dropdown-list">
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.show', $product) }}" class="dropdown-link text-xs">
                            <i class="h-4 text-slate-400" data-feather="external-link"></i>
                            <span>Details</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.edit', $product) }}" class="dropdown-link text-xs">
                            <i class="h-4 text-slate-400" data-feather="edit"></i>
                            <span>Edit</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.images', $product) }}" class="dropdown-link text-xs">
                            <i class="h-4 text-slate-400" data-feather="image"></i>
                            <span>Images</span>
                          </a>
                        </li>
                        <li class="dropdown-list-item">
                          <a href="{{ route('admin.products.stock', $product) }}" class="dropdown-link text-xs">
                            <i class="h-4 text-slate-400" data-feather="package"></i>
                            <span>Stock</span>
                          </a>
                        </li>
                         <li class="dropdown-list-item">
                           <button type="button" class="dropdown-link text-xs delete-product {{ $product->variants->count() > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                             data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                             {{ $product->variants->count() > 0 ? 'disabled' : '' }}>
                             <i class="h-4 text-slate-400" data-feather="trash"></i>
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
              <td colspan="9" class="text-center py-6">
                <div class="flex flex-col items-center justify-center">
                  <i class="w-10 h-10 text-slate-300 mb-3" data-feather="folder-open"></i>
                  <h6 class="text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">No products found</h6>
                  <p class="text-xs text-slate-400 dark:text-slate-500 mb-3">Get started by creating your first product.</p>
                  <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm text-xs">
                    <i data-feather="plus" class="w-3.5 h-3.5"></i>
                    <span>Add Product</span>
                  </a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <!-- Product Table Ends -->

    <!-- Product Pagination Starts -->
    <div class="flex flex-col items-center justify-between gap-y-3 md:flex-row">
      <p class="text-xs font-normal text-slate-400">
        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
      </p>
      <!-- Pagination -->
      @if ($products->hasPages())
        <nav class="pagination">
          <ul class="pagination-list">
            @if ($products->onFirstPage())
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-prev-icon">
                  <i data-feather="chevron-left" width="0.875em" height="0.875em"></i>
                </span>
              </li>
            @else
              <li class="pagination-item">
                <a class="pagination-link pagination-link-prev-icon" href="{{ $products->previousPageUrl() }}">
                  <i data-feather="chevron-left" width="0.875em" height="0.875em"></i>
                </a>
              </li>
            @endif

            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
              @if ($page == $products->currentPage())
                <li class="pagination-item active">
                  <span class="pagination-link text-xs">{{ $page }}</span>
                </li>
              @else
                <li class="pagination-item">
                  <a class="pagination-link text-xs" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach

            @if ($products->hasMorePages())
              <li class="pagination-item">
                <a class="pagination-link pagination-link-next-icon" href="{{ $products->nextPageUrl() }}">
                  <i data-feather="chevron-right" width="0.875em" height="0.875em"></i>
                </a>
              </li>
            @else
              <li class="pagination-item disabled">
                <span class="pagination-link pagination-link-next-icon">
                  <i data-feather="chevron-right" width="0.875em" height="0.875em"></i>
                </span>
              </li>
            @endif
          </ul>
        </nav>
      @endif
    </div>
    <!-- Product Pagination Ends -->
  </div>
  <!-- Products List Ends -->
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Delete confirmation
        document.querySelectorAll('.delete-product').forEach(button => {
          button.addEventListener('click', function () {
            if (this.disabled) {
              return;
            }

            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');

            Swal.fire({
              title: 'Are you sure?',
              text: `You want to delete "${productName}" product?`,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.products.destroy", ":productId") }}'.replace(':productId', productId);

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';

                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
              }
            });
          });
        });

        // Bulk delete functionality
        const bulkDeleteBtn = document.querySelector('.bulk-delete-btn');
        if (bulkDeleteBtn) {
          bulkDeleteBtn.addEventListener('click', function () {
            const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');

            if (selectedCheckboxes.length === 0) {
              Swal.fire({
                title: 'No Selection',
                text: 'Please select products to delete.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }

            const validCheckboxes = Array.from(selectedCheckboxes).filter(checkbox => {
              const row = checkbox.closest('tr');
              const variantsText = row.querySelector('td:nth-child(4)').textContent;
              const variantsCount = parseInt(variantsText.match(/\((\d+)\)/)?.[1] || '0');
              return variantsCount === 0;
            });

            if (validCheckboxes.length === 0) {
              Swal.fire({
                title: 'Cannot Delete',
                text: 'None of the selected products can be deleted because they have variants.',
                icon: 'warning',
                confirmButtonColor: '#3b82f6'
              });
              return;
            }

            const selectedIds = validCheckboxes.map(checkbox => checkbox.value);

            let confirmText = `You want to delete ${selectedIds.length} selected products?`;
            if (validCheckboxes.length !== selectedCheckboxes.length) {
              confirmText = `${selectedCheckboxes.length - validCheckboxes.length} product(s) cannot be deleted because they have variants. ${confirmText}`;
            }

            Swal.fire({
              title: 'Are you sure?',
              text: confirmText,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
              if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'DELETE';
                form.action = '{{ route("admin.products.bulk-destroy") }}';

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                selectedIds.forEach(id => {
                  const idInput = document.createElement('input');
                  idInput.type = 'hidden';
                  idInput.name = 'ids[]';
                  idInput.value = id;
                  form.appendChild(idInput);
                });

                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
              }
            });
          });
        }
      });
    </script>
  @endpush
</x-admin-layout>
