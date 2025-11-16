
<x-app-layout>
  <x-hero-slider :banners="$banners" />
  <x-featured-products :featuredProducts="$featuredProducts" />
  <x-new-arrivals />
  <x-best-items />
  <x-all-products :allProducts="$allProducts" />
  <x-customer-reviews />
  <x-social-banner />
  <x-categories />
  <x-brands-section :brands="$brands" />
</x-app-layout>


