<x-admin-layout title="Customer Reviews">
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <div>
      <h5>Customer Reviews</h5>
      <p class="text-sm text-slate-500">Manage testimonials displayed across the storefront.</p>
    </div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="#">Content</a></li>
      <li class="breadcrumb-item"><a href="#">Reviews</a></li>
    </ol>
  </div>

  <div class="space-y-4">
    <div class="flex flex-col items-center justify-between gap-y-4 md:flex-row md:gap-y-0">
      <form method="GET" action="{{ route('admin.reviews.index') }}"
        class="group flex h-10 w-full items-center rounded-primary border border-transparent bg-white shadow-sm focus-within:border-primary-500 focus-within:ring-1 focus-within:ring-inset focus-within:ring-primary-500 dark:border-transparent dark:bg-slate-800 md:w-96">
        <div class="flex h-full items-center px-2">
          <i class="h-4 text-slate-400 group-focus-within:text-primary-500" data-feather="search"></i>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search reviews"
          class="h-full w-full border-transparent bg-transparent px-0 text-sm placeholder-slate-400 focus:border-transparent focus:outline-none focus:ring-0" />
      </form>

      <div class="flex w-full items-center justify-between gap-3 md:w-auto">
        <div class="flex gap-3">
          <button type="button" class="btn bg-white shadow-sm dark:bg-slate-800" data-drawer-target="reviewsFilterDrawer">
            <i class="w-4" data-feather="sliders"></i>
            <span class="hidden sm:inline">Filters</span>
          </button>
          <button type="button" class="btn bg-white shadow-sm dark:bg-slate-800" data-drawer-target="reviewsSortDrawer">
            <i class="w-4" data-feather="arrow-up-down"></i>
            <span class="hidden sm:inline">Sort</span>
          </button>
        </div>

        <div class="flex items-center gap-3">
          <button type="button" id="bulkDeleteBtn" class="btn btn-danger hidden">
            <i class="w-4" data-feather="trash-2"></i>
            <span>Delete Selected</span>
          </button>
          <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
            <i class="w-4" data-feather="plus"></i>
            <span>Add Review</span>
          </a>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <form id="filtersForm" method="GET" action="{{ route('admin.reviews.index') }}" class="hidden"></form>

        <form id="bulkActionForm" action="{{ route('admin.reviews.bulk-destroy') }}" method="POST">
          @csrf
          @method('DELETE')

          <div class="overflow-x-auto">
            <table class="table">
              <thead>
                <tr>
                  <th class="w-12">
                    <label class="checkbox">
                      <input type="checkbox" id="selectAll">
                      <span class="checkmark"></span>
                    </label>
                  </th>
                  <th>Reviewer</th>
                  <th>Rating</th>
                  <th>Comment</th>
                  <th>Product</th>
                  <th>Status</th>
                  <th>Homepage</th>
                  <th>Date</th>
                  <th class="w-32">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($reviews as $review)
                  <tr>
                    <td>
                      <input type="checkbox" class="item-checkbox" name="ids[]" value="{{ $review->id }}">
                    </td>
                    <td>
                      <div class="flex flex-col">
                        <span class="font-medium">{{ $review->reviewer_name ?? 'Anonymous' }}</span>
                        <span class="text-xs text-slate-500">{{ $review->reviewer_email ?? '–' }}</span>
                      </div>
                    </td>
                    <td>
                      <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                          <i class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-300' }}" data-feather="star"></i>
                        @endfor
                        <span class="text-sm text-slate-500">{{ $review->rating }}</span>
                      </div>
                    </td>
                    <td>
                      <p class="line-clamp-2 text-sm text-slate-600">{{ $review->comment }}</p>
                    </td>
                    <td>
                      <div class="flex flex-col text-sm">
                        <span>{{ $review->product_display_name ?? optional($review->product)->name ?? 'N/A' }}</span>
                        @if($review->product)
                          <span class="text-xs text-slate-500">SKU: {{ $review->product->sku ?? '—' }}</span>
                        @endif
                      </div>
                    </td>
                    <td>
                      <span class="badge {{ $review->is_approved ? 'badge-success' : 'badge-warning' }}">
                        {{ $review->is_approved ? 'Approved' : 'Pending' }}
                      </span>
                    </td>
                    <td>
                      <span class="badge {{ $review->show_on_homepage ? 'badge-primary' : 'badge-secondary' }}">
                        {{ $review->show_on_homepage ? 'Visible' : 'Hidden' }}
                      </span>
                    </td>
                    <td>
                      <div class="flex flex-col text-sm">
                        <span>{{ optional($review->reviewed_at ?? $review->created_at)->format('M d, Y') }}</span>
                        <span class="text-xs text-slate-500">Order: {{ $review->display_order }}</span>
                      </div>
                    </td>
                    <td>
                      <div class="flex items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary toggle-approval"
                          data-id="{{ $review->id }}" data-approved="{{ $review->is_approved ? '1' : '0' }}">
                          <i class="w-4" data-feather="check-circle"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary toggle-visibility"
                          data-id="{{ $review->id }}" data-visible="{{ $review->show_on_homepage ? '1' : '0' }}">
                          <i class="w-4" data-feather="eye"></i>
                        </button>
                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-warning">
                          <i class="w-4" data-feather="edit"></i>
                        </a>
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                          onsubmit="return confirm('Delete this review?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="w-4" data-feather="trash-2"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9" class="py-10 text-center text-slate-500">
                      <div class="flex flex-col items-center gap-2">
                        <i class="w-12 h-12 text-slate-300" data-feather="message-circle"></i>
                        <p>No reviews found.</p>
                        <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary btn-sm">Create the first review</a>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </form>

        @if($reviews->hasPages())
          <div class="mt-6">
            {{ $reviews->appends(request()->query())->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Filter Drawer --}}
  <div id="reviewsFilterDrawer" class="drawer">
    <div class="drawer-content w-full max-w-md">
      <div class="drawer-header">
        <h6>Filter Reviews</h6>
        <button type="button" class="drawer-close">
          <i data-feather="x"></i>
        </button>
      </div>
      <div class="drawer-body space-y-4">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="space-y-4">
          <div>
            <label class="text-sm font-medium text-slate-600">Rating</label>
            <select name="rating" class="input">
              <option value="">All ratings</option>
              @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} stars</option>
              @endfor
            </select>
          </div>
          <div>
            <label class="text-sm font-medium text-slate-600">Status</label>
            <select name="status" class="input">
              <option value="">All</option>
              <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
              <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
          </div>
          <div>
            <label class="text-sm font-medium text-slate-600">Homepage visibility</label>
            <select name="visibility" class="input">
              <option value="">All</option>
              <option value="visible" {{ request('visibility') === 'visible' ? 'selected' : '' }}>Visible</option>
              <option value="hidden" {{ request('visibility') === 'hidden' ? 'selected' : '' }}>Hidden</option>
            </select>
          </div>
          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <label class="text-sm font-medium text-slate-600">From</label>
              <input type="date" name="date_from" value="{{ request('date_from') }}" class="input">
            </div>
            <div>
              <label class="text-sm font-medium text-slate-600">To</label>
              <input type="date" name="date_to" value="{{ request('date_to') }}" class="input">
            </div>
          </div>
          <div class="flex justify-between">
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Reset</a>
            <button type="submit" class="btn btn-primary">Apply</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Sort Drawer --}}
  <div id="reviewsSortDrawer" class="drawer">
    <div class="drawer-content w-full max-w-md">
      <div class="drawer-header">
        <h6>Sort Reviews</h6>
        <button type="button" class="drawer-close">
          <i data-feather="x"></i>
        </button>
      </div>
      <div class="drawer-body space-y-2">
        @php($baseQuery = request()->except(['sort', 'direction', 'page']))
        @foreach([
          ['label' => 'Display Order', 'field' => 'display_order', 'dir' => 'asc'],
          ['label' => 'Rating (High to Low)', 'field' => 'rating', 'dir' => 'desc'],
          ['label' => 'Rating (Low to High)', 'field' => 'rating', 'dir' => 'asc'],
          ['label' => 'Newest Reviewed', 'field' => 'reviewed_at', 'dir' => 'desc'],
          ['label' => 'Oldest Reviewed', 'field' => 'reviewed_at', 'dir' => 'asc'],
        ] as $sortOption)
          <a href="{{ route('admin.reviews.index', array_merge($baseQuery, ['sort' => $sortOption['field'], 'direction' => $sortOption['dir']])) }}"
            class="flex items-center justify-between rounded border px-3 py-2 text-sm {{ request('sort', 'display_order') === $sortOption['field'] && request('direction', $sortOption['dir']) === $sortOption['dir'] ? 'border-primary-500 text-primary-600' : 'border-slate-200' }}">
            <span>{{ $sortOption['label'] }}</span>
            @if(request('sort', 'display_order') === $sortOption['field'] && request('direction', $sortOption['dir']) === $sortOption['dir'])
              <i class="w-4" data-feather="check"></i>
            @endif
          </a>
        @endforeach
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      document.getElementById('selectAll')?.addEventListener('change', function () {
        document.querySelectorAll('.item-checkbox').forEach(cb => {
          cb.checked = this.checked;
        });
        toggleBulkButton();
      });

      document.querySelectorAll('.item-checkbox').forEach(cb => {
        cb.addEventListener('change', toggleBulkButton);
      });

      function toggleBulkButton() {
        const anyChecked = document.querySelectorAll('.item-checkbox:checked').length > 0;
        document.getElementById('bulkDeleteBtn').classList.toggle('hidden', !anyChecked);
      }

      document.getElementById('bulkDeleteBtn')?.addEventListener('click', function () {
        if (!confirm('Delete the selected reviews?')) {
          return;
        }
        document.getElementById('bulkActionForm').submit();
      });

      function handleToggle(url, button, key) {
        button.disabled = true;
        fetch(url, {
          method: 'PATCH',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            window.location.reload();
          } else {
            alert(data.message || 'Action failed');
          }
        })
        .catch(() => alert('Action failed'))
        .finally(() => button.disabled = false);
      }

      document.querySelectorAll('.toggle-approval').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.id;
          handleToggle(`{{ url('admin/reviews') }}/${id}/toggle-approval`, btn, 'is_approved');
        });
      });

      document.querySelectorAll('.toggle-visibility').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.id;
          handleToggle(`{{ url('admin/reviews') }}/${id}/toggle-visibility`, btn, 'show_on_homepage');
        });
      });
    </script>
  @endpush
</x-admin-layout>
