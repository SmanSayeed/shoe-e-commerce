<x-app-layout :title="$title">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sm:p-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Privacy Policy</h1>
            
            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="text-gray-600 mb-6">Last updated: {{ date('F d, Y') }}</p>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Introduction</h2>
                    <p class="mb-4">
                        Welcome to our website. We are committed to protecting your personal information and your right to privacy. 
                        This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Information We Collect</h2>
                    <p class="mb-4">We collect information that you provide directly to us, including:</p>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li>Name and contact information</li>
                        <li>Email address</li>
                        <li>Phone number</li>
                        <li>Shipping and billing addresses</li>
                        <li>Payment information</li>
                        <li>Order history</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. How We Use Your Information</h2>
                    <p class="mb-4">We use the information we collect to:</p>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li>Process and fulfill your orders</li>
                        <li>Communicate with you about your orders and our services</li>
                        <li>Send you marketing communications (with your consent)</li>
                        <li>Improve our website and customer experience</li>
                        <li>Detect and prevent fraud</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Information Sharing</h2>
                    <p class="mb-4">
                        We do not sell, trade, or rent your personal information to third parties. We may share your information 
                        with service providers who assist us in operating our website and conducting our business, subject to strict 
                        confidentiality agreements.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Data Security</h2>
                    <p class="mb-4">
                        We implement appropriate technical and organizational security measures to protect your personal information 
                        against unauthorized access, alteration, disclosure, or destruction.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Your Rights</h2>
                    <p class="mb-4">You have the right to:</p>
                    <ul class="list-disc pl-6 mb-4 space-y-2">
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your information</li>
                        <li>Opt-out of marketing communications</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Contact Us</h2>
                    <p class="mb-4">
                        If you have any questions about this Privacy Policy, please contact us through our support page or 
                        using the contact information provided on our website.
                    </p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>

