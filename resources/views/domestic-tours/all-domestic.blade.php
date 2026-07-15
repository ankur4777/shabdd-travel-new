@extends('layouts.app')

@php
    $imageUrl = static function (?string $path, string $fallback = 'images/couple-bg.jpg'): string {
        if (blank($path)) {
            return asset($fallback);
        }

        return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : asset('storage/' . ltrim($path, '/'));
    };

    $featuredDestinations = $destinations->take(4);
    $heroDestination = $destinations->first();
    $heroImage = $imageUrl($heroDestination?->hero_image ?: $heroDestination?->image_url, 'images/himachal.jpg');
    $startingPrice = $packages->where('price', '>', 0)->min('price');
    $destinationNames = $destinations->pluck('name')->filter()->unique()->take(3);
    $travelStyles = $packages->pluck('travel_style')->filter()->unique()->count();
@endphp

@section('meta')
    <title>India Domestic Tour Packages | SHABDD Travel</title>
    <meta name="description"
        content="Explore handpicked domestic destinations and India tour packages managed by SHABDD Travel.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/all-domestic.css') }}">
@endpush

@section('content')
    <main class="domestic-page">
        <section class="domestic-hero" style="--domestic-hero-image: url('{{ $heroImage }}')">
            <div class="domestic-container domestic-hero__inner">
                <div class="domestic-hero__copy">
                    <nav class="domestic-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}">Home</a>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        <span>Domestic tours</span>
                    </nav>

                    <p class="domestic-eyebrow">Journeys across India</p>
                    <h1>Go farther without leaving home.</h1>
                    <p class="domestic-hero__lead">
                        Hill roads, temple towns, quiet backwaters and food worth travelling for.
                        Pick a place; we will help shape the days around it.
                    </p>

                    <div class="domestic-hero__actions">
                        <a href="#domesticPackages" class="domestic-btn domestic-btn--light">
                            Browse packages <i class="bi bi-arrow-down"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="domestic-btn domestic-btn--line">
                            Plan a custom trip
                        </a>
                    </div>

                    @if($destinationNames->isNotEmpty())
                        <div class="domestic-hero__places">
                            <span>Popular now</span>
                            @foreach($destinationNames as $name)
                                <a href="#domesticDestinations">{{ $name }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <aside class="domestic-hero__note">
                    <span class="domestic-hero__note-kicker">A quick starting point</span>
                    <strong>{{ $packages->count() }} trips, each open to a little tinkering.</strong>
                    <p>Change the pace, hotel category or number of nights with our travel team.</p>
                    <div class="domestic-hero__note-stats">
                        <div><b>{{ $destinations->count() }}</b><span>destinations</span></div>
                        <div><b>{{ $travelStyles ?: 1 }}</b><span>travel styles</span></div>
                        <div><b>{{ $startingPrice ? '₹' . number_format($startingPrice) : 'Ask us' }}</b><span>starting from</span></div>
                    </div>
                </aside>
            </div>
        </section>

        <section class="domestic-intro">
            <div class="domestic-container domestic-intro__grid">
                <div>
                    <p class="domestic-eyebrow domestic-eyebrow--dark">India, one journey at a time</p>
                    <h2>Not a checklist. A holiday that fits.</h2>
                </div>
                <div class="domestic-intro__copy">
                    <p>
                        India changes every few hundred kilometres. The weather, the breakfast, the language
                        and even the rhythm of the day can feel new. That is exactly why a domestic trip deserves
                        more than a standard itinerary.
                    </p>
                    <p>
                        Start with one of our ready plans below, then tell us what matters: slower mornings,
                        better views, family-friendly stays or more time outdoors.
                    </p>
                </div>
            </div>
        </section>

        <section class="domestic-destinations" id="domesticDestinations">
            <div class="domestic-container">
                <div class="domestic-heading">
                    <div>
                        <p class="domestic-eyebrow domestic-eyebrow--dark">Where to next?</p>
                        <h2>Domestic destinations</h2>
                    </div>
                    <a href="{{ route('destinations.index') }}">See all destinations <i class="bi bi-arrow-right"></i></a>
                </div>

                @if($featuredDestinations->isNotEmpty())
                    <div class="domestic-destination-grid">
                        @foreach($featuredDestinations as $destination)
                            <article class="domestic-destination-card {{ $loop->first ? 'domestic-destination-card--large' : '' }}">
                                <img src="{{ $imageUrl($destination->image_url ?: $destination->hero_image) }}"
                                    alt="{{ $destination->name }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                                <div class="domestic-destination-card__shade"></div>
                                <div class="domestic-destination-card__top">
                                    @if($destination->category)
                                        <span>{{ $destination->category }}</span>
                                    @endif
                                    @if($destination->rating)
                                        <span><i class="bi bi-star-fill"></i> {{ number_format((float) $destination->rating, 1) }}</span>
                                    @endif
                                </div>
                                <div class="domestic-destination-card__body">
                                    <p>{{ $destination->country ?: 'India' }}</p>
                                    <h3>{{ $destination->name }}</h3>
                                    <div>
                                        <span>
                                            {{ $destination->best_season ? 'Best: ' . $destination->best_season : 'Plan it your way' }}
                                        </span>
                                        <strong>
                                            {{ $destination->price_from ? 'From ₹' . number_format($destination->price_from) : 'Explore' }}
                                        </strong>
                                    </div>
                                </div>
                                <a href="{{ route('destinations.show', $destination) }}"
                                    aria-label="Explore {{ $destination->name }}"></a>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="domestic-empty">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Destinations are being prepared</h3>
                        <p>Add active India destinations in the admin panel and they will appear here.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="domestic-moods">
            <div class="domestic-container">
                <div class="domestic-heading domestic-heading--center">
                    <div>
                        <p class="domestic-eyebrow domestic-eyebrow--dark">Choose by mood</p>
                        <h2>What kind of break do you need?</h2>
                    </div>
                </div>
                <div class="domestic-moods__grid">
                    <a href="{{ route('packages.index', ['travel_style' => 'family']) }}">
                        <i class="bi bi-people"></i><strong>Family time</strong><span>Easy days and room for everyone</span>
                    </a>
                    <a href="{{ route('packages.index', ['travel_style' => 'honeymoon']) }}">
                        <i class="bi bi-suit-heart"></i><strong>Two of you</strong><span>Thoughtful stays and slower plans</span>
                    </a>
                    <a href="{{ route('packages.index', ['travel_style' => 'adventure']) }}">
                        <i class="bi bi-compass"></i><strong>Outdoors</strong><span>Trails, roads and early starts</span>
                    </a>
                    <a href="{{ route('packages.index', ['travel_style' => 'pilgrimage']) }}">
                        <i class="bi bi-sunrise"></i><strong>Spiritual</strong><span>Meaningful places, comfortably paced</span>
                    </a>
                    <a href="{{ route('packages.index', ['travel_style' => 'corporate tour']) }}">
                        <i class="bi bi-building"></i><strong>Corporate Tour</strong><span>Team outings, offsites and business travel</span>
                    </a>
                </div>
            </div>
        </section>

        <section class="domestic-packages" id="domesticPackages">
            <div class="domestic-container">
                <div class="domestic-heading">
                    <div>
                        <p class="domestic-eyebrow domestic-eyebrow--dark">Ready itineraries</p>
                        <h2>Domestic tour packages</h2>
                        <p>Live packages from the admin panel, ready to book or personalise.</p>
                    </div>
                    <a href="{{ route('packages.index') }}">View all packages <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="domestic-package-grid">
                    @forelse($packages as $package)
                        <article class="domestic-package-card">
                            <a class="domestic-package-card__media" href="{{ route('packages.show', $package->slug) }}">
                                <img src="{{ $imageUrl($package->image) }}" alt="{{ $package->title }}" loading="lazy">
                                <span class="domestic-package-card__type">
                                    {{ $package->travel_style ? ucfirst($package->travel_style) : ($package->category ?: 'India tour') }}
                                </span>
                                <span class="domestic-package-card__rating">
                                    <i class="bi bi-star-fill"></i>
                                    {{ $package->rating ? number_format((float) $package->rating, 1) : 'New' }}
                                </span>
                            </a>
                            <div class="domestic-package-card__body">
                                <p class="domestic-package-card__location">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ collect([$package->city, $package->state])->filter()->unique()->implode(', ') ?: ($package->country ?: 'India') }}
                                </p>
                                <h3><a href="{{ route('packages.show', $package->slug) }}">{{ $package->title }}</a></h3>
                                <div class="domestic-package-card__meta">
                                    <span><i class="bi bi-calendar3"></i> {{ $package->duration_text ?: (($package->days ?: 'Flexible') . ($package->days ? ' days' : '')) }}</span>
                                    @if($package->flight)
                                        <span><i class="bi bi-airplane"></i> Flight {{ $package->flight }}</span>
                                    @endif
                                </div>
                                @if($package->feature_1 || $package->feature_2)
                                    <ul>
                                        @foreach(collect([$package->feature_1, $package->feature_2])->filter()->take(2) as $feature)
                                            <li><i class="bi bi-check2"></i> {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="domestic-package-card__footer">
                                    <div>
                                        <span>Starting from</span>
                                        @if($package->old_price && $package->old_price > $package->price)
                                            <del>₹{{ number_format($package->old_price) }}</del>
                                        @endif
                                        <strong>₹{{ number_format($package->price) }}</strong>
                                    </div>
                                    <a href="{{ route('packages.show', $package->slug) }}" aria-label="View {{ $package->title }}">
                                        <i class="bi bi-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="domestic-empty domestic-empty--wide">
                            <i class="bi bi-luggage"></i>
                            <h3>No domestic packages are live yet</h3>
                            <p>Add an India package in the admin panel and it will show here automatically.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="domestic-seasons">
            <div class="domestic-container domestic-seasons__layout">
                <div class="domestic-seasons__copy">
                    <p class="domestic-eyebrow">The calendar matters</p>
                    <h2>Right place, right season.</h2>
                    <p>India has a good trip for every month. The trick is choosing the landscape that is at its best.</p>
                    <a href="{{ route('contact') }}" class="domestic-btn domestic-btn--light">Ask what works now</a>
                </div>
                <div class="domestic-seasons__cards">
                    <article><span>Mar—Jun</span><i class="bi bi-brightness-high"></i><h3>Summer hills</h3><p>Long daylight, mountain drives and cooler evenings.</p></article>
                    <article><span>Jul—Sep</span><i class="bi bi-cloud-rain"></i><h3>Monsoon green</h3><p>Waterfalls, quiet stays and freshly washed landscapes.</p></article>
                    <article><span>Oct—Feb</span><i class="bi bi-snow"></i><h3>Winter sun</h3><p>Desert trails, southern coasts and crisp northern air.</p></article>
                </div>
            </div>
        </section>

        <section class="domestic-planning">
            <div class="domestic-container domestic-planning__inner">
                <div>
                    <p class="domestic-eyebrow domestic-eyebrow--dark">Need a second opinion?</p>
                    <h2>Tell us your dates. We will narrow the map.</h2>
                </div>
                <div>
                    <p>A short conversation can save hours of comparing tabs. Share your group size, budget and preferred pace.</p>
                    <a href="{{ route('contact') }}" class="domestic-btn domestic-btn--dark">Start planning <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </section>
    </main>
@endsection
