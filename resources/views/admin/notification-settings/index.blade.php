<x-admin-layout title="Notification Settings">
    <!-- Page Title Starts -->
    <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
        <h5>Notification Settings</h5>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Settings</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Notification Settings</a>
            </li>
        </ol>
    </div>
    <!-- Page Title Ends -->

    <!-- Notification Settings Form Starts -->
    <div class="space-y-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Pusher Configuration</h6>
                <p class="card-subtitle">Configure Pusher credentials for real-time notifications. Get your credentials
                    from <a href="https://dashboard.pusher.com/" target="_blank"
                        class="text-primary-500 hover:underline">Pusher Dashboard</a> (Free plan available).</p>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        <i class="w-5 h-5" data-feather="check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <i class="w-5 h-5" data-feather="alert-circle"></i>
                        <span>Please fix the following errors:</span>
                        <ul class="mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.notification-settings.update') }}" method="POST" class="space-y-4"
                    id="notificationSettingsForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="pusher_app_id" class="form-label">Pusher App ID</label>
                        <input type="text" id="pusher_app_id" name="pusher_app_id"
                            value="{{ old('pusher_app_id', $settings->pusher_app_id) }}"
                            class="input @error('pusher_app_id') border-red-500 @enderror"
                            placeholder="Enter Pusher App ID" />
                        @error('pusher_app_id')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pusher_key" class="form-label">Pusher Key</label>
                        <input type="text" id="pusher_key" name="pusher_key"
                            value="{{ old('pusher_key', $settings->pusher_key) }}"
                            class="input @error('pusher_key') border-red-500 @enderror"
                            placeholder="Enter Pusher Key" />
                        @error('pusher_key')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pusher_secret" class="form-label">Pusher Secret</label>
                        <input type="password" id="pusher_secret" name="pusher_secret" value=""
                            class="input @error('pusher_secret') border-red-500 @enderror"
                            placeholder="Enter Pusher Secret (leave blank to keep current)" />
                        @error('pusher_secret')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave blank if you don't want to change the secret.</div>
                    </div>

                    <div class="form-group">
                        <label for="pusher_cluster" class="form-label">Pusher Cluster</label>
                        <select id="pusher_cluster" name="pusher_cluster"
                            class="select @error('pusher_cluster') border-red-500 @enderror">
                            <option value="ap1"
                                {{ old('pusher_cluster', $settings->pusher_cluster) === 'ap1' ? 'selected' : '' }}>Asia
                                Pacific (Mumbai) - ap1</option>
                            <option value="ap2"
                                {{ old('pusher_cluster', $settings->pusher_cluster) === 'ap2' ? 'selected' : '' }}>Asia
                                Pacific (Singapore) - ap2</option>
                            <option value="ap3"
                                {{ old('pusher_cluster', $settings->pusher_cluster) === 'ap3' ? 'selected' : '' }}>Asia
                                Pacific (Tokyo) - ap3</option>
                            <option value="ap4"
                                {{ old('pusher_cluster', $settings->pusher_cluster) === 'ap4' ? 'selected' : '' }}>Asia
                                Pacific (Sydney) - ap4</option>
                            <option value="eu"
                                {{ old('pusher_cluster', $settings->pusher_cluster) === 'eu' ? 'selected' : '' }}>
                                Europe (Ireland) - eu</option>
                            <option value="us2"
                                {{ old('pusher_cluster', $settings->pusher_cluster) === 'us2' ? 'selected' : '' }}>
                                United States (Ohio) - us2</option>
                            <option value="us3"
                                {{ old('pusher_cluster', $settings->pusher_cluster) === 'us3' ? 'selected' : '' }}>
                                United States (Oregon) - us3</option>
                        </select>
                        @error('pusher_cluster')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_enabled" name="is_enabled" value="1"
                                {{ old('is_enabled', $settings->is_enabled) ? 'checked' : '' }} class="checkbox" />
                            <label for="is_enabled" class="ml-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                                Enable Real-time Notifications
                            </label>
                        </div>
                        <div class="form-text">Enable this to receive real-time order notifications via Pusher.</div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:justify-between">
                        <button type="button" id="testConnectionBtn" class="btn btn-outline-secondary">
                            <i class="w-4 h-4 mr-2" data-feather="wifi"></i>
                            Test Connection
                        </button>
                        <div class="flex gap-4">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="w-4 h-4 mr-2" data-feather="save"></i>
                                Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Notification Settings Form Ends -->

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const testBtn = document.getElementById('testConnectionBtn');
                const form = document.getElementById('notificationSettingsForm');

                if (testBtn) {
                    testBtn.addEventListener('click', function() {
                        const btn = this;
                        const originalText = btn.innerHTML;
                        btn.disabled = true;
                        btn.innerHTML =
                            '<i class="w-4 h-4 mr-2 animate-spin" data-feather="loader"></i>Testing...';

                        // Get form data for testing (we'll use current form values)
                        const formData = {
                            pusher_app_id: document.getElementById('pusher_app_id').value,
                            pusher_key: document.getElementById('pusher_key').value,
                            pusher_secret: document.getElementById('pusher_secret').value,
                            pusher_cluster: document.getElementById('pusher_cluster').value,
                            is_enabled: document.getElementById('is_enabled').checked ? '1' : '0',
                        };

                        fetch('{{ route('admin.notification-settings.test-connection') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify(formData)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: data.message,
                                        confirmButtonColor: '#3b82f6'
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Connection Failed',
                                        text: data.message,
                                        confirmButtonColor: '#ef4444'
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while testing the connection.',
                                    confirmButtonColor: '#ef4444'
                                });
                            })
                            .finally(() => {
                                btn.disabled = false;
                                btn.innerHTML = originalText;
                                if (typeof feather !== 'undefined') {
                                    feather.replace();
                                }
                            });
                    });
                }
            });
        </script>
    @endpush
</x-admin-layout>
