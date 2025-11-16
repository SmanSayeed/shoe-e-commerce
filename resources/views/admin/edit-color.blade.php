<x-admin-layout title="Edit Color">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Edit Color</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Products</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('admin.colors.index') }}">Colors</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Edit Color</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Edit Color Starts -->
  <div class="space-y-6">
    <div class="card">
      <div class="card-body">
        <form class="space-y-6" action="{{ route('admin.colors.update', $color) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Color Information -->
          <div class="space-y-4">
            <h6 class="text-base font-medium text-slate-700 dark:text-slate-300">Color Information</h6>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <!-- Color Name -->
              <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Color Name <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name" class="input @error('name') is-invalid @enderror"
                  placeholder="e.g., Red, Blue, Green" value="{{ old('name', $color->name) }}" required />
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Color Code -->
              <div class="space-y-2">
                <label for="code" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                  Color Code <span class="text-danger">*</span>
                </label>
                <input type="text" id="code" name="code" class="input @error('code') is-invalid @enderror"
                  placeholder="e.g., RED, BLUE" value="{{ old('code', $color->code) }}" required />
                @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Unique identifier for this color (used internally)
                </p>
              </div>
            </div>

            <!-- Hex Code -->
            <div class="space-y-2">
              <label for="hex_code" class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Hex Code
              </label>
              <div class="flex gap-2 items-start">
                <!-- Hex Code Input (200px wide) -->
                <div class="relative">
                <input type="text" id="hex_code" name="hex_code" class="input @error('hex_code') is-invalid @enderror"
                    placeholder="#FF0000" value="{{ old('hex_code', $color->hex_code) }}" style="width: 200px;" />
                  <!-- Common Colors Autocomplete Dropdown -->
                  <div id="color-autocomplete" class="hidden absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                    <div id="color-autocomplete-list" class="p-2"></div>
                  </div>
                </div>
                <!-- Color Picker Button -->
                <input type="color" id="color_picker" class="w-12 h-10 rounded border border-slate-300 cursor-pointer" 
                  value="{{ old('hex_code', $color->hex_code ?? '#FF0000') }}" title="Click to pick a color" />
                <!-- Common Colors Autosearch Dropdown -->
                <div class="relative">
                  <select id="color-select" class="input" style="width: 200px;">
                    <option value="">Select Common Color</option>
                  </select>
                </div>
              </div>
              @error('hex_code')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Hex color code (e.g., #FF0000 for red). Use the color picker or select from common colors. Leave empty if not applicable.
              </p>
            </div>

            <!-- Status -->
            <div class="space-y-2">
              <label class="text-sm font-medium text-slate-600 dark:text-slate-400">
                Status
              </label>
              <div class="flex items-center gap-6">
                <label class="flex items-center">
                  <input type="checkbox" name="is_active" value="1" {{ old('is_active', $color->is_active) ? 'checked' : '' }}>
                  <span class="ml-2 text-sm">Active</span>
                </label>
              </div>
              <p class="text-xs text-slate-500 dark:text-slate-400">
                Active colors can be used when creating product variants
              </p>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col justify-end gap-3 sm:flex-row">
            <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">
              <i data-feather="x" class="h-4 w-4"></i>
              <span>Cancel</span>
            </a>
            <button type="submit" class="btn btn-primary">
              <i data-feather="save" class="h-4 w-4"></i>
              <span>Update Color</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Color Ends -->

  @push('scripts')
    <script>
      // Common colors list
      const commonColors = [
        { name: 'Red', hex: '#FF0000' },
        { name: 'Green', hex: '#008000' },
        { name: 'Blue', hex: '#0000FF' },
        { name: 'Yellow', hex: '#FFFF00' },
        { name: 'Orange', hex: '#FFA500' },
        { name: 'Purple', hex: '#800080' },
        { name: 'Pink', hex: '#FFC0CB' },
        { name: 'Brown', hex: '#A52A2A' },
        { name: 'Black', hex: '#000000' },
        { name: 'White', hex: '#FFFFFF' },
        { name: 'Gray', hex: '#808080' },
        { name: 'Cyan', hex: '#00FFFF' },
        { name: 'Magenta', hex: '#FF00FF' },
        { name: 'Lime', hex: '#00FF00' },
        { name: 'Navy', hex: '#000080' },
        { name: 'Maroon', hex: '#800000' },
        { name: 'Olive', hex: '#808000' },
        { name: 'Teal', hex: '#008080' },
        { name: 'Silver', hex: '#C0C0C0' },
        { name: 'Gold', hex: '#FFD700' },
        { name: 'Coral', hex: '#FF7F50' },
        { name: 'Salmon', hex: '#FA8072' },
        { name: 'Turquoise', hex: '#40E0D0' },
        { name: 'Violet', hex: '#EE82EE' },
        { name: 'Indigo', hex: '#4B0082' },
        { name: 'Beige', hex: '#F5F5DC' },
        { name: 'Khaki', hex: '#F0E68C' },
        { name: 'Lavender', hex: '#E6E6FA' },
        { name: 'Mint', hex: '#98FF98' },
        { name: 'Peach', hex: '#FFE5B4' }
      ];

      document.addEventListener('DOMContentLoaded', function() {
        const hexInput = document.getElementById('hex_code');
        const colorPicker = document.getElementById('color_picker');
        const colorSelect = document.getElementById('color-select');
        const autocomplete = document.getElementById('color-autocomplete');
        const autocompleteList = document.getElementById('color-autocomplete-list');

        console.log('Common colors array:', commonColors);
        console.log('Color select element:', colorSelect);

        // Populate common colors dropdown
        if (colorSelect && commonColors && commonColors.length > 0) {
          commonColors.forEach(color => {
            const option = document.createElement('option');
            option.value = color.hex;
            option.textContent = `${color.name} (${color.hex})`;
            colorSelect.appendChild(option);
          });
          
          console.log(`Populated ${commonColors.length} colors in dropdown`);
          
          // Set initial value if hex input has a value
          if (hexInput && hexInput.value && /^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
            colorSelect.value = hexInput.value.toUpperCase();
          }
        } else {
          console.error('Failed to populate colors dropdown:', {
            colorSelect: !!colorSelect,
            commonColors: !!commonColors,
            colorsLength: commonColors ? commonColors.length : 0
          });
        }

        // Update color picker when hex code changes
        function updateColorPicker(hexCode) {
          if (/^#[0-9A-Fa-f]{6}$/.test(hexCode)) {
            colorPicker.value = hexCode;
            // Update dropdown selection
            colorSelect.value = hexCode;
          } else if (hexCode === '') {
            colorPicker.value = '#FF0000';
            colorSelect.value = '';
          }
        }

        // Update hex input when color picker changes
        colorPicker.addEventListener('input', function() {
          hexInput.value = this.value.toUpperCase();
          updateColorPicker(this.value);
          autocomplete.classList.add('hidden');
        });

        // Update hex input when common color dropdown changes
        colorSelect.addEventListener('change', function() {
          if (this.value) {
            hexInput.value = this.value.toUpperCase();
            updateColorPicker(this.value);
          }
        });

        // Update color picker when hex code input changes
        hexInput.addEventListener('input', function() {
          updateColorPicker(this.value);
          
          // Show/hide autocomplete based on input
          const searchTerm = this.value.toLowerCase().trim();
          if (searchTerm.length > 0 && !/^#[0-9a-f]{6}$/i.test(searchTerm)) {
            filterAndShowColors(searchTerm);
          } else {
            autocomplete.classList.add('hidden');
          }
        });

        // Show all colors when input is focused and empty
        hexInput.addEventListener('focus', function() {
          if (!this.value || this.value.trim() === '') {
            filterAndShowColors('');
          }
        });

        // Filter and display colors based on search term
        function filterAndShowColors(searchTerm) {
          const filtered = commonColors.filter(color => 
            color.name.toLowerCase().includes(searchTerm) || 
            color.hex.toLowerCase().includes(searchTerm)
          );

          if (filtered.length > 0) {
            autocompleteList.innerHTML = filtered.map(color => `
              <div class="color-option flex items-center gap-3 p-2 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer rounded" 
                   data-hex="${color.hex}" data-name="${color.name}">
                <div class="w-6 h-6 rounded border border-slate-300" style="background-color: ${color.hex}"></div>
                <span class="text-sm text-slate-700 dark:text-slate-300">${color.name}</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 ml-auto">${color.hex}</span>
              </div>
            `).join('');
            
            autocomplete.classList.remove('hidden');
            
            // Add click handlers to color options
            autocompleteList.querySelectorAll('.color-option').forEach(option => {
              option.addEventListener('click', function() {
                const hex = this.getAttribute('data-hex');
                hexInput.value = hex;
                updateColorPicker(hex);
                autocomplete.classList.add('hidden');
              });
            });
          } else {
            autocomplete.classList.add('hidden');
          }
        }

        // Hide autocomplete when clicking outside
        document.addEventListener('click', function(e) {
          const isClickInside = hexInput.contains(e.target) || 
                                autocomplete.contains(e.target) || 
                                colorPicker.contains(e.target) ||
                                colorSelect.contains(e.target);
          if (!isClickInside) {
            autocomplete.classList.add('hidden');
          }
        });

        // Initialize color picker
        if (hexInput.value && /^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
          updateColorPicker(hexInput.value);
        } else {
          updateColorPicker('#FF0000');
        }
      });
    </script>
  @endpush
</x-admin-layout>