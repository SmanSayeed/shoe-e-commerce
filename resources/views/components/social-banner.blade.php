@if(site('show_social_banner'))
<!-- Social Media Banner -->
<section class="w-full py-6 sm:py-8 md:py-12 animate-fade-in" id="social-banner">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-purple-600 via-pink-600 to-purple-600 shadow-lg">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 30px 30px;"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6 md:gap-8 px-4 sm:px-6 md:px-8 py-8 sm:py-10 md:py-12">
                <!-- Facebook Icon -->
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </div>
                </div>

                <!-- Text Content -->
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2 sm:mb-3">
                        Stay Connected with Step Style!
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg text-white/90 mb-4 sm:mb-6">
                        Follow us on Facebook for the latest updates, exclusive offers, and style inspiration.
                    </p>
                </div>

                <!-- CTA Button -->
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <a href="{{ site('facebook_url', '#') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 sm:px-8 md:px-10 py-3 sm:py-3.5 md:py-4 bg-white text-purple-600 font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm sm:text-base md:text-lg">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Follow Us on Facebook</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
</style>
@endif

