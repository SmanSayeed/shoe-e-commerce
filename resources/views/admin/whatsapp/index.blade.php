<x-admin-layout title="WhatsApp Management">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>WhatsApp Management</h5>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">WhatsApp</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <div class="space-y-6">
    <!-- Statistics Cards -->
    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
      <!-- Total Chats -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-primary/20 text-primary">
            <i data-feather="message-circle" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Total Chats</p>
            <h4 class="text-2xl font-semibold">{{ number_format($stats['total_chats']) }}</h4>
          </div>
        </div>
      </div>

      <!-- Pending Chats -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-warning/20 text-warning">
            <i data-feather="clock" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Pending Chats</p>
            <h4 class="text-2xl font-semibold">{{ number_format($stats['pending_chats']) }}</h4>
          </div>
        </div>
      </div>

      <!-- Replied Chats -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-success/20 text-success">
            <i data-feather="check-circle" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Replied Chats</p>
            <h4 class="text-2xl font-semibold">{{ number_format($stats['replied_chats']) }}</h4>
          </div>
        </div>
      </div>

      <!-- Closed Chats -->
      <div class="card">
        <div class="card-body flex items-center gap-4">
          <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-info/20 text-info">
            <i data-feather="x-circle" class="text-3xl"></i>
          </div>
          <div class="flex-1">
            <p class="text-sm tracking-wide text-slate-500">Closed Chats</p>
            <h4 class="text-2xl font-semibold">{{ number_format($stats['closed_chats']) }}</h4>
          </div>
        </div>
      </div>
    </section>

    <!-- Settings and Chats -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
      <!-- WhatsApp Settings -->
      <div class="lg:col-span-1">
        <div class="card">
          <div class="card-header">
            <h6 class="card-title">WhatsApp Settings</h6>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.whatsapp.settings.update') }}" method="POST">
              @csrf
              <input type="hidden" name="_method" value="PUT">
              <div class="space-y-4">
                <!-- Enable WhatsApp -->
                <div class="flex items-center">
                  <input type="checkbox" id="whatsapp_enabled" name="whatsapp_enabled" value="1"
                         {{ $settings['whatsapp_enabled'] ? 'checked' : '' }}
                         class="rounded border-slate-300 text-primary focus:ring-primary">
                  <label for="whatsapp_enabled" class="ml-2 text-sm font-medium text-slate-700">
                    Enable WhatsApp Integration
                  </label>
                </div>

                <!-- Phone Number -->
                <div>
                  <label for="whatsapp_phone" class="block text-sm font-medium text-slate-700 mb-1">
                    WhatsApp Phone Number
                  </label>
                  <input type="text" id="whatsapp_phone" name="whatsapp_phone"
                         value="{{ old('whatsapp_phone', $settings['whatsapp_phone']) }}"
                         placeholder="+8801234567890"
                         class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                  <p class="text-xs text-slate-500 mt-1">Include country code (e.g., +880 for Bangladesh)</p>
                </div>

                <!-- Default Message -->
                <div>
                  <label for="whatsapp_message" class="block text-sm font-medium text-slate-700 mb-1">
                    Default Message
                  </label>
                  <textarea id="whatsapp_message" name="whatsapp_message" rows="3"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Hello! I need help with my order.">{{ old('whatsapp_message', $settings['whatsapp_message']) }}</textarea>
                </div>

                <!-- Enable Chat Feature -->
                <div class="flex items-center">
                  <input type="checkbox" id="whatsapp_chat_enabled" name="whatsapp_chat_enabled" value="1"
                         {{ $settings['whatsapp_chat_enabled'] ? 'checked' : '' }}
                         class="rounded border-slate-300 text-primary focus:ring-primary">
                  <label for="whatsapp_chat_enabled" class="ml-2 text-sm font-medium text-slate-700">
                    Enable Chat Feature
                  </label>
                </div>

                <button type="submit" class="w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                  Save Settings
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Recent Chats -->
      <div class="lg:col-span-2">
        <div class="card">
          <div class="card-header flex items-center justify-between">
            <h6 class="card-title">Recent Chats</h6>
            <div class="flex gap-2">
              <select id="status-filter" class="text-sm border border-slate-300 rounded px-2 py-1">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="read">Read</option>
                <option value="replied">Replied</option>
                <option value="closed">Closed</option>
              </select>
            </div>
          </div>
          <div class="card-body">
            <div class="space-y-4">
              @forelse($chats as $chat)
              <div class="border border-slate-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                      <h6 class="font-medium text-slate-900">{{ $chat->customer_name ?: 'Anonymous' }}</h6>
                      <span class="px-2 py-1 text-xs rounded-full
                        @if($chat->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($chat->status === 'read') bg-blue-100 text-blue-800
                        @elseif($chat->status === 'replied') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($chat->status) }}
                      </span>
                    </div>
                    <p class="text-sm text-slate-600 mb-2">{{ Str::limit($chat->message, 100) }}</p>
                    <div class="flex items-center gap-4 text-xs text-slate-500">
                      <span><i data-feather="phone" class="w-3 h-3 inline mr-1"></i>{{ $chat->phone_number }}</span>
                      <span><i data-feather="clock" class="w-3 h-3 inline mr-1"></i>{{ $chat->created_at->diffForHumans() }}</span>
                      @if($chat->admin)
                      <span><i data-feather="user" class="w-3 h-3 inline mr-1"></i>{{ $chat->admin->name }}</span>
                      @endif
                    </div>
                  </div>
                  <div class="flex gap-2">
                    <a href="{{ route('admin.whatsapp.chats.show', $chat->id) }}"
                       class="text-primary hover:text-primary-dark p-1">
                      <i data-feather="eye" class="w-4 h-4"></i>
                    </a>
                    @if($chat->status !== 'closed')
                    <form action="{{ route('admin.whatsapp.chats.update-status', $chat->id) }}" method="POST" class="inline">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status" value="closed">
                      <button type="submit" class="text-slate-500 hover:text-slate-700 p-1"
                              onclick="return confirm('Are you sure you want to close this chat?')">
                        <i data-feather="x" class="w-4 h-4"></i>
                      </button>
                    </form>
                    @endif
                  </div>
                </div>
              </div>
              @empty
              <div class="text-center py-8 text-slate-500">
                <i data-feather="message-circle" class="w-12 h-12 mx-auto mb-4 text-slate-300"></i>
                <p>No chats found</p>
              </div>
              @endforelse
            </div>

            @if($chats->hasPages())
            <div class="mt-6">
              {{ $chats->links() }}
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    // Status filter functionality
    document.getElementById('status-filter').addEventListener('change', function() {
      const status = this.value;
      const url = new URL(window.location);
      if (status) {
        url.searchParams.set('status', status);
      } else {
        url.searchParams.delete('status');
      }
      window.location.href = url.toString();
    });

    // Set initial filter value
    const urlParams = new URLSearchParams(window.location.search);
    const statusParam = urlParams.get('status');
    if (statusParam) {
      document.getElementById('status-filter').value = statusParam;
    }
  </script>
  @endpush
</x-admin-layout>
