@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Code:</strong>
            <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" class="input @error('code') border-red-500 @enderror" placeholder="Code">
            @error('code')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Type:</strong>
            <select name="type" class="select @error('type') border-red-500 @enderror">
                <option value="fixed" @if(old('type', $coupon->type ?? '') == 'fixed') selected @endif>Fixed</option>
                <option value="percent" @if(old('type', $coupon->type ?? '') == 'percent') selected @endif>Percent</option>
            </select>
            @error('type')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Value:</strong>
            <input type="text" name="value" value="{{ old('value', $coupon->value ?? '') }}" class="input @error('value') border-red-500 @enderror" placeholder="Value">
            @error('value')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Expires At:</strong>
            <input type="date" name="expires_at" value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d') : '') }}" class="input @error('expires_at') border-red-500 @enderror">
            @error('expires_at')
                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @if(old('is_active', $coupon->is_active ?? 0)) checked @endif>
            <label class="form-check-label" for="is_active">
                Is Active?
            </label>
        </div>
    </div>
</div>
