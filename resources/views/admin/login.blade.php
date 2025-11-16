<x-auth-layout>
    @php
        $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
        $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
        $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
        $accentColor = \App\Helpers\SiteSettingsHelper::accentColor();
    @endphp
    <div class="card mx-auto w-full max-w-md p-4 xl:p-6">
        <form method="POST" action="{{ route('admin.secret-login.authenticate') }}">
            @csrf
            <div class="flex flex-col items-center justify-center">
                @if($logoUrl)
                    <!-- Dynamic Logo Image -->
                    <div class="mb-4">
                        <a href="{{ route('home') }}" class="block">
                            <img src="{{ $logoUrl }}" 
                                 alt="{{ $websiteName }}" 
                                 class="h-12 sm:h-16 w-auto object-contain mx-auto transition-transform duration-300 hover:scale-105 cursor-pointer" 
                                 loading="eager"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                        </a>
                    </div>
                @else
                    <!-- Fallback Logo Badge -->
                    <div class="mb-4 flex items-center justify-center">
                        <div class="relative">
                            <div class="absolute inset-0 rounded-xl opacity-0 hover:opacity-100 transition-opacity duration-300 blur-sm" 
                                 style="background: linear-gradient(135deg, {{ $primaryColor }}, {{ $accentColor }});"></div>
                            <div class="relative flex items-center justify-center h-16 w-16 rounded-xl font-black text-white shadow-lg transition-all duration-300 hover:scale-110 hover:shadow-xl" 
                                 style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $accentColor }} 100%);">
                                <span class="text-2xl">{{ strtoupper(substr($websiteName, 0, 1)) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                <h5 class="mt-2 text-xl font-semibold text-slate-900 dark:text-slate-100">{{ $websiteName }}</h5>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Admin Login</p>
                <p class="text-xs text-slate-400 dark:text-slate-500">Administrator access only</p>
            </div>

            <!-- Display General Errors -->
            @if (session('error'))
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-6 flex flex-col gap-5">
                <!-- Email -->
                <div>
                    <label class="label mb-1">Email</label>
                    <input type="email" class="input @error('email') border-red-500 @enderror" name="email"
                        placeholder="Enter Your Email" value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password-->
                <div>
                    <label class="label mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" class="input @error('password') border-red-500 @enderror pr-10" name="password"
                            placeholder="Password" required />
                        <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- Remember & Forgot-->
            <div class="mt-2 flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <input type="checkbox"
                        class="h-4 w-4 rounded border-slate-300 bg-transparent text-primary-500 shadow-sm transition-all duration-150 checked:hover:shadow-none focus:ring-0 focus:ring-offset-0 enabled:hover:shadow disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-600"
                        id="remember-me" name="remember" />
                    <label for="remember-me" class="label">Remember Me</label>
                </div>
            </div>
            <!-- Login Button -->
            <div class="mt-8">
                <button type="submit" class="btn btn-primary w-full py-2.5">Login</button>
            </div>
            <!-- Back to Home -->
            <div class="mt-4 flex justify-center">
                <a href="{{ route('home') }}" class="text-sm text-slate-600 dark:text-slate-300 hover:text-primary-500">
                    ← Back to Home
                </a>
            </div>
        </form>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });
    </script>
</x-auth-layout>

