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

    $heroDestination = $destinations->first();
    $heroImage = $imageUrl($heroDestination?->hero_image ?: $heroDestination?->image_url, 'images/dubai.jpg');
    $startingPrice = $packages->where('price', '>', 0)->min('price');
    $destinationNames = $destinations->pluck('name')->filter()->take(4);
@endphp

@section('meta')
    <title>International Tour Packages | SHABDD Travel</title>
    <meta name="description" content="Explore international destinations and popular international packages from SHABDD Travel.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/international-tours.css') }}">
@endpush

@section('content')
    <main class="intl-page">
        <section class="intl-hero" style="--intl-hero-image: url('{{ $heroImage }}')">
            <div class="intl-container intl-hero__inner">
                <div class="intl-hero__copy">
                    <nav class="intl-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        <span>International tours</span>
                    </nav>

                    <p class="intl-eyebrow">International holidays</p>
                    <h1>See the world with the planning already handled.</h1>
                    <p class="intl-hero__lead">
                        Browse international destinations added from the admin panel and match them with popular
                        packages built for families, couples, friends and premium travellers.
                    </p>

                    <div class="intl-hero__actions">
                        <a href="#intlDestinations" class="intl-btn intl-btn--light">Explore destinations <i class="bi bi-arrow-down"></i></a>
                        <a href="{{ route('international-tours.visa-assistance') }}" class="intl-btn intl-btn--line">Visa assistance</a>
                    </div>

                    @if($destinationNames->isNotEmpty())
                        <div class="intl-hero__chips">
                            <span>Popular now</span>
                            @foreach($destinationNames as $name)
                                <a href="#intlDestinations">{{ $name }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>

         
            </div>
        </section>

        <section class="intl-intro">
            <div class="intl-container intl-split">
                <div>
                    <p class="intl-eyebrow intl-eyebrow--dark">Before the boarding pass</p>
                    <h2>International travel needs cleaner planning.</h2>
                </div>
                <div class="intl-intro__copy">
                    <p>Flights, visas, hotel locations, transfers and activity timing all need to work together. A good international holiday is not just a list of places. It is a route with fewer surprises.</p>
                    <p>Start with the destinations below, then use the support pages for visas, group travel and scheduled departures.</p>
                </div>
            </div>
        </section>

        <section class="intl-destinations" id="intlDestinations">
            <div class="intl-container">
                <div class="intl-heading">
                    <div>
                        <p class="intl-eyebrow intl-eyebrow--dark">Where to fly next?</p>
                        <h2>International destinations</h2>
                    </div>
                    <a href="{{ route('destinations.index') }}">All destinations <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="intl-destination-grid">
                    @forelse($destinations as $destination)
                        <article class="intl-destination-card">
                            <img src="{{ $imageUrl($destination->image_url ?: $destination->hero_image) }}" alt="{{ $destination->name }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                            <div class="intl-destination-card__shade"></div>
                            <div class="intl-destination-card__top">
                                <span>{{ $destination->country ?: 'International' }}</span>
                                @if($destination->rating)
                                    <span><i class="bi bi-star-fill"></i> {{ number_format((float) $destination->rating, 1) }}</span>
                                @endif
                            </div>
                            <div class="intl-destination-card__body">
                                <p>{{ $destination->category ?: 'International tour' }}</p>
                                <h3>{{ $destination->name }}</h3>
                                <div>
                                    <span>{{ $destination->best_season ?: 'Season guidance available' }}</span>
                                    <strong>{{ $destination->price_from ? 'From Rs ' . number_format($destination->price_from) : 'Explore' }}</strong>
                                </div>
                            </div>
                            <a href="{{ route('destinations.show', $destination) }}" aria-label="Explore {{ $destination->name }}"></a>
                        </article>
                    @empty
                        <div class="intl-empty">
                            <i class="bi bi-globe2"></i>
                            <h3>No international destinations yet</h3>
                            <p>Mark destinations as International in the admin panel and they will show here automatically.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="intl-help-strip">
            <div class="intl-container intl-help-grid">
                <a href="{{ route('international-tours.visa-assistance') }}">
                    <i class="bi bi-passport"></i><strong>Visa Assistance</strong><span>Documents, timelines and submission guidance.</span>
                </a>
                <a href="{{ route('international-tours.group-departures') }}">
                    <i class="bi bi-people"></i><strong>Group Departures</strong><span>Private and shared trips for larger groups.</span>
                </a>
                <a href="{{ route('international-tours.fixed-departure-dates') }}">
                    <i class="bi bi-calendar2-week"></i><strong>Fixed Departure Dates</strong><span>Scheduled batches with clearer planning.</span>
                </a>
            </div>
        </section>

        <section class="intl-packages" id="intlPackages">
            <div class="intl-container">
                <div class="intl-heading">
                    <div>
                        <p class="intl-eyebrow intl-eyebrow--dark">Popular international packages</p>
                        <h2>Packages marked International</h2>
                        <p>Only packages with International type in the admin panel appear here.</p>
                    </div>
                    <a href="{{ route('packages.index') }}">View all packages <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="intl-package-grid">
                    @forelse($popularPackages as $package)
                        <article class="intl-package-card">
                            <a class="intl-package-card__media" href="{{ route('packages.show', $package->slug) }}">
                                <img src="{{ $imageUrl($package->image) }}" alt="{{ $package->title }}" loading="lazy">
                                <span>{{ $package->category ?: 'International' }}</span>
                            </a>
                            <div class="intl-package-card__body">
                                <p><i class="bi bi-geo-alt"></i> {{ collect([$package->city, $package->country])->filter()->unique()->implode(', ') ?: 'International' }}</p>
                                <h3><a href="{{ route('packages.show', $package->slug) }}">{{ $package->title }}</a></h3>
                                <div class="intl-package-card__meta">
                                    <span><i class="bi bi-calendar3"></i> {{ $package->duration_text ?: (($package->days ?: 'Flexible') . ($package->days ? ' days' : '')) }}</span>
                                    <span><i class="bi bi-star-fill"></i> {{ $package->rating ? number_format((float) $package->rating, 1) : 'New' }}</span>
                                </div>
                                @if($package->feature_1 || $package->feature_2)
                                    <ul>
                                        @foreach(collect([$package->feature_1, $package->feature_2])->filter()->take(2) as $feature)
                                            <li><i class="bi bi-check2"></i> {{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="intl-package-card__footer">
                                    <div>
                                        <span>Starting from</span>
                                        <strong>Rs {{ number_format((int) $package->price) }}</strong>
                                    </div>
                                    <a href="{{ route('packages.show', $package->slug) }}"><i class="bi bi-arrow-up-right"></i></a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="intl-empty intl-empty--wide">
                            <i class="bi bi-luggage"></i>
                            <h3>No international packages yet</h3>
                            <p>Set package type to International and category to Popular in the admin panel to feature it here.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="intl-process">
            <div class="intl-container intl-process__inner">
                <div>
                    <p class="intl-eyebrow">How we plan it</p>
                    <h2>From idea to immigration counter.</h2>
                </div>
                <div class="intl-process__steps">
                    <article><span>01</span><h3>Choose the route</h3><p>Pick a destination or package and share your travel month.</p></article>
                    <article><span>02</span><h3>Check documents</h3><p>Confirm passport validity, visa needs and traveller details early.</p></article>
                    <article><span>03</span><h3>Lock the trip</h3><p>Finalize flights, stays, transfers and on-ground experiences.</p></article>
                </div>
            </div>
        </section>
    </main>
@endsection
