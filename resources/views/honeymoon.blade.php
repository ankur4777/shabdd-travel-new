@extends('layouts.app')

@section('content')

    {{-- HERO SECTION --}}
    <section class="honeymoon-hero">
        <div class="container">
            <div class="honeymoon-hero-wrapper">

                {{-- LEFT CONTENT --}}
                <div class="honeymoon-content">

                    <div class="hero-badge">
                        <span>❤️ Let's travel the world together</span>
                    </div>

                    <h1 class="honeymoon-title">
                        Unforgettable Honeymoon <br>
                        Experiences Start Here
                    </h1>

                    <p class="honeymoon-desc">
                        From dreamy beach escapes to romantic mountain retreats,
                        we create unforgettable honeymoon journeys for couples.
                    </p>

                    <div class="honeymoon-buttons">
                        <a href="{{ route('packages.index') }}" class="hero-btn-primary">
                            Explore Packages
                        </a>

                        <a href="{{ route('blog.index') }}" class="hero-btn-outline">
                            Customize Tour
                        </a>
                    </div>

                </div>


            </div>
        </div>
    </section>

    {{-- FILTER SECTION --}}
<section class="honeymoon-filter-section">
    <div class="container">

        <form method="GET" action="{{ route('honeymoon') }}">

            <div class="honeymoon-filters">

                {{-- SORT --}}
                <select name="sort" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="low_to_high"
                        {{ request('sort') == 'low_to_high' ? 'selected' : '' }}>
                        Price Low to High
                    </option>

                    <option value="high_to_low"
                        {{ request('sort') == 'high_to_low' ? 'selected' : '' }}>
                        Price High to Low
                    </option>

                    <option value="rating"
                        {{ request('sort') == 'rating' ? 'selected' : '' }}>
                        Top Rated
                    </option>
                </select>

                {{-- PACKAGE TYPE --}}
                <select name="type" onchange="this.form.submit()">
                    <option value="">Package Type</option>

                    <option value="Luxury"
                        {{ request('type') == 'Luxury' ? 'selected' : '' }}>
                        Luxury
                    </option>

                    <option value="Budget"
                        {{ request('type') == 'Budget' ? 'selected' : '' }}>
                        Budget
                    </option>

                    <option value="Premium"
                        {{ request('type') == 'Premium' ? 'selected' : '' }}>
                        Premium
                    </option>
                </select>

                {{-- PRICE --}}
                <select name="price" onchange="this.form.submit()">
                    <option value="">Price</option>

                    <option value="50000"
                        {{ request('price') == '50000' ? 'selected' : '' }}>
                        Under ₹50K
                    </option>

                    <option value="100000"
                        {{ request('price') == '100000' ? 'selected' : '' }}>
                        Under ₹1L
                    </option>

                    <option value="200000"
                        {{ request('price') == '200000' ? 'selected' : '' }}>
                        Luxury ₹2L+
                    </option>
                </select>

                {{-- DURATION --}}
                <select name="duration" onchange="this.form.submit()">
                    <option value="">Duration</option>

                    <option value="3-5"
                        {{ request('duration') == '3-5' ? 'selected' : '' }}>
                        3-5 Days
                    </option>

                    <option value="6-8"
                        {{ request('duration') == '6-8' ? 'selected' : '' }}>
                        6-8 Days
                    </option>

                    <option value="9-12"
                        {{ request('duration') == '9-12' ? 'selected' : '' }}>
                        9-12 Days
                    </option>
                </select>

                {{-- FLIGHT --}}
                <select name="flight" onchange="this.form.submit()">
                    <option value="">Flight</option>

                    <option value="included"
                        {{ request('flight') == 'included' ? 'selected' : '' }}>
                        Included
                    </option>

                    <option value="excluded"
                        {{ request('flight') == 'excluded' ? 'selected' : '' }}>
                        Excluded
                    </option>
                </select>

                {{-- THEMES --}}
                <select name="theme" onchange="this.form.submit()">
                    <option value="">Themes</option>

                    <option value="Beach"
                        {{ request('theme') == 'Beach' ? 'selected' : '' }}>
                        Beach
                    </option>

                    <option value="Mountain"
                        {{ request('theme') == 'Mountain' ? 'selected' : '' }}>
                        Mountain
                    </option>

                    <option value="Island"
                        {{ request('theme') == 'Island' ? 'selected' : '' }}>
                        Island
                    </option>
                </select>

                {{-- RESET --}}
                <a href="{{ route('honeymoon') }}" class="reset-filter">
                    Reset All
                </a>

            </div>

        </form>

    </div>
</section>


    <section class="honeymoon-packages-section">
        <div class="container">

            <div class="section-heading text-center">
                <span>Romantic Escapes</span>
                <h2>Popular Honeymoon Packages</h2>
            </div>

            <div class="row g-4">

                @foreach($packages as $package)

                    <div class="col-12 col-md-6 col-lg-6">

                        <div class="honeymoon-package-card">

                            {{-- IMAGE --}}
                            <div class="package-image">

                                <img src="{{ asset($package->image) }}" alt="{{ $package->title }}">

                                {{-- CATEGORY --}}
                                <span class="package-tag">
                                    {{ $package->category ?? 'Honeymoon' }}
                                </span>

                                {{-- DAYS --}}
                                <span class="package-duration">
                                    {{ $package->days }}
                                </span>

                            </div>

                            {{-- CONTENT --}}
                            <div class="package-content">

                                <h3>
                                    {{ $package->title }}
                                </h3>

                                {{-- BADGES --}}
                                <div class="package-badges">

                                    <span>
                                        {{ $package->days }}
                                    </span>

                                    <span>
                                        ⭐ {{ $package->rating }}
                                    </span>

                                </div>

                                {{-- FEATURES --}}
                                <ul class="package-features">

                                    @if($package->feature_1)
                                        <li>{{ $package->feature_1 }}</li>
                                    @endif

                                    @if($package->feature_2)
                                        <li>{{ $package->feature_2 }}</li>
                                    @endif

                                    @if($package->feature_3)
                                        <li>{{ $package->feature_3 }}</li>
                                    @endif

                                </ul>

                                {{-- PRICE --}}
                                <div class="package-footer">

                                    <div class="package-price">

                                        @if($package->old_price)
                                            <del>
                                                ₹{{ number_format($package->old_price) }}
                                            </del>
                                        @endif

                                        <h4>
                                            ₹{{ number_format($package->price) }}
                                        </h4>

                                        <p>
                                            Per couple
                                        </p>

                                    </div>

                                    {{-- BUTTON --}}
                                    <a href="#" class="package-btn">

                                        View Details

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>
    </section>

@endsection