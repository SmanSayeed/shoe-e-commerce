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

        <!-- Error Messages -->
        @if($errors->any())
          <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start gap-2">
              <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <div class="flex-1">
                <h6 class="text-sm font-medium text-red-800 mb-1">Please fix the following errors:</h6>
                <ul class="text-sm text-red-700 space-y-1">
                  @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        @endif

        <!-- Success Message -->
        @if(session('success'))
          <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
          </div>
        @endif

        <div class="mt-6 flex flex-col gap-5">
          <!-- Fullname -->
          <div>
            <label class="label mb-1">Full Name <span class="text-red-500">*</span></label>
            <input 
              type="text" 
              name="name" 
              id="name"
              value="{{ old('name') }}"
              class="input @error('name') border-red-500 @enderror" 
              placeholder="Enter Your Full Name" 
              required 
              minlength="2"
              maxlength="255"
              pattern="[a-zA-Z\s]+"
              title="Name can only contain letters and spaces"
            />
            @error('name')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-slate-500">Minimum 2 characters, letters and spaces only</p>
          </div>
          <!-- Email -->
          <div>
            <label class="label mb-1">Email <span class="text-red-500">*</span></label>
            <input 
              type="email" 
              name="email" 
              id="email"
              value="{{ old('email') }}"
              class="input @error('email') border-red-500 @enderror" 
              placeholder="Enter Your Email" 
              required 
              maxlength="255"
            />
            @error('email')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <!-- Password -->
          <div>
            <label class="label mb-1">Password <span class="text-red-500">*</span></label>
            <div class="relative">
              <input 
                type="password" 
                id="password" 
                name="password" 
                class="input pr-10 @error('password') border-red-500 @enderror" 
                placeholder="Password" 
                required 
                minlength="8"
                maxlength="255"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$"
                title="Password must contain at least one uppercase letter, one lowercase letter, and one number"
              />
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
            @error('password')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-slate-500">Minimum 8 characters with uppercase, lowercase, and number</p>
          </div>
          <!-- Confirm Password-->
          <div class="relative">
            <label class="label mb-1">Confirm Password <span class="text-red-500">*</span></label>
            <div class="relative">
              <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="input pr-10 @error('password_confirmation') border-red-500 @enderror"
                placeholder="Confirm Password" 
                required 
                minlength="8"
                maxlength="255"
              />
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
            @error('password_confirmation')
              <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <!-- Remember & Forgot-->
        <div class="mt-2 flex">
          <div class="flex items-center gap-1.5">
            <input type="checkbox" name="terms"
              class="h-4 w-4 rounded border-slate-300 bg-transparent text-primary-500 shadow-sm transition-all duration-150 checked:hover:shadow-none focus:ring-0 focus:ring-offset-0 enabled:hover:shadow disabled:cursor-not-allowed disabled:opacity-50 dark:border-slate-600 @error('terms') border-red-500 @enderror"
              id="terms" 
              value="1"
              {{ old('terms') ? 'checked' : '' }}
              required />
            <label for="terms" class="label text-slate-400">I accept</label>
          </div>
          <a href="#" class="ml-2 text-sm text-primary-500 hover:underline">Terms & Condition</a>
        </div>
        @error('terms')
          <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        <!-- Register Button -->
        <div class="mt-8">
          <button type="submit" id="submitBtn" class="btn btn-primary w-full py-2.5">
            <span id="submitText">Register</span>
            <span id="submitSpinner" class="hidden">
              <svg class="animate-spin h-4 w-4 inline-block ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
            </span>
          </button>
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
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form[action="{{ route('register.store') }}"]');
      const submitBtn = document.getElementById('submitBtn');
      const submitText = document.getElementById('submitText');
      const submitSpinner = document.getElementById('submitSpinner');
      
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

      // Real-time password match validation
      const passwordInput = document.getElementById('password');
      const passwordConfirmInput = document.getElementById('password_confirmation');
      
      function validatePasswordMatch() {
        if (passwordConfirmInput.value && passwordInput.value !== passwordConfirmInput.value) {
          passwordConfirmInput.setCustomValidity('Passwords do not match');
          passwordConfirmInput.classList.add('border-red-500');
        } else {
          passwordConfirmInput.setCustomValidity('');
          passwordConfirmInput.classList.remove('border-red-500');
        }
      }
      
      passwordInput.addEventListener('input', validatePasswordMatch);
      passwordConfirmInput.addEventListener('input', validatePasswordMatch);

      // Form submission with loading state
      form.addEventListener('submit', function(e) {
        // Client-side validation
        if (!form.checkValidity()) {
          e.preventDefault();
          e.stopPropagation();
          form.classList.add('was-validated');
          return false;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Registering...';
        submitSpinner.classList.remove('hidden');
      });

      // Real-time name validation (letters and spaces only)
      const nameInput = document.getElementById('name');
      nameInput.addEventListener('input', function() {
        const value = this.value;
        const regex = /^[a-zA-Z\s]*$/;
        if (!regex.test(value)) {
          this.setCustomValidity('Name can only contain letters and spaces');
          this.classList.add('border-red-500');
        } else {
          this.setCustomValidity('');
          this.classList.remove('border-red-500');
        }
      });

      // Real-time email validation
      const emailInput = document.getElementById('email');
      emailInput.addEventListener('blur', function() {
        const email = this.value.trim();
        if (email && !this.validity.valid) {
          this.setCustomValidity('Please enter a valid email address');
          this.classList.add('border-red-500');
        } else {
          this.setCustomValidity('');
          this.classList.remove('border-red-500');
        }
      });

      // Password strength indicator (optional enhancement)
      passwordInput.addEventListener('input', function() {
        const password = this.value;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasMinLength = password.length >= 8;
        
        if (password.length > 0) {
          if (!hasUpper || !hasLower || !hasNumber || !hasMinLength) {
            this.setCustomValidity('Password must contain at least one uppercase letter, one lowercase letter, and one number');
            this.classList.add('border-red-500');
          } else {
            this.setCustomValidity('');
            this.classList.remove('border-red-500');
          }
        }
      });
    });
  </script>
</x-auth-layout>