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
@endphp

@section('meta')
    <title>{{ $page['title'] }} | SHABDD Travel</title>
    <meta name="description" content="{{ $page['lead'] }}">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/international-tours.css') }}">
@endpush

@section('content')
    <main class="intl-page intl-support-page intl-support-page--{{ $page['slug'] }}">
        <section class="intl-hero intl-support-hero" style="--intl-hero-image: url('{{ $page['image'] }}')">
            <div class="intl-container intl-hero__inner">
                <div class="intl-hero__copy">
                    <nav class="intl-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}">Home</a>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        <a href="{{ route('international-tours.index') }}">International tours</a>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        <span>{{ $page['title'] }}</span>
                    </nav>

                    <p class="intl-eyebrow">{{ $page['eyebrow'] }}</p>
                    <h1>{{ $page['hero'] }}</h1>
                    <p class="intl-hero__lead">{{ $page['lead'] }}</p>
                    <div class="intl-hero__actions">
                        <a href="{{ route('contact') }}" class="intl-btn intl-btn--light">{{ $page['primary_cta'] }}</a>
                        <a href="{{ route('international-tours.index') }}" class="intl-btn intl-btn--line">View international tours</a>
                    </div>
                </div>

           
            </div>
        </section>

        <section class="intl-intro">
            <div class="intl-container intl-split">
                <div>
                    <p class="intl-eyebrow intl-eyebrow--dark">{{ $page['title'] }}</p>
                    <h2>{{ $page['intro_title'] }}</h2>
                </div>
                <div class="intl-intro__copy">
                    <p>{{ $page['intro_text'] }}</p>
                    <p>Every enquiry is handled with the details that matter: dates, travellers, documents, budget and the comfort level you expect.</p>
                </div>
            </div>
        </section>

        <section class="intl-support-steps">
            <div class="intl-container">
                <div class="intl-heading">
                    <div>
                        <p class="intl-eyebrow intl-eyebrow--dark">Simple process</p>
                        <h2>How it works</h2>
                    </div>
                </div>
                <div class="intl-process__steps intl-process__steps--light">
                    @foreach($page['steps'] as $step)
                        <article>
                            <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="intl-help-strip intl-help-strip--support">
            <div class="intl-container intl-help-grid">
                @foreach($page['features'] as $feature)
                    <article>
                        <i class="bi {{ $feature['icon'] }}"></i>
                        <strong>{{ $feature['title'] }}</strong>
                        <span>{{ $feature['text'] }}</span>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="intl-packages">
            <div class="intl-container">
                <div class="intl-heading">
                    <div>
                        <p class="intl-eyebrow intl-eyebrow--dark">Useful starting points</p>
                        <h2>International packages to consider</h2>
                    </div>
                    <a href="{{ route('international-tours.index') }}">See all international tours <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="intl-package-grid intl-package-grid--compact">
                    @forelse($featuredPackages as $package)
                        <article class="intl-package-card">
                            <a class="intl-package-card__media" href="{{ route('packages.show', $package->slug) }}">
                                <img src="{{ $imageUrl($package->image) }}" alt="{{ $package->title }}" loading="lazy">
                                <span>{{ $package->category ?: 'International' }}</span>
                            </a>
                            <div class="intl-package-card__body">
                                <p><i class="bi bi-geo-alt"></i> {{ collect([$package->city, $package->country])->filter()->unique()->implode(', ') ?: 'International' }}</p>
                                <h3><a href="{{ route('packages.show', $package->slug) }}">{{ $package->title }}</a></h3>
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
                            <p>Set package type to International in the admin panel and suggestions will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="intl-faq">
            <div class="intl-container intl-faq__grid">
                <div>
                    <p class="intl-eyebrow intl-eyebrow--dark">Questions</p>
                    <h2>Common things travellers ask.</h2>
                </div>
                <div class="intl-faq__list">
                    @foreach($page['faq'] as $item)
                        <details {{ $loop->first ? 'open' : '' }}>
                            <summary>{{ $item['q'] }} <i class="bi bi-plus-lg"></i></summary>
                            <p>{{ $item['a'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
