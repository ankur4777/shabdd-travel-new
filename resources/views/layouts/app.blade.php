<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @hasSection('meta')
        @yield('meta')
    @else
        <title>SHABDD TRAVEL</title>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <link rel="stylesheet" href="{{ asset('css/destination-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/destination-filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar-breakpoint-fix.css') }}">

    <!-- Premium header styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')

</head>

<body style="overflow-x: hidden;">

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- App JS -->

    <!-- Testimonials CSS/JS -->
    <link rel="stylesheet" href="{{ asset('css/testimonials-section.css') }}">
    <script src="{{ asset('js/testimonials-section.js') }}" defer></script>
    <!-- Destination Filter JS -->
    <script src="{{ asset('js/destination-filter.js') }}" defer></script>
    <!-- Carousel JS -->
    <script src="{{ asset('js/carousel.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    @stack('scripts')


</body>

</html>

