<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SSB Leather – 10.10 Super Sale</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    html { font-family: Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Noto Sans, Ubuntu, Cantarell, Helvetica Neue, Arial; }
    .card { box-shadow: 0 1px 2px rgba(16,24,40,.06), 0 1px 3px rgba(16,24,40,.1); }
  </style>
  <!-- Icons (optional) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <meta name="description" content="Premium leather shoes, bags, wallets and belts. 10.10 Super Sale."/>
</head>
<body class="bg-white text-slate-800">
  <!-- Header -->
  @include('components.header')

  <!-- Hero Slider -->
  @include('components.hero-slider')

 {{--  <!-- Category Navigation -->
  @include('components.category-navigation') --}}

  <!-- Product Sections -->
  @include('components.product-sections.recently-sold')
{{--   @include('components.product-sections.categories')
  @include('components.product-sections.brands') --}}

  <!-- Others -->
  @include('components.new')
  <!-- Footer -->
  @include('components.footer')

  <!-- Cookie Consent -->
  {{-- @include('components.cookie-consent') --}}

  <script>
    // JavaScript logic for menu toggle, cookie consent, etc.
  </script>
</body>
</html>

