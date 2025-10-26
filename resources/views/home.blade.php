@extends('layouts.layout')

@section('title', 'SSB Leather – 10.10 Super Sale')

@section('content')

  <x-hero-slider />
  <x-recently-sold />
  <x-new-arrivals />
  <x-best-items />
  <x-special-items />
  <x-customer-reviews />
  <x-categories />
  <x-brands />

  {{--
    @include('components.cookie-consent')
  --}}

  <script>
    // JavaScript logic for menu toggle, cookie consent, etc.
  </script>
@endsection
