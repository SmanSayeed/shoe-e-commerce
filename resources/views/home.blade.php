@extends('layouts.layout')

@section('title', 'SSB Leather – 10.10 Super Sale')

@section('content')

  @include('components.hero-slider')
  @include('components.product-sections.recently-sold')
  @include('components.new')

  {{-- 
    @include('components.product-sections.categories')
    @include('components.product-sections.brands')
    @include('components.cookie-consent') 
  --}}

  <script>
    // JavaScript logic for menu toggle, cookie consent, etc.
  </script>
@endsection