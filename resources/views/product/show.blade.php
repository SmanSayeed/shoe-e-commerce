<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - SSB Leather</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .product-image { aspect-ratio: 1; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-btn.active { border-bottom-color: #8B4513; color: #8B4513; }
    </style>
</head>
<body class="bg-gray-50">

@include('components.header')

<!-- Breadcrumb -->
<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 py-3">
        <nav class="text-sm text-gray-600">
            <a href="/" class="hover:text-gray-900">Home</a>
            <span class="mx-2">/</span>
            <a href="/products" class="hover:text-gray-900">Products</a>
            <span class="mx-2">/</span>
            <span id="breadcrumb-product" class="text-gray-900">Product Details</span>
        </nav>
    </div>
</div>

<!-- Product Section -->
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        <!-- Product Images -->
        <div class="space-y-4">
            <div class="product-image bg-white rounded-lg overflow-hidden shadow-sm">
                <img id="main-image" src="https://images.unsplash.com/photo-1603796847227-9183fd69e884" alt="Product" class="w-full h-full object-cover">
            </div>
            <div id="thumbnail-grid" class="grid grid-cols-4 gap-2">
                <!-- Thumbnails will be populated by JavaScript -->
            </div>
        </div>

        <!-- Product Info -->
        <div class="space-y-6">
            <div>
                <h1 id="product-title" class="text-3xl font-bold text-gray-900 mb-2">Loading...</h1>
                <div class="flex items-center space-x-4">
                    <span id="product-price" class="text-2xl font-bold text-amber-600">৳0</span>
                    <span id="original-price" class="text-lg text-gray-500 line-through hidden">৳0</span>
                    <span id="discount-badge" class="bg-red-100 text-red-800 text-sm px-2 py-1 rounded hidden">-0%</span>
                </div>
            </div>

            <!-- Product Variants -->
            <div id="product-variants" class="space-y-4">
                <!-- Variants will be populated by JavaScript -->
            </div>

            <!-- Quantity and Actions -->
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-700">Quantity:</label>
                    <div class="flex items-center border rounded">
                        <button id="qty-minus" class="px-3 py-2 hover:bg-gray-100">-</button>
                        <input id="quantity" type="number" value="1" min="1" class="w-16 text-center border-0 focus:ring-0">
                        <button id="qty-plus" class="px-3 py-2 hover:bg-gray-100">+</button>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <button id="add-to-cart" class="flex-1 bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition">
                        Add to Cart
                    </button>
                    <button id="buy-now" class="flex-1 bg-gray-900 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-800 transition">
                        Buy Now
                    </button>
                </div>
            </div>

            <!-- Product Meta -->
            <div class="border-t pt-6 space-y-2 text-sm text-gray-600">
                <div><strong>SKU:</strong> <span id="product-sku">-</span></div>
                <div><strong>Availability:</strong> <span id="stock-status">In Stock</span></div>
                <div><strong>Category:</strong> <span id="product-category">-</span></div>
            </div>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="mt-16">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8">
                <button class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium active" data-tab="description">
                    Description
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium" data-tab="specifications">
                    Specifications
                </button>
                <button class="tab-btn py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium" data-tab="reviews">
                    Reviews
                </button>
            </nav>
        </div>

        <div class="py-8">
            <!-- Description Tab -->
            <div id="description" class="tab-content active">
                <div class="prose max-w-none">
                    <div id="product-description">
                        <p>Loading product description...</p>
                    </div>
                </div>
            </div>

            <!-- Specifications Tab -->
            <div id="specifications" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div id="product-specs">
                        <!-- Specifications will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews" class="tab-content">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">Customer Reviews</h3>
                        <button class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
                            Write a Review
                        </button>
                    </div>
                    <div id="product-reviews">
                        <!-- Reviews will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.footer')

<script>
// Tab functionality
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const tabId = btn.dataset.tab;

        // Remove active class from all tabs and buttons
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));

        // Add active class to clicked button and corresponding tab
        btn.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});

// Quantity controls
document.getElementById('qty-minus').addEventListener('click', () => {
    const qty = document.getElementById('quantity');
    if (qty.value > 1) qty.value = parseInt(qty.value) - 1;
});

document.getElementById('qty-plus').addEventListener('click', () => {
    const qty = document.getElementById('quantity');
    qty.value = parseInt(qty.value) + 1;
});

// Format price function
function formatPrice(price) {
    return '৳' + Number(price).toLocaleString();
}

// Load product data
async function loadProductData() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');

    if (!productId) {
        document.getElementById('product-title').textContent = 'No product ID provided';
        return;
    }

    try {
        const response = await fetch(`/product/data/${productId}`);
        if (!response.ok) throw new Error('Product not found');

        const product = await response.json();

        // Update product info
        document.getElementById('product-title').textContent = product.name || 'Product Name';
        document.getElementById('breadcrumb-product').textContent = product.name || 'Product Details';
        document.getElementById('product-sku').textContent = product.sku || '-';

        // Update pricing
        const currentPrice = product.sale_price || product.price;
        document.getElementById('product-price').textContent = formatPrice(currentPrice);

        if (product.sale_price && product.price > product.sale_price) {
            document.getElementById('original-price').textContent = formatPrice(product.price);
            document.getElementById('original-price').classList.remove('hidden');

            const discount = Math.round(((product.price - product.sale_price) / product.price) * 100);
            document.getElementById('discount-badge').textContent = `-${discount}%`;
            document.getElementById('discount-badge').classList.remove('hidden');
        }

        // Update images
        if (product.images && product.images.length > 0) {
            const mainImg = document.getElementById('main-image');
            mainImg.src = product.images[0].image_path;
            mainImg.alt = product.name;

            // Update thumbnails
            const thumbnailGrid = document.getElementById('thumbnail-grid');
            thumbnailGrid.innerHTML = '';

            product.images.slice(0, 4).forEach((image, index) => {
                const thumb = document.createElement('div');
                thumb.className = 'product-image bg-white rounded cursor-pointer overflow-hidden shadow-sm hover:shadow-md transition';
                thumb.innerHTML = `<img src="${image.image_path}" alt="${product.name}" class="w-full h-full object-cover">`;
                thumb.onclick = () => {
                    mainImg.src = image.image_path;
                };
                thumbnailGrid.appendChild(thumb);
            });
        }

        // Update variants
        if (product.variants && product.variants.length > 0) {
            const variantsContainer = document.getElementById('product-variants');
            variantsContainer.innerHTML = '<div class="space-y-2"><label class="text-sm font-medium text-gray-700">Options:</label><div class="flex flex-wrap gap-2" id="variant-buttons"></div></div>';

            const variantButtons = document.getElementById('variant-buttons');
            product.variants.forEach(variant => {
                const btn = document.createElement('button');
                btn.className = 'px-4 py-2 border rounded hover:border-amber-600 hover:text-amber-600 transition';
                btn.textContent = variant.name || variant.sku || `Option ${variant.id}`;
                btn.onclick = () => {
                    // Remove active class from all variant buttons
                    variantButtons.querySelectorAll('button').forEach(b => {
                        b.classList.remove('border-amber-600', 'text-amber-600', 'bg-amber-50');
                    });
                    // Add active class to clicked button
                    btn.classList.add('border-amber-600', 'text-amber-600', 'bg-amber-50');

                    // Update price if variant has different price
                    if (variant.price) {
                        document.getElementById('product-price').textContent = formatPrice(variant.price);
                    }
                };
                variantButtons.appendChild(btn);
            });
        }

        // Update stock status
        if (product.track_inventory && product.stock_quantity <= 0) {
            document.getElementById('stock-status').textContent = 'Out of Stock';
            document.getElementById('stock-status').className = 'text-red-600';
            document.getElementById('add-to-cart').disabled = true;
            document.getElementById('add-to-cart').classList.add('opacity-50', 'cursor-not-allowed');
        }

        // Update description
        document.getElementById('product-description').innerHTML = product.description || '<p>No description available.</p>';

        // Update specifications
        if (product.specifications) {
            const specsContainer = document.getElementById('product-specs');
            const specs = typeof product.specifications === 'string' ?
                JSON.parse(product.specifications) : product.specifications;

            let specsHtml = '<div class="space-y-3">';
            Object.entries(specs).forEach(([key, value]) => {
                specsHtml += `<div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-medium text-gray-700">${key}:</span>
                    <span class="text-gray-600">${value}</span>
                </div>`;
            });
            specsHtml += '</div>';
            specsContainer.innerHTML = specsHtml;
        }

        // Update reviews
        if (product.reviews && product.reviews.length > 0) {
            const reviewsContainer = document.getElementById('product-reviews');
            let reviewsHtml = '<div class="space-y-4">';

            product.reviews.slice(0, 5).forEach(review => {
                const stars = '★'.repeat(review.rating || 5) + '☆'.repeat(5 - (review.rating || 5));
                reviewsHtml += `<div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-amber-500">${stars}</span>
                            <span class="font-medium">${review.customer?.name || 'Anonymous'}</span>
                        </div>
                        <span class="text-sm text-gray-500">${new Date(review.created_at).toLocaleDateString()}</span>
                    </div>
                    <p class="text-gray-700">${review.comment || ''}</p>
                </div>`;
            });

            reviewsHtml += '</div>';
            reviewsContainer.innerHTML = reviewsHtml;
        } else {
            document.getElementById('product-reviews').innerHTML = '<p class="text-gray-500">No reviews yet. Be the first to review this product!</p>';
        }

    } catch (error) {
        console.error('Error loading product:', error);
        document.getElementById('product-title').textContent = 'Error loading product';
        document.getElementById('product-description').innerHTML = '<p class="text-red-500">Failed to load product data.</p>';
    }
}

// Load product data when page loads
document.addEventListener('DOMContentLoaded', loadProductData);
</script>

</body>
</html>
