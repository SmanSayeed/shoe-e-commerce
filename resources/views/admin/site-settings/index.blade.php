<x-admin-layout title="Site Settings">
    <!-- Enhanced Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-2">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2 flex items-center gap-3">
                    <span
                        class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-primary-600 to-primary-700 dark:from-primary-600 dark:to-primary-700 shadow-lg shadow-primary-500/25">
                        <i data-feather="settings" class="w-6 h-6 text-white"></i>
                    </span>
                    Site Settings
                </h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">Manage your website configuration, branding, and
                    preferences</p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    Auto-save enabled
                </span>
            </div>
        </div>
        <ol class="breadcrumb text-sm">
            <li class="breadcrumb-item">
                <a href="/"
                    class="text-slate-500 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400 transition-colors">Home</a>
            </li>
            <li class="breadcrumb-item">
                <span class="text-slate-900 dark:text-slate-100">Settings</span>
            </li>
        </ol>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div
            class="mb-6 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-800 shadow-sm animate-slide-down">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center">
                        <i data-feather="check" class="w-5 h-5 text-white"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-emerald-900 dark:text-emerald-100">Success!</h3>
                    <p class="text-sm text-emerald-700 dark:text-emerald-300 mt-0.5">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="flex-shrink-0 text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div
            class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border border-red-200 dark:border-red-800 shadow-sm animate-slide-down">
            <div class="flex items-center gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center">
                        <i data-feather="alert-circle" class="w-5 h-5 text-white"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-900 dark:text-red-100">Error</h3>
                    <p class="text-sm text-red-700 dark:text-red-300 mt-0.5">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()"
                    class="flex-shrink-0 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Site Settings Form Starts -->
    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data"
        id="site-settings-form" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Enhanced Tabs Navigation -->
        <div
            class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border-2 border-slate-200 dark:border-slate-700 overflow-hidden mb-6">
            <nav class="flex flex-wrap gap-3 p-4" role="tablist" aria-label="Settings sections">
                <button type="button" class="tab-button active group" data-tab="general" role="tab"
                    aria-selected="true" aria-controls="tab-general">
                    <span class="tab-button-content">
                        <i data-feather="settings" class="w-4 h-4"></i>
                        <span>General</span>
                    </span>
                </button>
                <button type="button" class="tab-button group" data-tab="branding" role="tab" aria-selected="false"
                    aria-controls="tab-branding">
                    <span class="tab-button-content">
                        <i data-feather="image" class="w-4 h-4"></i>
                        <span>Branding</span>
                    </span>
                </button>
                <button type="button" class="tab-button group" data-tab="contact" role="tab" aria-selected="false"
                    aria-controls="tab-contact">
                    <span class="tab-button-content">
                        <i data-feather="phone" class="w-4 h-4"></i>
                        <span>Contact</span>
                    </span>
                </button>
                <button type="button" class="tab-button group" data-tab="social" role="tab" aria-selected="false"
                    aria-controls="tab-social">
                    <span class="tab-button-content">
                        <i data-feather="share-2" class="w-4 h-4"></i>
                        <span>Social</span>
                    </span>
                </button>
                <button type="button" class="tab-button group" data-tab="localization" role="tab"
                    aria-selected="false" aria-controls="tab-localization">
                    <span class="tab-button-content">
                        <i data-feather="globe" class="w-4 h-4"></i>
                        <span>Localization</span>
                    </span>
                </button>
                <button type="button" class="tab-button group" data-tab="seo" role="tab" aria-selected="false"
                    aria-controls="tab-seo">
                    <span class="tab-button-content">
                        <i data-feather="search" class="w-4 h-4"></i>
                        <span>SEO</span>
                    </span>
                </button>
                <button type="button" class="tab-button group" data-tab="maintenance" role="tab"
                    aria-selected="false" aria-controls="tab-maintenance">
                    <span class="tab-button-content">
                        <i data-feather="tool" class="w-4 h-4"></i>
                        <span>Maintenance</span>
                    </span>
                </button>
                <button type="button" class="tab-button group" data-tab="advanced" role="tab"
                    aria-selected="false" aria-controls="tab-advanced">
                    <span class="tab-button-content">
                        <i data-feather="code" class="w-4 h-4"></i>
                        <span>Advanced</span>
                    </span>
                </button>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div class="space-y-6">
            <!-- General Tab -->
            <div class="tab-content active animate-fade-in" id="tab-general">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                <i data-feather="info" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Website
                                    Information</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure
                                    basic website information and branding</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-6">
                        <div class="form-group">
                            <label for="website_name" class="form-label required flex items-center gap-2">
                                <i data-feather="globe" class="w-4 h-4 text-slate-500"></i>
                                <span>Website Name</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="website_name" name="website_name"
                                    value="{{ old('website_name', $settings->website_name) }}"
                                    class="input @error('website_name') border-red-500 @enderror"
                                    placeholder="Enter your website name" required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i data-feather="check-circle"
                                        class="w-5 h-5 text-emerald-500 hidden input-valid-icon"></i>
                                </div>
                            </div>
                            @error('website_name')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            <div class="form-text mt-1.5 flex items-start gap-1.5">
                                <i data-feather="help-circle" class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0"></i>
                                <span>This name will appear in browser tabs and search results</span>
                            </div>
                        </div>

                        <!-- Tagline Section -->
                        <div class="form-group">
                            <label for="website_tagline" class="form-label flex items-center gap-2">
                                <i data-feather="tag" class="w-4 h-4 text-slate-500"></i>
                                <span>Tagline</span>
                            </label>
                            <input type="text" id="website_tagline" name="website_tagline"
                                value="{{ old('website_tagline', $settings->website_tagline) }}"
                                class="input @error('website_tagline') border-red-500 @enderror"
                                placeholder="Your website tagline">
                            @error('website_tagline')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Description Section -->
                        <div class="form-group">
                            <label for="website_description" class="form-label flex items-center gap-2">
                                <i data-feather="file-text" class="w-4 h-4 text-slate-500"></i>
                                <span>Description</span>
                            </label>
                            <textarea id="website_description" name="website_description" rows="4"
                                class="textarea @error('website_description') border-red-500 @enderror"
                                placeholder="Brief description of your website">{{ old('website_description', $settings->website_description) }}</textarea>
                            <div class="flex items-center justify-between mt-1.5">
                                <div class="form-text flex items-start gap-1.5">
                                    <i data-feather="help-circle"
                                        class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0"></i>
                                    <span>Used in meta descriptions and search results</span>
                                </div>
                                <span class="text-xs text-slate-400" id="description-count">0 characters</span>
                            </div>
                            @error('website_description')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Footer Text Section -->
                        <div class="form-group">
                            <label for="footer_text" class="form-label flex items-center gap-2">
                                <i data-feather="align-left" class="w-4 h-4 text-slate-500"></i>
                                <span>Footer Text</span>
                            </label>
                            <textarea id="footer_text" name="footer_text" rows="3"
                                class="textarea @error('footer_text') border-red-500 @enderror" placeholder="Text to display in footer">{{ old('footer_text', $settings->footer_text) }}</textarea>
                            @error('footer_text')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Copyright Notice Section -->
                        <div class="form-group">
                            <label for="copyright_notice" class="form-label flex items-center gap-2">
                                <i data-feather="copyright" class="w-4 h-4 text-slate-500"></i>
                                <span>Copyright Notice</span>
                            </label>
                            <input type="text" id="copyright_notice" name="copyright_notice"
                                value="{{ old('copyright_notice', $settings->copyright_notice) }}"
                                class="input @error('copyright_notice') border-red-500 @enderror"
                                placeholder="© {{ date('Y') }} Your Company. All rights reserved.">
                            @error('copyright_notice')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branding Tab -->
            <div class="tab-content hidden animate-fade-in" id="tab-branding">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                <i data-feather="image" class="w-5 h-5 text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Logo &
                                    Favicon</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Upload your
                                    website logo and favicon</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-8">
                        <!-- Logo Upload -->
                        <div class="form-group">
                            <label class="form-label flex items-center gap-2 mb-3">
                                <i data-feather="image" class="w-4 h-4 text-slate-500"></i>
                                <span class="font-medium">Logo</span>
                            </label>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @if ($settings->logo_path)
                                    <div class="flex-shrink-0">
                                        <div class="relative group">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                <button type="button" class="btn btn-sm btn-danger shadow-lg"
                                                    onclick="deleteLogo()">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                                    Delete
                                                </button>
                                            </div>
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->logo_path) }}"
                                                alt="Logo"
                                                class="w-full h-48 object-contain border-2 border-slate-200 dark:border-slate-700 rounded-xl p-4 bg-slate-50 dark:bg-slate-800/50 shadow-sm">
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 text-center">Current
                                            Logo</p>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="file-upload-area" id="logo-upload-area">
                                        <input type="file" id="logo" name="logo"
                                            accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/webp"
                                            class="file-input hidden @error('logo') border-red-500 @enderror"
                                            onchange="previewImage(this, 'logo-preview', 'logo-upload-area')">
                                        <div class="file-upload-content">
                                            <div class="file-upload-icon">
                                                <i data-feather="upload-cloud" class="w-12 h-12 text-slate-400"></i>
                                            </div>
                                            <p class="file-upload-text">
                                                <span class="font-medium text-primary-600 dark:text-primary-400">Click
                                                    to upload</span>
                                                or drag and drop
                                            </p>
                                            <p class="file-upload-hint">PNG, JPG, SVG, or WEBP (Max 2MB)</p>
                                            <p class="file-upload-recommendation">Recommended: 300x300px</p>
                                        </div>
                                    </div>
                                    @error('logo')
                                        <div class="invalid-feedback flex items-center gap-1 mt-2">
                                            <i data-feather="alert-circle" class="w-4 h-4"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                    <div id="logo-preview" class="mt-4 hidden">
                                        <div class="relative">
                                            <img src="" alt="Logo Preview"
                                                class="w-full h-48 object-contain border-2 border-primary-200 dark:border-primary-800 rounded-xl p-4 bg-primary-50 dark:bg-primary-900/20 shadow-sm">
                                            <span
                                                class="absolute top-2 right-2 px-2 py-1 bg-primary-500 text-white text-xs font-medium rounded-lg">Preview</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Favicon Upload -->
                        <div class="form-group">
                            <label class="form-label flex items-center gap-2 mb-3">
                                <i data-feather="star" class="w-4 h-4 text-slate-500"></i>
                                <span class="font-medium">Favicon</span>
                            </label>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                @if ($settings->favicon_path)
                                    <div class="flex-shrink-0">
                                        <div class="relative group">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                <button type="button" class="btn btn-sm btn-danger shadow-lg"
                                                    onclick="deleteFavicon()">
                                                    <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                                    Delete
                                                </button>
                                            </div>
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->favicon_path) }}"
                                                alt="Favicon"
                                                class="w-32 h-32 object-contain border-2 border-slate-200 dark:border-slate-700 rounded-xl p-4 bg-slate-50 dark:bg-slate-800/50 shadow-sm">
                                        </div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 text-center">Current
                                            Favicon</p>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="file-upload-area" id="favicon-upload-area">
                                        <input type="file" id="favicon" name="favicon"
                                            accept="image/png,image/jpeg,image/jpg,image/svg+xml,image/x-icon"
                                            class="file-input hidden @error('favicon') border-red-500 @enderror"
                                            onchange="previewImage(this, 'favicon-preview', 'favicon-upload-area')">
                                        <div class="file-upload-content">
                                            <div class="file-upload-icon">
                                                <i data-feather="upload-cloud" class="w-12 h-12 text-slate-400"></i>
                                            </div>
                                            <p class="file-upload-text">
                                                <span class="font-medium text-primary-600 dark:text-primary-400">Click
                                                    to upload</span>
                                                or drag and drop
                                            </p>
                                            <p class="file-upload-hint">PNG, JPG, SVG, or ICO (Max 1MB)</p>
                                            <p class="file-upload-recommendation">Recommended: 32x32px</p>
                                        </div>
                                    </div>
                                    @error('favicon')
                                        <div class="invalid-feedback flex items-center gap-1 mt-2">
                                            <i data-feather="alert-circle" class="w-4 h-4"></i>
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                    <div id="favicon-preview" class="mt-4 hidden">
                                        <div class="relative">
                                            <img src="" alt="Favicon Preview"
                                                class="w-32 h-32 object-contain border-2 border-primary-200 dark:border-primary-800 rounded-xl p-4 bg-primary-50 dark:bg-primary-900/20 shadow-sm mx-auto">
                                            <span
                                                class="absolute top-2 right-2 px-2 py-1 bg-primary-500 text-white text-xs font-medium rounded-lg">Preview</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Theme Colors -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                                <i data-feather="palette" class="w-5 h-5 text-pink-600 dark:text-pink-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Theme
                                    Colors</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Customize
                                    your website color scheme</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="form-group">
                                <label for="primary_color" class="form-label required flex items-center gap-2 mb-3">
                                    <i data-feather="circle" class="w-4 h-4 text-slate-500"></i>
                                    <span>Primary Color</span>
                                </label>
                                <div class="space-y-2">
                                    <div class="flex gap-3 items-center">
                                        <div class="relative">
                                            <input type="color" id="primary_color" name="primary_color"
                                                value="{{ old('primary_color', $settings->primary_color) }}"
                                                class="h-14 w-20 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer @error('primary_color') border-red-500 @enderror"
                                                required style="padding: 2px;">
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white dark:border-slate-800"
                                                style="background-color: {{ old('primary_color', $settings->primary_color) }}">
                                            </div>
                                        </div>
                                        <input type="text" id="primary_color_text"
                                            value="{{ old('primary_color', $settings->primary_color) }}"
                                            class="input flex-1 font-mono text-sm @error('primary_color') border-red-500 @enderror"
                                            placeholder="#F59E0B" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                                    </div>
                                    <div class="h-8 rounded-lg border border-slate-200 dark:border-slate-700"
                                        style="background-color: {{ old('primary_color', $settings->primary_color) }}"
                                        id="primary_color_preview"></div>
                                </div>
                                @error('primary_color')
                                    <div class="invalid-feedback flex items-center gap-1 mt-1">
                                        <i data-feather="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="secondary_color" class="form-label required flex items-center gap-2 mb-3">
                                    <i data-feather="circle" class="w-4 h-4 text-slate-500"></i>
                                    <span>Secondary Color</span>
                                </label>
                                <div class="space-y-2">
                                    <div class="flex gap-3 items-center">
                                        <div class="relative">
                                            <input type="color" id="secondary_color" name="secondary_color"
                                                value="{{ old('secondary_color', $settings->secondary_color) }}"
                                                class="h-14 w-20 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer @error('secondary_color') border-red-500 @enderror"
                                                required style="padding: 2px;">
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white dark:border-slate-800"
                                                style="background-color: {{ old('secondary_color', $settings->secondary_color) }}">
                                            </div>
                                        </div>
                                        <input type="text" id="secondary_color_text"
                                            value="{{ old('secondary_color', $settings->secondary_color) }}"
                                            class="input flex-1 font-mono text-sm @error('secondary_color') border-red-500 @enderror"
                                            placeholder="#1E293B" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                                    </div>
                                    <div class="h-8 rounded-lg border border-slate-200 dark:border-slate-700"
                                        style="background-color: {{ old('secondary_color', $settings->secondary_color) }}"
                                        id="secondary_color_preview"></div>
                                </div>
                                @error('secondary_color')
                                    <div class="invalid-feedback flex items-center gap-1 mt-1">
                                        <i data-feather="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="accent_color" class="form-label required flex items-center gap-2 mb-3">
                                    <i data-feather="circle" class="w-4 h-4 text-slate-500"></i>
                                    <span>Accent Color</span>
                                </label>
                                <div class="space-y-2">
                                    <div class="flex gap-3 items-center">
                                        <div class="relative">
                                            <input type="color" id="accent_color" name="accent_color"
                                                value="{{ old('accent_color', $settings->accent_color) }}"
                                                class="h-14 w-20 rounded-lg border-2 border-slate-200 dark:border-slate-700 cursor-pointer @error('accent_color') border-red-500 @enderror"
                                                required style="padding: 2px;">
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white dark:border-slate-800"
                                                style="background-color: {{ old('accent_color', $settings->accent_color) }}">
                                            </div>
                                        </div>
                                        <input type="text" id="accent_color_text"
                                            value="{{ old('accent_color', $settings->accent_color) }}"
                                            class="input flex-1 font-mono text-sm @error('accent_color') border-red-500 @enderror"
                                            placeholder="#EF4444" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                                    </div>
                                    <div class="h-8 rounded-lg border border-slate-200 dark:border-slate-700"
                                        style="background-color: {{ old('accent_color', $settings->accent_color) }}"
                                        id="accent_color_preview"></div>
                                </div>
                                @error('accent_color')
                                    <div class="invalid-feedback flex items-center gap-1 mt-1">
                                        <i data-feather="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Tab -->
            <div class="tab-content hidden animate-fade-in" id="tab-contact">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                <i data-feather="phone" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Contact
                                    Information</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Manage your
                                    business contact details</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label for="primary_email" class="form-label flex items-center gap-2">
                                    <i data-feather="mail" class="w-4 h-4 text-slate-500"></i>
                                    <span>Primary Email</span>
                                </label>
                                <input type="email" id="primary_email" name="primary_email"
                                    value="{{ old('primary_email', $settings->primary_email) }}"
                                    class="input @error('primary_email') border-red-500 @enderror"
                                    placeholder="info@example.com">
                                @error('primary_email')
                                    <div class="invalid-feedback flex items-center gap-1 mt-1">
                                        <i data-feather="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="secondary_email" class="form-label flex items-center gap-2">
                                    <i data-feather="mail" class="w-4 h-4 text-slate-500"></i>
                                    <span>Secondary Email</span>
                                </label>
                                <input type="email" id="secondary_email" name="secondary_email"
                                    value="{{ old('secondary_email', $settings->secondary_email) }}"
                                    class="input @error('secondary_email') border-red-500 @enderror"
                                    placeholder="support@example.com">
                                @error('secondary_email')
                                    <div class="invalid-feedback flex items-center gap-1 mt-1">
                                        <i data-feather="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="primary_phone" class="form-label flex items-center gap-2">
                                    <i data-feather="phone" class="w-4 h-4 text-slate-500"></i>
                                    <span>Primary Phone</span>
                                </label>
                                <input type="text" id="primary_phone" name="primary_phone"
                                    value="{{ old('primary_phone', $settings->primary_phone) }}"
                                    class="input @error('primary_phone') border-red-500 @enderror"
                                    placeholder="+880 1234 567890">
                                @error('primary_phone')
                                    <div class="invalid-feedback flex items-center gap-1 mt-1">
                                        <i data-feather="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="secondary_phone" class="form-label flex items-center gap-2">
                                    <i data-feather="phone" class="w-4 h-4 text-slate-500"></i>
                                    <span>Secondary Phone</span>
                                </label>
                                <input type="text" id="secondary_phone" name="secondary_phone"
                                    value="{{ old('secondary_phone', $settings->secondary_phone) }}"
                                    class="input @error('secondary_phone') border-red-500 @enderror"
                                    placeholder="+880 1234 567891">
                                @error('secondary_phone')
                                    <div class="invalid-feedback flex items-center gap-1 mt-1">
                                        <i data-feather="alert-circle" class="w-4 h-4"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="physical_address" class="form-label flex items-center gap-2">
                                <i data-feather="map-pin" class="w-4 h-4 text-slate-500"></i>
                                <span>Physical Address</span>
                            </label>
                            <textarea id="physical_address" name="physical_address" rows="3"
                                class="textarea @error('physical_address') border-red-500 @enderror" placeholder="Your business address">{{ old('physical_address', $settings->physical_address) }}</textarea>
                            @error('physical_address')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="business_hours" class="form-label flex items-center gap-2">
                                <i data-feather="clock" class="w-4 h-4 text-slate-500"></i>
                                <span>Business Hours</span>
                            </label>
                            <textarea id="business_hours" name="business_hours" rows="2"
                                class="textarea @error('business_hours') border-red-500 @enderror" placeholder="Mon-Fri: 9:00 AM - 6:00 PM">{{ old('business_hours', $settings->business_hours) }}</textarea>
                            @error('business_hours')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Tab -->
            <div class="tab-content hidden animate-fade-in" id="tab-social">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                                <i data-feather="share-2" class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Social
                                    Media Links</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Add your
                                    social media profile URLs</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-6">
                        @php
                            $socialLinks = old('social_media_links', $settings->social_media_links ?? []);
                        @endphp
                        <div class="form-group">
                            <label for="social_facebook" class="form-label flex items-center gap-2">
                                <i data-feather="facebook" class="w-4 h-4 text-blue-600"></i>
                                <span>Facebook</span>
                            </label>
                            <input type="url" id="social_facebook" name="social_media_links[facebook]"
                                value="{{ $socialLinks['facebook'] ?? '' }}"
                                class="input @error('social_media_links.facebook') border-red-500 @enderror"
                                placeholder="https://facebook.com/yourpage">
                            @error('social_media_links.facebook')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="social_twitter" class="form-label flex items-center gap-2">
                                <i data-feather="twitter" class="w-4 h-4 text-sky-500"></i>
                                <span>Twitter/X</span>
                            </label>
                            <input type="url" id="social_twitter" name="social_media_links[twitter]"
                                value="{{ $socialLinks['twitter'] ?? '' }}"
                                class="input @error('social_media_links.twitter') border-red-500 @enderror"
                                placeholder="https://twitter.com/yourhandle">
                            @error('social_media_links.twitter')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="social_instagram" class="form-label flex items-center gap-2">
                                <i data-feather="instagram" class="w-4 h-4 text-pink-600"></i>
                                <span>Instagram</span>
                            </label>
                            <input type="url" id="social_instagram" name="social_media_links[instagram]"
                                value="{{ $socialLinks['instagram'] ?? '' }}"
                                class="input @error('social_media_links.instagram') border-red-500 @enderror"
                                placeholder="https://instagram.com/yourprofile">
                            @error('social_media_links.instagram')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="social_linkedin" class="form-label flex items-center gap-2">
                                <i data-feather="linkedin" class="w-4 h-4 text-blue-700"></i>
                                <span>LinkedIn</span>
                            </label>
                            <input type="url" id="social_linkedin" name="social_media_links[linkedin]"
                                value="{{ $socialLinks['linkedin'] ?? '' }}"
                                class="input @error('social_media_links.linkedin') border-red-500 @enderror"
                                placeholder="https://linkedin.com/company/yourcompany">
                            @error('social_media_links.linkedin')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="social_youtube" class="form-label flex items-center gap-2">
                                <i data-feather="youtube" class="w-4 h-4 text-red-600"></i>
                                <span>YouTube</span>
                            </label>
                            <input type="url" id="social_youtube" name="social_media_links[youtube]"
                                value="{{ $socialLinks['youtube'] ?? '' }}"
                                class="input @error('social_media_links.youtube') border-red-500 @enderror"
                                placeholder="https://youtube.com/@yourchannel">
                            @error('social_media_links.youtube')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="social_tiktok" class="form-label flex items-center gap-2">
                                <i data-feather="video" class="w-4 h-4 text-slate-600"></i>
                                <span>TikTok</span>
                            </label>
                            <input type="url" id="social_tiktok" name="social_media_links[tiktok]"
                                value="{{ $socialLinks['tiktok'] ?? '' }}"
                                class="input @error('social_media_links.tiktok') border-red-500 @enderror"
                                placeholder="https://tiktok.com/@yourhandle">
                            @error('social_media_links.tiktok')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Social Banner Section -->
                <div class="card hover:shadow-lg transition-shadow duration-300 mt-6">
                    <div
                        class="card-header bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                <i data-feather="share-2" class="w-5 h-5 text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Social
                                    Banner</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure the
                                    Facebook banner displayed on the homepage</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-6">
                        <!-- Show Social Banner Toggle -->
                        <div class="form-group">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="show_social_banner" name="show_social_banner" value="1"
                                        {{ old('show_social_banner', $settings->show_social_banner ?? false) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div
                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-purple-600">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-slate-900 dark:text-slate-100">Show Social
                                        Banner</span>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Enable or disable the
                                        social media banner on the homepage</p>
                                </div>
                            </label>
                            @error('show_social_banner')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Facebook Page URL -->
                        <div class="form-group">
                            <label for="facebook_url" class="form-label flex items-center gap-2">
                                <i data-feather="facebook" class="w-4 h-4 text-blue-600"></i>
                                <span>Facebook Page URL</span>
                            </label>
                            <input type="url" id="facebook_url" name="facebook_url"
                                value="{{ old('facebook_url', $settings->facebook_url ?? '') }}"
                                class="input @error('facebook_url') border-red-500 @enderror"
                                placeholder="https://facebook.com/yourpage">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Enter your Facebook page URL.
                                This will be used in the social banner CTA button.</p>
                            @error('facebook_url')
                                <div class="invalid-feedback flex items-center gap-1 mt-1">
                                    <i data-feather="alert-circle" class="w-4 h-4"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Preview Note -->
                        <div class="p-4 rounded-lg bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800">
                            <div class="flex items-start gap-3">
                                <i data-feather="info" class="w-5 h-5 text-purple-600 dark:text-purple-400 flex-shrink-0 mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-medium text-purple-900 dark:text-purple-100 mb-1">Banner
                                        Preview</p>
                                    <p class="text-xs text-purple-700 dark:text-purple-300">The banner will appear below
                                        the customer reviews section on the homepage. It features a vibrant gradient
                                        background, Facebook icon, and a call-to-action button.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Localization Tab -->
            <div class="tab-content hidden animate-fade-in" id="tab-localization">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center">
                                <i data-feather="globe" class="w-5 h-5 text-cyan-600 dark:text-cyan-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">
                                    Localization Settings</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure
                                    currency, language, and timezone</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="default_currency" class="form-label required">Default Currency</label>
                                <select id="default_currency" name="default_currency"
                                    class="select @error('default_currency') border-red-500 @enderror" required>
                                    <option value="USD"
                                        {{ old('default_currency', $settings->default_currency) == 'USD' ? 'selected' : '' }}>
                                        USD - US Dollar</option>
                                    <option value="EUR"
                                        {{ old('default_currency', $settings->default_currency) == 'EUR' ? 'selected' : '' }}>
                                        EUR - Euro</option>
                                    <option value="GBP"
                                        {{ old('default_currency', $settings->default_currency) == 'GBP' ? 'selected' : '' }}>
                                        GBP - British Pound</option>
                                    <option value="BDT"
                                        {{ old('default_currency', $settings->default_currency) == 'BDT' ? 'selected' : '' }}>
                                        BDT - Bangladeshi Taka</option>
                                    <option value="INR"
                                        {{ old('default_currency', $settings->default_currency) == 'INR' ? 'selected' : '' }}>
                                        INR - Indian Rupee</option>
                                    <option value="PKR"
                                        {{ old('default_currency', $settings->default_currency) == 'PKR' ? 'selected' : '' }}>
                                        PKR - Pakistani Rupee</option>
                                    <option value="AED"
                                        {{ old('default_currency', $settings->default_currency) == 'AED' ? 'selected' : '' }}>
                                        AED - UAE Dirham</option>
                                    <option value="SAR"
                                        {{ old('default_currency', $settings->default_currency) == 'SAR' ? 'selected' : '' }}>
                                        SAR - Saudi Riyal</option>
                                </select>
                                @error('default_currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="default_language" class="form-label required">Default Language</label>
                                <select id="default_language" name="default_language"
                                    class="select @error('default_language') border-red-500 @enderror" required>
                                    <option value="en"
                                        {{ old('default_language', $settings->default_language) == 'en' ? 'selected' : '' }}>
                                        English</option>
                                    <option value="bn"
                                        {{ old('default_language', $settings->default_language) == 'bn' ? 'selected' : '' }}>
                                        Bengali</option>
                                    <option value="ar"
                                        {{ old('default_language', $settings->default_language) == 'ar' ? 'selected' : '' }}>
                                        Arabic</option>
                                    <option value="hi"
                                        {{ old('default_language', $settings->default_language) == 'hi' ? 'selected' : '' }}>
                                        Hindi</option>
                                    <option value="ur"
                                        {{ old('default_language', $settings->default_language) == 'ur' ? 'selected' : '' }}>
                                        Urdu</option>
                                    <option value="fr"
                                        {{ old('default_language', $settings->default_language) == 'fr' ? 'selected' : '' }}>
                                        French</option>
                                    <option value="de"
                                        {{ old('default_language', $settings->default_language) == 'de' ? 'selected' : '' }}>
                                        German</option>
                                    <option value="es"
                                        {{ old('default_language', $settings->default_language) == 'es' ? 'selected' : '' }}>
                                        Spanish</option>
                                </select>
                                @error('default_language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group md:col-span-2">
                                <label for="supported_languages" class="form-label">Supported Languages</label>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $supportedLanguages = old(
                                            'supported_languages',
                                            $settings->supported_languages ?? [],
                                        );
                                    @endphp
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="en"
                                            {{ in_array('en', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        English
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="bn"
                                            {{ in_array('bn', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        Bengali
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="ar"
                                            {{ in_array('ar', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        Arabic
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="hi"
                                            {{ in_array('hi', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        Hindi
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="ur"
                                            {{ in_array('ur', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        Urdu
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="fr"
                                            {{ in_array('fr', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        French
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="de"
                                            {{ in_array('de', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        German
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="supported_languages[]" value="es"
                                            {{ in_array('es', $supportedLanguages) ? 'checked' : '' }}
                                            class="mr-2 rounded border-slate-300">
                                        Spanish
                                    </label>
                                </div>
                                @error('supported_languages')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group md:col-span-2">
                                <label for="timezone" class="form-label required">Timezone</label>
                                <select id="timezone" name="timezone"
                                    class="select @error('timezone') border-red-500 @enderror" required>
                                    @foreach (timezone_identifiers_list() as $tz)
                                        <option value="{{ $tz }}"
                                            {{ old('timezone', $settings->timezone) == $tz ? 'selected' : '' }}>
                                            {{ $tz }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Tab -->
            <div class="tab-content hidden animate-fade-in" id="tab-seo">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                <i data-feather="search" class="w-5 h-5 text-amber-600 dark:text-amber-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">SEO
                                    Meta Tags</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure
                                    search engine optimization settings</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title"
                                value="{{ old('meta_title', $settings->meta_title) }}"
                                class="input @error('meta_title') border-red-500 @enderror"
                                placeholder="Your website title for search engines" maxlength="255">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended: 50-60 characters</div>
                        </div>

                        <div class="form-group">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                class="textarea @error('meta_description') border-red-500 @enderror"
                                placeholder="Brief description of your website for search engines" maxlength="500">{{ old('meta_description', $settings->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended: 150-160 characters</div>
                        </div>

                        <div class="form-group">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords"
                                value="{{ old('meta_keywords', $settings->meta_keywords) }}"
                                class="input @error('meta_keywords') border-red-500 @enderror"
                                placeholder="keyword1, keyword2, keyword3" maxlength="500">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Comma-separated keywords</div>
                        </div>

                        <div class="form-group">
                            <label for="canonical_url" class="form-label">Canonical URL</label>
                            <input type="url" id="canonical_url" name="canonical_url"
                                value="{{ old('canonical_url', $settings->canonical_url) }}"
                                class="input @error('canonical_url') border-red-500 @enderror"
                                placeholder="https://yourwebsite.com">
                            @error('canonical_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Open Graph Tags -->
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                <i data-feather="share-2" class="w-5 h-5 text-violet-600 dark:text-violet-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Open
                                    Graph Tags (Social Sharing)</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure
                                    how your site appears when shared on social media</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="og_title" class="form-label">OG Title</label>
                            <input type="text" id="og_title" name="og_title"
                                value="{{ old('og_title', $settings->og_title) }}"
                                class="input @error('og_title') border-red-500 @enderror"
                                placeholder="Title for social media sharing" maxlength="255">
                            @error('og_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="og_description" class="form-label">OG Description</label>
                            <textarea id="og_description" name="og_description" rows="3"
                                class="textarea @error('og_description') border-red-500 @enderror"
                                placeholder="Description for social media sharing" maxlength="500">{{ old('og_description', $settings->og_description) }}</textarea>
                            @error('og_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">OG Image</label>
                            <div class="flex items-start gap-4">
                                @if ($settings->og_image)
                                    <div class="flex-shrink-0">
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($settings->og_image) }}"
                                            alt="OG Image"
                                            class="w-32 h-32 object-cover border border-slate-200 dark:border-slate-700 rounded-lg">
                                        <button type="button" class="btn btn-sm btn-danger mt-2"
                                            onclick="deleteOgImage()">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                            Delete Image
                                        </button>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <input type="file" id="og_image" name="og_image"
                                        accept="image/png,image/jpeg,image/jpg,image/webp"
                                        class="input @error('og_image') border-red-500 @enderror"
                                        onchange="previewImage(this, 'og-image-preview')">
                                    @error('og_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">PNG, JPG, or WEBP. Max 2MB. Recommended: 1200x630px</div>
                                    <div id="og-image-preview" class="mt-2 hidden">
                                        <img src="" alt="OG Image Preview"
                                            class="w-32 h-32 object-cover border border-slate-200 dark:border-slate-700 rounded-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Tab -->
            <div class="tab-content hidden animate-fade-in" id="tab-maintenance">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                                <i data-feather="tool" class="w-5 h-5 text-orange-600 dark:text-orange-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">
                                    Maintenance Mode</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Control site
                                    maintenance and scheduled downtime</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="maintenance_mode" value="1"
                                    {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }}
                                    class="rounded border-slate-300">
                                <span class="font-medium">Enable Maintenance Mode</span>
                            </label>
                            <div class="form-text">When enabled, visitors will see a maintenance message instead of
                                your site</div>
                        </div>

                        <div class="form-group">
                            <label for="maintenance_message" class="form-label">Maintenance Message</label>
                            <textarea id="maintenance_message" name="maintenance_message" rows="4"
                                class="textarea @error('maintenance_message') border-red-500 @enderror"
                                placeholder="We're currently performing scheduled maintenance. Please check back soon.">{{ old('maintenance_message', $settings->maintenance_message) }}</textarea>
                            @error('maintenance_message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label for="maintenance_scheduled_at" class="form-label">Scheduled Start</label>
                                <input type="datetime-local" id="maintenance_scheduled_at"
                                    name="maintenance_scheduled_at"
                                    value="{{ old('maintenance_scheduled_at', $settings->maintenance_scheduled_at ? $settings->maintenance_scheduled_at->format('Y-m-d\TH:i') : '') }}"
                                    class="input @error('maintenance_scheduled_at') border-red-500 @enderror">
                                @error('maintenance_scheduled_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="maintenance_scheduled_until" class="form-label">Scheduled End</label>
                                <input type="datetime-local" id="maintenance_scheduled_until"
                                    name="maintenance_scheduled_until"
                                    value="{{ old('maintenance_scheduled_until', $settings->maintenance_scheduled_until ? $settings->maintenance_scheduled_until->format('Y-m-d\TH:i') : '') }}"
                                    class="input @error('maintenance_scheduled_until') border-red-500 @enderror">
                                @error('maintenance_scheduled_until')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Tab -->
            <div class="tab-content hidden animate-fade-in" id="tab-advanced">
                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-teal-100 dark:bg-teal-900/30 flex items-center justify-center">
                                <i data-feather="bar-chart-2" class="w-5 h-5 text-teal-600 dark:text-teal-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">
                                    Analytics & Tracking</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Configure
                                    analytics and tracking codes</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                            <input type="text" id="google_analytics_id" name="google_analytics_id"
                                value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                                class="input @error('google_analytics_id') border-red-500 @enderror"
                                placeholder="G-XXXXXXXXXX or UA-XXXXXXXXX-X">
                            @error('google_analytics_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card hover:shadow-lg transition-shadow duration-300">
                    <div
                        class="card-header bg-gradient-to-r from-slate-50 to-white dark:from-slate-800 dark:to-slate-700/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center">
                                <i data-feather="code" class="w-5 h-5 text-slate-600 dark:text-slate-400"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-lg font-semibold text-slate-900 dark:text-slate-100">Custom
                                    Code</h6>
                                <p class="card-subtitle text-sm text-slate-600 dark:text-slate-400 mt-0.5">Add custom
                                    CSS and JavaScript</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="form-group">
                            <label for="custom_css" class="form-label">Custom CSS</label>
                            <textarea id="custom_css" name="custom_css" rows="10"
                                class="font-mono text-sm textarea @error('custom_css') border-red-500 @enderror"
                                placeholder="/* Your custom CSS code */">{{ old('custom_css', $settings->custom_css) }}</textarea>
                            @error('custom_css')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">CSS will be injected in the &lt;head&gt; section</div>
                        </div>

                        <div class="form-group">
                            <label for="custom_js" class="form-label">Custom JavaScript</label>
                            <textarea id="custom_js" name="custom_js" rows="10"
                                class="font-mono text-sm textarea @error('custom_js') border-red-500 @enderror"
                                placeholder="// Your custom JavaScript code">{{ old('custom_js', $settings->custom_js) }}</textarea>
                            @error('custom_js')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">JavaScript will be injected before &lt;/body&gt; tag</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Form Actions -->
        <div
            class="sticky bottom-0 bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 -mx-4 -mb-4 px-6 py-4 mt-8 rounded-b-xl shadow-lg">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-slate-600 dark:text-slate-400">
                    <i data-feather="info" class="w-4 h-4 inline mr-1"></i>
                    <span>Changes will be applied immediately after saving</span>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" class="btn btn-secondary group" onclick="window.location.reload()">
                        <i data-feather="refresh-cw"
                            class="w-4 h-4 mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
                        Reset
                    </button>
                    <button type="submit" class="btn btn-primary group relative overflow-hidden">
                        <span class="relative z-10 flex items-center">
                            <i data-feather="save" class="w-4 h-4 mr-2"></i>
                            Save Settings
                        </span>
                        <span
                            class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    @push('styles')
        <style>
            /* Enhanced Tab Navigation */
            .tab-button {
                @apply relative px-5 py-3 text-sm font-semibold text-slate-700 dark:text-slate-300 rounded-lg transition-all duration-300;
                @apply border border-slate-300 dark:border-slate-600;
                @apply bg-white dark:bg-slate-800;
                @apply hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:border-slate-400 dark:hover:border-slate-500;
                @apply focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2;
                min-width: 140px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-direction: row;
            }

            .tab-button-content {
                @apply flex flex-row items-center justify-center gap-2 relative z-10 w-full;
                flex-wrap: nowrap;
            }

            .tab-button-content i {
                @apply w-4 h-4 flex-shrink-0;
                display: inline-block;
            }

            .tab-button-content span {
                @apply font-semibold whitespace-nowrap;
                display: inline-block;
            }

            .tab-button.active {
                @apply text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/30;
                @apply border-primary-500 dark:border-primary-600;
                @apply shadow-sm;
            }

            .tab-content {
                @apply hidden;
                animation: fadeOut 0.2s ease-out;
            }

            .tab-content.active {
                @apply block;
                animation: fadeIn 0.3s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeOut {
                from {
                    opacity: 1;
                }

                to {
                    opacity: 0;
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.3s ease-in;
            }

            .animate-slide-down {
                animation: slideDown 0.3s ease-out;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Form Inputs - Using same style as categories page */
            .form-control,
            .enhanced-input {
                @apply input;
            }

            /* Ensure inputs in form groups maintain proper styling */
            .form-group .form-control,
            .form-group .enhanced-input {
                @apply w-full;
            }

            /* Form Labels */
            .form-label {
                @apply block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2.5;
                @apply tracking-wide;
            }

            .form-label.required::after {
                content: ' *';
                @apply text-red-500 dark:text-red-400 ml-1;
            }

            /* Form Groups */
            .form-group {
                @apply mb-8 pb-6 border-b border-slate-200 dark:border-slate-700;
            }

            .form-group:last-child {
                @apply mb-0 pb-0 border-b-0;
            }

            /* Remove border from last form group in a section */
            .card-body .form-group:last-child,
            .card-body .space-y-6>.form-group:last-child,
            .card-body .space-y-4>.form-group:last-child {
                @apply border-b-0 pb-0;
            }

            /* Form Text Helper */
            .form-text {
                @apply text-xs text-slate-500 dark:text-slate-400 mt-2;
                @apply font-normal;
            }

            /* Card Body Spacing */
            .card-body {
                @apply p-6;
            }

            .card-body .space-y-6>*+* {
                margin-top: 2rem;
            }

            .card-body .space-y-4>*+* {
                margin-top: 1.5rem;
            }

            /* Section Dividers */
            .card-body .form-group+.form-group {
                @apply pt-6;
            }

            /* Card Header */
            .card-header {
                @apply px-6 py-4 border-b-2 border-slate-200 dark:border-slate-700;
            }

            /* Invalid Feedback */
            .invalid-feedback {
                @apply text-sm text-red-600 dark:text-red-400 mt-2 font-medium;
            }

            /* Select Dropdowns - Use select class */
            select.form-control,
            select.enhanced-input {
                @apply select;
            }

            /* Textarea - Use textarea class */
            textarea.form-control,
            textarea.enhanced-input {
                @apply textarea;
                @apply min-h-[100px] resize-y;
            }

            /* Grid Layout Improvements */
            .grid.gap-6>* {
                @apply min-w-0;
            }

            /* File Upload Area */
            .file-upload-area {
                @apply relative border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-8;
                @apply bg-slate-50 dark:bg-slate-800/50;
                @apply transition-all duration-300;
                @apply hover:border-primary-400 dark:hover:border-primary-600;
                @apply hover:bg-primary-50/50 dark:hover:bg-primary-900/10;
                cursor: pointer;
            }

            .file-upload-area.dragover {
                @apply border-primary-500 bg-primary-100 dark:bg-primary-900/30;
                @apply scale-105;
            }

            .file-upload-content {
                @apply text-center;
            }

            .file-upload-icon {
                @apply mx-auto mb-4;
            }

            .file-upload-text {
                @apply text-sm text-slate-600 dark:text-slate-400 mb-1;
            }

            .file-upload-hint {
                @apply text-xs text-slate-500 dark:text-slate-500 mb-1;
            }

            .file-upload-recommendation {
                @apply text-xs text-primary-600 dark:text-primary-400 font-medium;
            }

            /* Enhanced Cards */
            .card {
                @apply transition-all duration-300;
            }

            .card:hover {
                @apply shadow-md;
            }

            /* Character Counter */
            #description-count {
                @apply transition-colors duration-200;
            }

            #description-count.warning {
                @apply text-amber-600 dark:text-amber-400;
            }

            #description-count.danger {
                @apply text-red-600 dark:text-red-400;
            }

            /* Card Improvements */
            .card {
                @apply bg-white dark:bg-slate-800 rounded-xl shadow-sm border-2 border-slate-200 dark:border-slate-700;
                @apply transition-all duration-300;
            }

            .card:hover {
                @apply shadow-lg border-slate-300 dark:border-slate-600;
            }

            /* Grid Improvements for Form Fields */
            .grid.gap-6 {
                gap: 1.5rem;
            }

            .grid.gap-4 {
                gap: 1rem;
            }

            /* Responsive Improvements */
            @media (max-width: 640px) {
                .tab-button {
                    @apply px-3 py-2 text-xs;
                }

                .tab-button-content span {
                    @apply hidden sm:inline;
                }

                .card-body {
                    @apply p-4;
                }

                .card-header {
                    @apply px-4 py-3;
                }

                .form-group {
                    @apply mb-4;
                }
            }

            /* Loading State */
            .btn-loading {
                @apply opacity-75 cursor-not-allowed;
                pointer-events: none;
            }

            .btn-loading i {
                @apply animate-spin;
            }

            /* Smooth Scrolling */
            html {
                scroll-behavior: smooth;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Enhanced Tab Switching with Animations
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const tabId = this.getAttribute('data-tab');
                    switchTab(tabId, this);
                });

                // Keyboard navigation
                button.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const tabId = this.getAttribute('data-tab');
                        switchTab(tabId, this);
                    }
                });
            });

            function switchTab(tabId, button) {
                // Remove active class from all buttons and contents
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active');
                    btn.setAttribute('aria-selected', 'false');
                });
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                    content.classList.add('hidden');
                });

                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                button.setAttribute('aria-selected', 'true');
                const content = document.getElementById('tab-' + tabId);
                if (content) {
                    setTimeout(() => {
                        content.classList.remove('hidden');
                        content.classList.add('active');
                        // Scroll to top of content
                        content.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });
                    }, 50);
                }

                // Update Feather icons after tab switch
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            }

            // Enhanced Image Preview with File Validation
            function previewImage(input, previewId, uploadAreaId) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const maxSize = input.id === 'favicon' ? 1024 * 1024 : 2 * 1024 * 1024; // 1MB for favicon, 2MB for others
                    const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml', 'image/webp', 'image/x-icon'];

                    // Validate file type
                    if (!validTypes.includes(file.type)) {
                        showNotification('Invalid file type. Please upload PNG, JPG, SVG, WEBP, or ICO.', 'error');
                        input.value = '';
                        return;
                    }

                    // Validate file size
                    if (file.size > maxSize) {
                        showNotification(`File size exceeds limit. Max size: ${maxSize / (1024 * 1024)}MB`, 'error');
                        input.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById(previewId);
                        if (preview) {
                            preview.querySelector('img').src = e.target.result;
                            preview.classList.remove('hidden');
                            preview.classList.add('animate-fade-in');
                        }

                        // Update upload area
                        if (uploadAreaId) {
                            const uploadArea = document.getElementById(uploadAreaId);
                            if (uploadArea) {
                                uploadArea.classList.add('border-primary-400', 'bg-primary-50/50');
                                setTimeout(() => {
                                    uploadArea.classList.remove('border-primary-400', 'bg-primary-50/50');
                                }, 2000);
                            }
                        }
                    };
                    reader.readAsDataURL(file);
                }
            }

            // File Upload Drag and Drop
            document.querySelectorAll('.file-upload-area').forEach(area => {
                const input = area.querySelector('input[type="file"]');
                if (!input) return;

                // Click to upload
                area.addEventListener('click', () => input.click());

                // Drag and drop
                area.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    area.classList.add('dragover');
                });

                area.addEventListener('dragleave', () => {
                    area.classList.remove('dragover');
                });

                area.addEventListener('drop', (e) => {
                    e.preventDefault();
                    area.classList.remove('dragover');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        input.files = files;
                        const previewId = input.id === 'logo' ? 'logo-preview' :
                            input.id === 'favicon' ? 'favicon-preview' : 'og-image-preview';
                        previewImage(input, previewId, area.id);
                    }
                });
            });

            // Character Counter for Description
            const descriptionTextarea = document.getElementById('website_description');
            const descriptionCount = document.getElementById('description-count');

            if (descriptionTextarea && descriptionCount) {
                function updateDescriptionCount() {
                    const length = descriptionTextarea.value.length;
                    descriptionCount.textContent = `${length} characters`;

                    descriptionCount.classList.remove('warning', 'danger');
                    if (length > 500) {
                        descriptionCount.classList.add('danger');
                    } else if (length > 400) {
                        descriptionCount.classList.add('warning');
                    }
                }

                descriptionTextarea.addEventListener('input', updateDescriptionCount);
                updateDescriptionCount(); // Initial count
            }

            // Enhanced Form Validation Feedback
            document.querySelectorAll('.enhanced-input').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.validity.valid && this.value.trim() !== '') {
                        this.classList.add('border-emerald-300', 'dark:border-emerald-700');
                        const icon = this.parentElement.querySelector('.input-valid-icon');
                        if (icon) icon.classList.remove('hidden');
                    } else if (this.hasAttribute('required') && !this.validity.valid) {
                        this.classList.add('border-red-300', 'dark:border-red-700');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('border-red-300') || this.classList.contains(
                            'border-red-700')) {
                        this.classList.remove('border-red-300', 'border-red-700');
                    }
                });
            });

            // Form Submission with Loading State
            const form = document.getElementById('site-settings-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('btn-loading');
                        submitBtn.disabled = true;
                        submitBtn.innerHTML =
                            '<i data-feather="loader" class="w-4 h-4 mr-2 animate-spin"></i>Saving...';
                        if (typeof feather !== 'undefined') {
                            feather.replace();
                        }
                    }
                });
            }

            // Show Notification Function
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 z-50 p-4 rounded-xl shadow-lg max-w-sm animate-slide-down ${
        type === 'error' ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' :
        type === 'success' ? 'bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800' :
        'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800'
      }`;
                notification.innerHTML = `
        <div class="flex items-center gap-3">
          <i data-feather="${type === 'error' ? 'alert-circle' : type === 'success' ? 'check-circle' : 'info'}"
             class="w-5 h-5 ${type === 'error' ? 'text-red-600' : type === 'success' ? 'text-emerald-600' : 'text-blue-600'}"></i>
          <p class="text-sm font-medium ${type === 'error' ? 'text-red-900 dark:text-red-100' : type === 'success' ? 'text-emerald-900 dark:text-emerald-100' : 'text-blue-900 dark:text-blue-100'}">${message}</p>
          <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-slate-400 hover:text-slate-600">
            <i data-feather="x" class="w-4 h-4"></i>
          </button>
        </div>
      `;
                document.body.appendChild(notification);
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
                setTimeout(() => notification.remove(), 5000);
            }

            // Enhanced Delete Functions with Better UX
            async function deleteLogo() {
                if (!confirm('Are you sure you want to delete the logo? This action cannot be undone.')) return;

                try {
                    showNotification('Deleting logo...', 'info');
                    const response = await fetch('{{ route('admin.site-settings.delete-logo') }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        showNotification('Logo deleted successfully', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification(data.message || 'Failed to delete logo', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the logo', 'error');
                }
            }

            async function deleteFavicon() {
                if (!confirm('Are you sure you want to delete the favicon? This action cannot be undone.')) return;

                try {
                    showNotification('Deleting favicon...', 'info');
                    const response = await fetch('{{ route('admin.site-settings.delete-favicon') }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        showNotification('Favicon deleted successfully', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification(data.message || 'Failed to delete favicon', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the favicon', 'error');
                }
            }

            async function deleteOgImage() {
                if (!confirm('Are you sure you want to delete the OG image? This action cannot be undone.')) return;

                try {
                    showNotification('Deleting OG image...', 'info');
                    const response = await fetch('{{ route('admin.site-settings.delete-og-image') }}', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    if (data.success) {
                        showNotification('OG image deleted successfully', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification(data.message || 'Failed to delete OG image', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('An error occurred while deleting the OG image', 'error');
                }
            }

            // Enhanced Color Picker Sync with Live Preview
            document.querySelectorAll('input[type="color"]').forEach(colorInput => {
                const textInputId = colorInput.id + '_text';
                const textInput = document.getElementById(textInputId);
                const previewId = colorInput.id.replace('_color', '_color_preview');
                const preview = document.getElementById(previewId);

                if (textInput) {
                    // Color picker to text input
                    colorInput.addEventListener('input', function() {
                        textInput.value = this.value;
                        if (preview) {
                            preview.style.backgroundColor = this.value;
                        }
                    });

                    // Text input to color picker
                    textInput.addEventListener('input', function() {
                        if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(this.value)) {
                            colorInput.value = this.value;
                            if (preview) {
                                preview.style.backgroundColor = this.value;
                            }
                        }
                    });
                }
            });

            // Auto-save Indicator (Visual feedback)
            let saveTimeout;
            form?.addEventListener('input', function() {
                clearTimeout(saveTimeout);
                const indicator = document.querySelector('.auto-save-indicator');
                if (indicator) {
                    indicator.classList.remove('hidden');
                    saveTimeout = setTimeout(() => {
                        indicator.classList.add('hidden');
                    }, 2000);
                }
            });

            // Initialize Everything
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }

                // Add smooth scroll behavior
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        if (href !== '#') {
                            e.preventDefault();
                            const target = document.querySelector(href);
                            if (target) {
                                target.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        }
                    });
                });

                // Focus management for accessibility
                const firstInput = form?.querySelector('input:not([type="hidden"]), textarea, select');
                if (firstInput && !firstInput.value) {
                    // Don't auto-focus if there's existing data
                }
            });

            // Keyboard Shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + S to save
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    if (form) {
                        form.requestSubmit();
                    }
                }
            });
        </script>
    @endpush
</x-admin-layout>
