<x-admin-layout title="Advance Payment Settings">
  <!-- Page Title Starts -->
  <div class="mb-6 flex flex-col justify-between gap-y-1 sm:flex-row sm:gap-y-0">
    <h5>Advance Payment Settings</h5>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Shipping</a>
      </li>
      <li class="breadcrumb-item">
        <a href="#">Advance Payment</a>
      </li>
    </ol>
  </div>
  <!-- Page Title Ends -->

  <!-- Advance Payment Settings Form Starts -->
  <div class="space-y-4">
    <div class="card">
      <div class="card-header">
        <h6 class="card-title">Advance Payment Configuration</h6>
        <p class="card-subtitle">Configure advance payment settings for orders. When enabled, customers will be required to pay an advance amount before order confirmation.</p>
      </div>

      <div class="card-body">
        <div id="message"></div>

        <form id="advancePaymentForm" class="space-y-4">
          @csrf

          <div class="form-group">
            <label for="advance_payment_status" class="form-label required">Enable Advance Payment</label>
            <div class="flex items-center">
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="advance_payment_status" value="0">
                <input 
                  type="checkbox" 
                  class="sr-only peer" 
                  id="advance_payment_status" 
                  name="advance_payment_status" 
                  value="1" 
                  {{ $settings->advance_payment_status ? 'checked' : '' }}
                />
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-primary"></div>
                <span class="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300">
                  {{ $settings->advance_payment_status ? 'Enabled' : 'Disabled' }}
                </span>
              </label>
            </div>
            <div class="form-text">When enabled, customers must pay an advance amount before their order is confirmed.</div>
          </div>

          <div class="form-group">
            <label for="advance_payment_amount" class="form-label required">Advance Payment Amount (BDT)</label>
            <input
              type="number"
              id="advance_payment_amount"
              name="advance_payment_amount"
              value="{{ $settings->advance_payment_amount }}"
              class="input @error('advance_payment_amount') border-red-500 @enderror"
              placeholder="Enter advance payment amount"
              min="0"
              step="0.01"
              {{ !$settings->advance_payment_status ? 'disabled' : '' }}
            />
            @error('advance_payment_amount')
              <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
            <div class="form-text">The amount customers need to pay in advance. This amount will be deducted from the total order amount.</div>
          </div>

          <div class="form-group">
            <label for="note" class="form-label">Note</label>
            <textarea
              id="note"
              name="note"
              rows="4"
              class="input @error('note') border-red-500 @enderror"
              placeholder="Enter any additional notes or instructions about advance payment..."
            >{{ old('note', $settings->note ?? '') }}</textarea>
            @error('note')
              <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
            @enderror
            <div class="form-text">Optional: Add any notes or instructions related to advance payment settings. This will be visible to administrators only.</div>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="btn btn-primary" id="saveButton">
              <i class="w-4 h-4 mr-2" data-feather="save"></i>
              Update Settings
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Advance Payment Settings Form Ends -->

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const statusCheckbox = document.getElementById('advance_payment_status');
                const amountInput = document.getElementById('advance_payment_amount');
                const noteTextarea = document.getElementById('note');
                const form = document.getElementById('advancePaymentForm');
                const saveButton = document.getElementById('saveButton');
                const statusLabel = statusCheckbox.closest('label').querySelector('span');

                // Store initial values
                let initialStatus = statusCheckbox.checked;
                let initialAmount = amountInput.value;
                let initialNote = noteTextarea.value;

                function checkFormChanges() {
                    const currentStatus = statusCheckbox.checked;
                    const currentAmount = amountInput.value;
                    const currentNote = noteTextarea.value;

                    const statusChanged = currentStatus !== initialStatus;
                    const amountChanged = currentAmount !== initialAmount;
                    const noteChanged = currentNote !== initialNote;

                    saveButton.disabled = !(statusChanged || amountChanged || noteChanged);
                }

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    saveButton.disabled = true;
                    saveButton.innerHTML = '<i class="w-4 h-4 mr-2 animate-spin" data-feather="loader"></i>Saving...';
                    
                    // Re-initialize feather icons for the spinner
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }

                    const response = await fetch('{{ route("admin.advance-payment.update") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();
                    const msg = document.getElementById('message');

                    if (response.ok) {
                        msg.innerHTML = `<div class="alert alert-success mb-4">
                            <i class="w-5 h-5" data-feather="check-circle"></i>
                            <span>${data.message}</span>
                        </div>`;
                        // Update initial state after successful save
                        initialStatus = statusCheckbox.checked;
                        initialAmount = amountInput.value;
                        initialNote = noteTextarea.value;
                        checkFormChanges(); // Re-check to disable button
                    } else {
                        let errorMessages = '';
                        if (data.errors) {
                            errorMessages = '<ul class="mt-2">';
                            for (const key in data.errors) {
                                errorMessages += `<li>${data.errors[key][0]}</li>`;
                            }
                            errorMessages += '</ul>';
                        } else {
                            errorMessages = data.message || 'An unexpected error occurred.';
                        }
                        msg.innerHTML = `<div class="alert alert-danger mb-4">
                            <i class="w-5 h-5" data-feather="alert-circle"></i>
                            <span>Please fix the following errors:</span>
                            ${errorMessages}
                        </div>`;
                    }
                    
                    // Re-initialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                    
                    saveButton.disabled = false;
                    saveButton.innerHTML = '<i class="w-4 h-4 mr-2" data-feather="save"></i>Update Settings';
                    
                    // Re-initialize feather icons again
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                });

                statusCheckbox.addEventListener('change', function() {
                    amountInput.disabled = !this.checked;
                    if (!this.checked) {
                        amountInput.value = '';
                    }
                    // Update label text
                    if (statusLabel) {
                        statusLabel.textContent = this.checked ? 'Enabled' : 'Disabled';
                    }
                    checkFormChanges();
                });

                amountInput.addEventListener('input', checkFormChanges);
                noteTextarea.addEventListener('input', checkFormChanges);

                // Initial check to set button state
                checkFormChanges();
            });
        </script>
    @endpush
</x-admin-layout>
