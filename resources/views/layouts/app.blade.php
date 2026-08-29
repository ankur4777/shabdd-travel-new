<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- For SEO -->
    <title>Shabdd Travels Domestic &amp; International Tour Packages</title>

    <meta name="description" content="Explore customized domestic and international tour packages with SHABDD Travel, including honeymoon, family, adventure and budget holiday packages, beaches, hill stations, islands, deserts, Dubai holidays, Thailand journeys, Bali, Singapore family trips, Europe, Swiss Alps, Japan, Türkiye, solo & group trips in India, adventure, nature, religious, wildlife, water activities and corporate tours.">

    <link rel="canonical" href="{{ url('/') }}">


    <!-- open graph meta tags -->
    <meta property="og:title" content="Shabdd Travels Domestic &amp; International Tour Packages">
    <meta property="og:description" content="Explore customized domestic and international tour packages with Shabdd Travel.">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('images/header-logo.png') }}">
    <meta property="og:image:alt" content="Shabdd Travels logo">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Shabdd Travels Domestic &amp; International Tour Packages">
    <meta name="twitter:description" content="Explore customized domestic and international tour packages with SHABDD Travel.">
    <meta name="twitter:image" content="{{ asset('images/header-logo.png') }}">
    <meta name="twitter:image:alt" content="Shabdd Travels logo">
    @hasSection('meta')
        @yield('meta')
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

    <script
    src="https://chatbot.shabddtravels.in/widget/loader.js"
    data-widget-key="WGT_JD24PH62NYEKX73M">
</script>


</body>

</html>





