<x-auth-layout>
  @php
      $logoUrl = \App\Helpers\SiteSettingsHelper::logoUrl();
      $websiteName = \App\Helpers\SiteSettingsHelper::websiteName();
      $primaryColor = \App\Helpers\SiteSettingsHelper::primaryColor();
      $accentColor = \App\Helpers\SiteSettingsHelper::accentColor();
  @endphp
  <div class="card mx-auto w-full max-w-md">
    <div class="card-body px-10 py-12">
      <form method="POST" action="{{ route('reset-password.store') }}">
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
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Reset Your Password</p>
        </div>

        <div class="mt-6 flex flex-col gap-5">
          <!-- Hidden fields for token and email -->
          <input type="hidden" name="token" value="{{ $token ?? '' }}" />
          <input type="hidden" name="email" value="{{ $email ?? '' }}" />

          <!-- New Password -->
          <div>
            <label class="label mb-1">New Password</label>
            <input type="password" name="password" class="input" placeholder="New Password" required />
          </div>
          <!--Confirm Password -->
          <div>
            <label class="label mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="input" placeholder="Confirm Password" required />
          </div>
          <!-- Reset Password -->
          <div class="mt-2">
            <button type="submit" class="btn btn-primary w-full py-2.5">Reset Password</button>
          </div>
          <!-- Go back & login -->
          <div class="flex justify-center">
            <p class="text-sm text-slate-600 dark:text-slate-300">
              Go back to
              <a href="{{ route('login') }}" class="text-sm text-primary-500 hover:underline">Login</a>
            </p>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-auth-layout>