@php
    $settings = \App\Models\Setting::whereIn('key', ['whatsapp_enabled', 'whatsapp_phone', 'whatsapp_message', 'whatsapp_chat_enabled'])
                                   ->pluck('value', 'key')
                                   ->toArray();

    $enabled = $settings['whatsapp_enabled'] ?? false;
    $phone = $settings['whatsapp_phone'] ?? '';
    $message = $settings['whatsapp_message'] ?? 'Hello! I need help with my order.';
    $chatEnabled = $settings['whatsapp_chat_enabled'] ?? false;
@endphp

@if($enabled && $phone)
<!-- WhatsApp Floating Button -->
<div id="whatsapp-button" class="fixed bottom-6 right-6 z-50">
    <!-- Main WhatsApp Button -->
    <div class="relative">
        <button id="whatsapp-toggle"
                class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg transition-all duration-300 hover:scale-110 group"
                aria-label="Contact us on WhatsApp">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
        </button>

        <!-- Notification Badge -->
        <div id="whatsapp-notification" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-6 w-6 flex items-center justify-center opacity-0 transition-opacity duration-300">
            1
        </div>
    </div>

    <!-- Chat Preview (when chat is enabled) -->
    @if($chatEnabled)
    <div id="whatsapp-preview"
         class="absolute bottom-full right-0 mb-4 bg-white rounded-lg shadow-xl border border-slate-200 p-4 w-80 opacity-0 invisible transform translate-y-4 transition-all duration-300">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-slate-900">Need Help?</h4>
                <p class="text-sm text-slate-500">Chat with us on WhatsApp</p>
            </div>
        </div>

        <form id="whatsapp-chat-form" class="space-y-3">
            @csrf
            <div>
                <input type="text" name="customer_name" placeholder="Your Name (Optional)"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <input type="tel" name="phone_number" placeholder="Phone Number" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
            </div>
            <div>
                <textarea name="message" rows="3" placeholder="Your Message" required
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none">{{ $message }}</textarea>
            </div>
            <button type="submit"
                    class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition-colors text-sm font-medium">
                Send Message
            </button>
        </form>

        <div class="mt-3 text-center">
            <a href="#" id="whatsapp-direct-link"
               class="text-sm text-green-600 hover:text-green-700 font-medium">
                Or open WhatsApp directly
            </a>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('whatsapp-toggle');
    const preview = document.getElementById('whatsapp-preview');
    const form = document.getElementById('whatsapp-chat-form');
    const directLink = document.getElementById('whatsapp-direct-link');

    @if($chatEnabled)
    // Toggle chat preview
    button.addEventListener('click', function(e) {
        e.preventDefault();
        if (preview.classList.contains('opacity-0')) {
            preview.classList.remove('opacity-0', 'invisible', 'translate-y-4');
            preview.classList.add('opacity-100', 'visible', 'translate-y-0');
        } else {
            preview.classList.remove('opacity-100', 'visible', 'translate-y-0');
            preview.classList.add('opacity-0', 'invisible', 'translate-y-4');
        }
    });

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        submitButton.textContent = 'Sending...';
        submitButton.disabled = true;

        try {
            const response = await fetch('{{ route("whatsapp.send-message") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                form.reset();
                preview.classList.remove('opacity-100', 'visible', 'translate-y-0');
                preview.classList.add('opacity-0', 'invisible', 'translate-y-4');
            } else {
                alert(data.error || 'An error occurred. Please try again.');
            }
        } catch (error) {
            alert('An error occurred. Please try again.');
            console.error('WhatsApp form error:', error);
        } finally {
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });

    // Direct WhatsApp link
    directLink.addEventListener('click', function(e) {
        e.preventDefault();
        const phone = '{{ $phone }}';
        const message = encodeURIComponent('{{ $message }}');
        window.open(`https://wa.me/${phone}?text=${message}`, '_blank');
    });

    // Close preview when clicking outside
    document.addEventListener('click', function(e) {
        if (!document.getElementById('whatsapp-button').contains(e.target)) {
            preview.classList.remove('opacity-100', 'visible', 'translate-y-0');
            preview.classList.add('opacity-0', 'invisible', 'translate-y-4');
        }
    });
    @else
    // Direct WhatsApp redirect
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const phone = '{{ $phone }}';
        const message = encodeURIComponent('{{ $message }}');
        window.open(`https://wa.me/${phone}?text=${message}`, '_blank');

        // Log the click
        fetch('{{ route("whatsapp.redirect") }}', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).catch(console.error);
    });
    @endif
});
</script>

<style>
#whatsapp-button {
    animation: bounceIn 0.6s ease-out;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.3);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

#whatsapp-preview {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Mobile adjustments */
@media (max-width: 640px) {
    #whatsapp-button {
        bottom: 1rem;
        right: 1rem;
    }

    #whatsapp-preview {
        right: -1rem;
        left: 1rem;
        width: auto;
        max-width: calc(100vw - 2rem);
    }
}
</style>
@endif
