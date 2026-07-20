@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/religious.css') }}">
@endpush

@section('content')
    <div class="travel-style-page">

    {{-- RELIGIOUS HERO SECTION --}}
    <section class="religious-hero"
        style="background-image: linear-gradient(rgba(255,140,0,0%), rgba(255 140 0 / 20%)), url('{{ asset('images/himachal.jpg') }}');">
        <div class="container">
            <div class="religious-hero-wrapper">

                <div class="religious-content">
                    <div class="hero-badge">
                        <span>🙏 Sacred Journeys</span>
                    </div>

                    <h1 class="religious-title">
                        Religious & Pilgrimage<br>
                        Tours Curated With Care
                    </h1>

                    <p class="religious-desc">
                        Explore spiritual destinations, temple circuits, and pilgrimage packages crafted for meaningful
                        travel.
                    </p>

                    <div class="religious-buttons">
                        <a href="{{ route('packages.index') }}" class="hero-btn-primary">
                            Explore Pilgrimage Packages
                        </a>

                        <a href="{{ route('blog.index') }}" class="hero-btn-outline">
                            Read Travel Guides
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('partials.package-listing', [
        'listingKey' => 'religious',
        'listingRoute' => route('religious'),
        'sectionKicker' => 'Spiritual Journeys',
        'sectionTitle' => 'Popular Pilgrimage Packages',
        'defaultTag' => 'Religious',
    ])

    </div>
@endsection
