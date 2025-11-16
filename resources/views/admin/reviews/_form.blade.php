@props(['review' => null, 'products' => collect(), 'customers' => collect()])

<div class="card">
  <div class="card-body space-y-6">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="space-y-4">
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Reviewer Name <span class="text-danger">*</span></label>
          <input type="text" name="reviewer_name" value="{{ old('reviewer_name', optional($review)->reviewer_name ?? '') }}" class="input" required>
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Reviewer Email</label>
          <input type="email" name="reviewer_email" value="{{ old('reviewer_email', optional($review)->reviewer_email ?? '') }}" class="input">
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Location</label>
          <input type="text" name="reviewer_location" value="{{ old('reviewer_location', optional($review)->reviewer_location ?? '') }}" class="input">
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Customer (optional)</label>
          <select name="customer_id" class="input">
            <option value="">No customer linked</option>
            @foreach($customers as $id => $name)
              <option value="{{ $id }}" {{ (string) old('customer_id', optional($review)->customer_id ?? '') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
          <p class="text-xs text-slate-500">Link to an existing customer if this review is from a registered user.</p>
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Rating <span class="text-danger">*</span></label>
          <select name="rating" class="input" required>
            @for($i = 5; $i >= 1; $i--)
              <option value="{{ $i }}" {{ (int) old('rating', optional($review)->rating ?? 5) === $i ? 'selected' : '' }}>{{ $i }} Stars</option>
            @endfor
          </select>
        </div>
      </div>

      <div class="space-y-4">
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Product (optional)</label>
          <select name="product_id" class="input">
            <option value="">No product linked</option>
            @foreach($products as $id => $name)
              <option value="{{ $id }}" {{ (string) old('product_id', optional($review)->product_id ?? '') === (string) $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
          </select>
          <p class="text-xs text-slate-500">Choose a product to display alongside this testimonial.</p>
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Product Display Name</label>
          <input type="text" name="product_display_name" value="{{ old('product_display_name', optional($review)->product_display_name ?? '') }}" class="input" placeholder="e.g., Premium Oxford Shoes">
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Reviewed Date</label>
          <input type="date" name="reviewed_at" value="{{ old('reviewed_at', optional($review)->reviewed_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="input">
        </div>
        <div class="space-y-2">
          <label class="text-sm font-medium text-slate-600">Display Order</label>
          <input type="number" name="display_order" min="0" value="{{ old('display_order', optional($review)->display_order ?? 0) }}" class="input">
          <p class="text-xs text-slate-500">Lower numbers appear first on the homepage slider.</p>
        </div>
      </div>
    </div>

    <div class="space-y-2">
      <label class="text-sm font-medium text-slate-600">Comment <span class="text-danger">*</span></label>
      <textarea name="comment" rows="4" class="input" required>{{ old('comment', optional($review)->comment ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
      <label class="flex items-center gap-3 rounded border border-slate-200 p-3">
        <input type="checkbox" name="is_verified_purchase" value="1" {{ old('is_verified_purchase', optional($review)->is_verified_purchase ?? false) ? 'checked' : '' }}>
        <div>
          <p class="text-sm font-medium text-slate-700">Verified Purchase</p>
          <p class="text-xs text-slate-500">Highlight reviews from real orders.</p>
        </div>
      </label>
      <label class="flex items-center gap-3 rounded border border-slate-200 p-3">
        <input type="checkbox" name="is_approved" value="1" {{ old('is_approved', optional($review)->is_approved ?? true) ? 'checked' : '' }}>
        <div>
          <p class="text-sm font-medium text-slate-700">Approved</p>
          <p class="text-xs text-slate-500">Only approved reviews show publicly.</p>
        </div>
      </label>
      <label class="flex items-center gap-3 rounded border border-slate-200 p-3">
        <input type="checkbox" name="show_on_homepage" value="1" {{ old('show_on_homepage', optional($review)->show_on_homepage ?? true) ? 'checked' : '' }}>
        <div>
          <p class="text-sm font-medium text-slate-700">Show on Homepage</p>
          <p class="text-xs text-slate-500">Control whether this review appears in the hero slider.</p>
        </div>
      </label>
      <label class="flex items-center gap-3 rounded border border-slate-200 p-3">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', optional($review)->is_featured ?? false) ? 'checked' : '' }}>
        <div>
          <p class="text-sm font-medium text-slate-700">Featured</p>
          <p class="text-xs text-slate-500">Use for highlighting on upcoming sections.</p>
        </div>
      </label>
    </div>
  </div>
</div>
