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

    @include('partials.package-listing', [
        'listingKey' => 'family',
        'listingRoute' => route('family-trips'),
        'sectionKicker' => 'Family Trips',
        'sectionTitle' => 'Popular Family Trip Packages',
        'defaultTag' => 'Family',
    ])

@endsection
