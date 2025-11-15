<x-auth-layout>
  @php
      $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
      $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
      $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
      $accentColor = \App\Helpers\SiteSettingsHelper::accentColor();
  @endphp
  <div class="card mx-auto w-full max-w-md">
    <div class="card-body px-10 py-12">
      <form method="POST" action="{{ route('register.store') }}">
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
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Create Account</p>
          <p class="text-xs text-slate-400 dark:text-slate-500">Join us today</p>
        </div>

        <div class="mt-6 flex flex-col gap-5">
          <!-- Fullname -->
          <div>
            <label class="label mb-1">Full Name</label>
            <input type="text" name="name" class="input" placeholder="Enter Your Full Name" required />
          </div>
          <!-- Email -->
          <div>
            <label class="label mb-1">Email</label>
            <input type="email" name="email" class="input" placeholder="Enter Your Email" required />
          </div>
          <!-- Password -->
          <div>
            <label class="label mb-1">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" class="input pr-10" placeholder="Password" required />
              <button type="button" id="togglePassword"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
              </button>
            </div>
          </div>
          <!-- Confirm Password-->
          <div class="relative">
            <label class="label mb-1">Confirm Password</label>
            <div class="relative">
              <input type="password" id="password_confirmation" name="password_confirmation" class="input pr-10"
                placeholder="Confirm Password" required />
              <button type="button" id="togglePasswordConfirm"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg id="eyeIconConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg id="eyeSlashIconConfirm" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                </svg>
              </button>
            </div>
          </div>
        </div>
        <!-- Remember & Forgot-->
        <div class="mt-2 flex">
          <div class="flex items-center gap-1.5">
            <input type="checkbox" name="terms"
              class="h-4 w-4 rounded border-slate-300 bg-transparent text-primary-500 shadow-sm transition-all duration-150 checked:hover:shadow-none focus:ring-0 focus:ring-offset-0 enabled:hover:shadow disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-600"
              id="terms" required />
            <label for="terms" class="label text-slate-400">I accept</label>
          </div>
          <a href="#" class="ml-2 text-sm text-primary-500 hover:underline">Terms & Condition</a>
        </div>
        <!-- Register Button -->
        <div class="mt-8">
          <button type="submit" class="btn btn-primary w-full py-2.5">Register</button>
        </div>
        <!-- Don't Have An Account -->
        <div class="mt-4 flex justify-center">
          <p class="text-sm text-slate-600 dark:text-slate-300">
            Already have an Account?
            <a href="{{ route('login') }}" class="text-sm text-primary-500 hover:underline">Login</a>
          </p>
        </div>
    </div>
  </div>
  </form>
  <script>
    // Password toggle functionality for main password
    document.getElementById('togglePassword').addEventListener('click', function () {
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

    // Password toggle functionality for confirm password
    document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
      const passwordInput = document.getElementById('password_confirmation');
      const eyeIcon = document.getElementById('eyeIconConfirm');
      const eyeSlashIcon = document.getElementById('eyeSlashIconConfirm');

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