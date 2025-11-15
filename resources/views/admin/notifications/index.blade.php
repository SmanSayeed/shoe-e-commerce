<x-admin-layout title="Notifications">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Notifications</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Notifications</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Notifications List Starts -->
  <div class="space-y-4">
    <!-- Filters and Actions -->
    <div class="card">
      <div class="card-body">
        <form method="GET" action="{{ route('admin.notifications.index') }}" class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div class="flex flex-col gap-4 md:flex-row md:items-center md:flex-1">
            <!-- Type Filter -->
            <div class="flex-1 md:max-w-xs">
              <label for="type" class="form-label">Filter by Type</label>
              <select name="type" id="type" class="select" onchange="this.form.submit()">
                <option value="all" {{ request('type') === 'all' || !request()->has('type') ? 'selected' : '' }}>All Types</option>
                <option value="order_success" {{ request('type') === 'order_success' ? 'selected' : '' }}>Order Success</option>
                <option value="order_cancelled" {{ request('type') === 'order_cancelled' ? 'selected' : '' }}>Order Cancelled</option>
                <option value="order_failed" {{ request('type') === 'order_failed' ? 'selected' : '' }}>Order Failed</option>
                <option value="order_status_changed" {{ request('type') === 'order_status_changed' ? 'selected' : '' }}>Status Changed</option>
              </select>
            </div>

            <!-- Status Filter -->
            <div class="flex-1 md:max-w-xs">
              <label for="status" class="form-label">Filter by Status</label>
              <select name="status" id="status" class="select" onchange="this.form.submit()">
                <option value="" {{ !request()->has('status') ? 'selected' : '' }}>All Statuses</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
              </select>
            </div>

            <!-- Date From -->
            <div class="flex-1 md:max-w-xs">
              <label for="date_from" class="form-label">Date From</label>
              <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="input" />
            </div>

            <!-- Date To -->
            <div class="flex-1 md:max-w-xs">
              <label for="date_to" class="form-label">Date To</label>
              <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="input" />
            </div>
          </div>

          <div class="flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i data-feather="filter" class="w-4 h-4 mr-2"></i>
              Apply Filters
            </button>
            <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
              <i data-feather="x" class="w-4 h-4 mr-2"></i>
              Clear
            </a>
          </div>
        </form>

        <!-- Bulk Actions -->
        <div class="mt-4 flex items-center justify-between border-t border-slate-200 dark:border-slate-700 pt-4">
          <div class="text-sm text-slate-600 dark:text-slate-400">
            Showing {{ $notifications->firstItem() ?? 0 }} to {{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }} notifications
            @if($unreadCount > 0)
              <span class="ml-2 font-semibold text-primary-600 dark:text-primary-400">{{ $unreadCount }} unread</span>
            @endif
          </div>
          <button type="button" id="markAllReadBtn" class="btn btn-outline-primary btn-sm">
            <i data-feather="check" class="w-4 h-4 mr-2"></i>
            Mark All as Read
          </button>
        </div>
      </div>
    </div>

    <!-- Notifications List -->
    <div class="card">
      <div class="card-body p-0">
        @if($notifications->count() > 0)
          <div class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($notifications as $notification)
              <div class="flex gap-4 px-6 py-4 transition-colors duration-150 hover:bg-slate-50 dark:hover:bg-slate-800/50 {{ !$notification->is_read ? 'bg-blue-50/50 dark:bg-blue-900/10' : 'bg-slate-50/30 dark:bg-slate-800/20' }}">
                <div class="flex-shrink-0">
                  <div class="flex h-10 w-10 items-center justify-center rounded-full {{ $notification->icon_color_class }}">
                    <i data-feather="{{ $notification->icon }}" width="20" height="20"></i>
                  </div>
                </div>

                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                      <h6 class="text-sm font-semibold text-slate-900 dark:text-slate-100 {{ !$notification->is_read ? 'font-bold' : '' }}">
                        {{ $notification->title }}
                        @if(!$notification->is_read)
                          <span class="ml-2 inline-flex h-2 w-2 rounded-full bg-primary-500"></span>
                        @endif
                      </h6>
                      <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $notification->message }}</p>
                      <div class="mt-2 flex items-center gap-4 text-xs text-slate-500 dark:text-slate-500">
                        <span class="flex items-center gap-1">
                          <i data-feather="clock" width="14" height="14"></i>
                          {{ $notification->created_at->diffForHumans() }}
                        </span>
                        @if($notification->order)
                          <a href="{{ route('admin.orders.show', $notification->order_id) }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400">
                            View Order #{{ $notification->order->order_number }}
                          </a>
                        @endif
                      </div>
                    </div>

                    <div class="flex items-center gap-2">
                      @if($notification->is_read)
                        <div class="flex items-center" title="Read">
                          <i data-feather="check-circle" class="w-5 h-5 text-green-500"></i>
                        </div>
                        <button type="button" class="mark-unread-btn text-slate-400 hover:text-slate-600 dark:hover:text-slate-300" data-id="{{ $notification->id }}" title="Mark as unread">
                          <i data-feather="mail" width="18" height="18"></i>
                        </button>
                      @else
                        <button type="button" class="mark-read-btn text-primary-500 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300" data-id="{{ $notification->id }}" title="Mark as read">
                          <i data-feather="check" width="18" height="18"></i>
                        </button>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Pagination -->
          <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
            {{ $notifications->links() }}
          </div>
        @else
          <div class="flex flex-col items-center justify-center py-12 px-6">
            <i class="w-16 h-16 text-slate-300 dark:text-slate-600 mb-4" data-feather="bell-off"></i>
            <h6 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-2">No notifications found</h6>
            <p class="text-xs text-slate-400 dark:text-slate-500">You're all caught up!</p>
          </div>
        @endif
      </div>
    </div>
  </div>
  <!-- Notifications List Ends -->

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Mark as read
        document.querySelectorAll('.mark-read-btn').forEach(btn => {
          btn.addEventListener('click', function () {
            const notificationId = this.getAttribute('data-id');
            markAsRead(notificationId);
          });
        });

        // Mark as unread
        document.querySelectorAll('.mark-unread-btn').forEach(btn => {
          btn.addEventListener('click', function () {
            const notificationId = this.getAttribute('data-id');
            markAsUnread(notificationId);
          });
        });

        // Mark all as read
        const markAllReadBtn = document.getElementById('markAllReadBtn');
        if (markAllReadBtn) {
          markAllReadBtn.addEventListener('click', function () {
            Swal.fire({
              title: 'Mark all as read?',
              text: 'This will mark all notifications as read.',
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3b82f6',
              cancelButtonColor: '#6b7280',
              confirmButtonText: 'Yes, mark all as read'
            }).then((result) => {
              if (result.isConfirmed) {
                fetch('{{ route("admin.notifications.read-all") }}', {
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                  }
                })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    location.reload();
                  }
                })
                .catch(error => {
                  Swal.fire('Error', 'Failed to mark all as read.', 'error');
                });
              }
            });
          });
        }

        function markAsRead(id) {
          fetch(`{{ url('admin/notifications') }}/${id}/read`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload();
            }
          })
          .catch(error => {
            Swal.fire('Error', 'Failed to mark as read.', 'error');
          });
        }

        function markAsUnread(id) {
          fetch(`{{ url('admin/notifications') }}/${id}/unread`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              location.reload();
            }
          })
          .catch(error => {
            Swal.fire('Error', 'Failed to mark as unread.', 'error');
          });
        }
      });
    </script>
  @endpush
</x-admin-layout>

