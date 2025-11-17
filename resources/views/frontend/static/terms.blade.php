<x-app-layout :title="$title">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sm:p-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Terms and Conditions</h1>
            
            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Acceptance of Terms</h2>
                    <p class="mb-4">
                        By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement. 
                        If you do not agree to abide by the above, please do not use this service.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Use License</h2>
                    <p class="mb-4">
                        Permission is granted to temporarily download one copy of the materials on our website for personal, 
                        non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                    </p>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li>Modify or copy the materials</li>
                        <li>Use the materials for any commercial purpose or for any public display</li>
                        <li>Attempt to reverse engineer any software contained on the website</li>
                        <li>Remove any copyright or other proprietary notations from the materials</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Products and Pricing</h2>
                    <p class="mb-4">
                        We reserve the right to change prices and availability of products at any time without notice. 
                        All prices are in the currency displayed and are subject to change. We strive to provide accurate 
                        product descriptions and images, but we do not warrant that product descriptions or other content 
                        on this site is accurate, complete, reliable, current, or error-free.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Orders and Payment</h2>
                    <p class="mb-4">
                        When you place an order, you are offering to purchase a product subject to these Terms and Conditions. 
                        We reserve the right to refuse or cancel any order for any reason, including but not limited to product 
                        availability, errors in pricing or product information, or fraud.
                    </p>
                    <p class="mb-4">
                        Payment must be received before we ship your order. We accept various payment methods as displayed 
                        on our checkout page.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Shipping and Delivery</h2>
                    <p class="mb-4">
                        We will make every effort to deliver products within the estimated timeframe. However, delivery times 
                        are estimates and not guaranteed. We are not responsible for delays caused by shipping carriers or 
                        circumstances beyond our control.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Returns and Refunds</h2>
                    <p class="mb-4">
                        Please review our return policy before making a purchase. Returns must be made within the specified 
                        time period and in accordance with our return policy. Refunds will be processed according to our 
                        refund policy.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Limitation of Liability</h2>
                    <p class="mb-4">
                        In no event shall our company or its suppliers be liable for any damages (including, without limitation, 
                        damages for loss of data or profit, or due to business interruption) arising out of the use or inability 
                        to use the materials on our website.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. Contact Information</h2>
                    <p class="mb-4">
                        If you have any questions about these Terms and Conditions, please contact us through our support page 
                        or using the contact information provided on our website.
                    </p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>

