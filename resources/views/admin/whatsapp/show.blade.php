<x-admin-layout title="Chat Details">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Chat Details</h5>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.whatsapp.index') }}">WhatsApp</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Chat #{{ $chat->id }}</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Chat Details -->
    <div class="lg:col-span-2">
      <div class="card">
        <div class="card-header flex items-center justify-between">
          <h6 class="card-title">Chat #{{ $chat->id }}</h6>
          <div class="flex items-center gap-2">
            <span class="px-3 py-1 text-sm rounded-full
              @if($chat->status === 'pending') bg-yellow-100 text-yellow-800
              @elseif($chat->status === 'read') bg-blue-100 text-blue-800
              @elseif($chat->status === 'replied') bg-green-100 text-green-800
              @else bg-gray-100 text-gray-800
              @endif">
              {{ ucfirst($chat->status) }}
            </span>
          </div>
        </div>
        <div class="card-body">
          <!-- Customer Message -->
          <div class="bg-slate-50 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center">
                  <i data-feather="user" class="w-5 h-5 text-primary"></i>
                </div>
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                  <h6 class="font-medium text-slate-900">{{ $chat->customer_name ?: 'Anonymous Customer' }}</h6>
                  <span class="text-xs text-slate-500">{{ $chat->created_at->format('M d, Y H:i') }}</span>
                </div>
                <p class="text-slate-700 whitespace-pre-wrap">{{ $chat->message }}</p>
                <div class="mt-2 text-sm text-slate-500">
                  <i data-feather="phone" class="w-4 h-4 inline mr-1"></i>
                  {{ $chat->phone_number }}
                </div>
              </div>
            </div>
          </div>

          <!-- Admin Reply -->
          @if($chat->admin_reply)
          <div class="bg-primary/5 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
              <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                  <i data-feather="user" class="w-5 h-5 text-white"></i>
                </div>
              </div>
              <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                  <h6 class="font-medium text-slate-900">{{ $chat->admin->name ?? 'Admin' }}</h6>
                  <span class="text-xs text-slate-500">{{ $chat->replied_at?->format('M d, Y H:i') }}</span>
                </div>
                <p class="text-slate-700 whitespace-pre-wrap">{{ $chat->admin_reply }}</p>
              </div>
            </div>
          </div>
          @endif

          <!-- Reply Form -->
          @if($chat->status !== 'closed')
          <div class="border-t border-slate-200 pt-6">
            <h6 class="text-lg font-medium text-slate-900 mb-4">
              {{ $chat->admin_reply ? 'Update Reply' : 'Send Reply' }}
            </h6>
            <form action="{{ route('admin.whatsapp.chats.reply', $chat->id) }}" method="POST">
              @csrf
              <div class="space-y-4">
                <div>
                  <label for="admin_reply" class="block text-sm font-medium text-slate-700 mb-2">
                    Your Reply
                  </label>
                  <textarea id="admin_reply" name="admin_reply" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            placeholder="Type your reply here..." required>{{ old('admin_reply', $chat->admin_reply) }}</textarea>
                </div>
                <div class="flex gap-3">
                  <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                    {{ $chat->admin_reply ? 'Update Reply' : 'Send Reply' }}
                  </button>
                  <form action="{{ route('admin.whatsapp.chats.update-status', $chat->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="closed">
                    <button type="submit" class="bg-slate-500 text-white px-6 py-2 rounded-lg hover:bg-slate-600 transition-colors"
                            onclick="return confirm('Are you sure you want to close this chat?')">
                      Close Chat
                    </button>
                  </form>
                </div>
              </div>
            </form>
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Chat Info Sidebar -->
    <div class="lg:col-span-1">
      <div class="card">
        <div class="card-header">
          <h6 class="card-title">Chat Information</h6>
        </div>
        <div class="card-body space-y-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <form action="{{ route('admin.whatsapp.chats.update-status', $chat->id) }}" method="POST">
              @csrf
              @method('PATCH')
              <select name="status" onchange="this.form.submit()"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="pending" {{ $chat->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="read" {{ $chat->status === 'read' ? 'selected' : '' }}>Read</option>
                <option value="replied" {{ $chat->status === 'replied' ? 'selected' : '' }}>Replied</option>
                <option value="closed" {{ $chat->status === 'closed' ? 'selected' : '' }}>Closed</option>
              </select>
            </form>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Customer Name</label>
            <p class="text-sm text-slate-900">{{ $chat->customer_name ?: 'Not provided' }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
            <p class="text-sm text-slate-900">{{ $chat->phone_number }}</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Created</label>
            <p class="text-sm text-slate-900">{{ $chat->created_at->format('M d, Y H:i') }}</p>
          </div>

          @if($chat->replied_at)
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Last Replied</label>
            <p class="text-sm text-slate-900">{{ $chat->replied_at->format('M d, Y H:i') }}</p>
          </div>
          @endif

          @if($chat->admin)
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Handled by</label>
            <p class="text-sm text-slate-900">{{ $chat->admin->name }}</p>
          </div>
          @endif

          <div class="pt-4 border-t border-slate-200">
            <a href="https://wa.me/{{ $chat->phone_number }}"
               target="_blank"
               class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors inline-flex items-center justify-center gap-2">
              <i data-feather="external-link" class="w-4 h-4"></i>
              Open in WhatsApp
            </a>
          </div>

          <div class="pt-2">
            <form action="{{ route('admin.whatsapp.chats.destroy', $chat->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this chat?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                Delete Chat
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-6">
    <a href="{{ route('admin.whatsapp.index') }}"
       class="bg-slate-500 text-white px-4 py-2 rounded-lg hover:bg-slate-600 transition-colors inline-flex items-center gap-2">
      <i data-feather="arrow-left" class="w-4 h-4"></i>
      Back to Chats
    </a>
  </div>
</x-admin-layout>
