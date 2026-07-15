@extends('layouts.app')

@section('meta')
    <title>Traveller Reviews | SHABDD Travel</title>
    <meta name="description" content="Read genuine traveller reviews and experiences shared with SHABDD Travel.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endpush

@section('content')
    <main class="reviews-page">
        <div class="reviews-shell">
            <header class="reviews-hero">
                <span class="reviews-kicker">Traveller stories</span>
                <h1>What Our <span>Travellers Say</span></h1>
                <p>Real journeys. Real memories. Reviews added through our admin panel.</p>
            </header>

            <form class="reviews-filters" method="GET" action="{{ route('reviews.index') }}">
                <a class="reviews-filter reviews-filter--all {{ !$selectedRating && !$selectedSource ? 'is-active' : '' }}"
                    href="{{ route('reviews.index') }}">
                    <i class="bi bi-grid"></i> All Reviews
                </a>

                <label class="reviews-filter">
                    <i class="bi bi-star-fill"></i>
                    <span class="visually-hidden">Filter by rating</span>
                    <select name="rating" onchange="this.form.submit()">
                        <option value="">All ratings</option>
                        @foreach(range(5, 1) as $rating)
                            <option value="{{ $rating }}" @selected($selectedRating === $rating)>
                                {{ $rating }} Star{{ $rating === 1 ? '' : 's' }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="reviews-filter">
                    <i class="bi bi-geo-alt"></i>
                    <span class="visually-hidden">Filter by trip</span>
                    <select name="source" onchange="this.form.submit()">
                        <option value="">All trips</option>
                        @foreach($sources as $source)
                            <option value="{{ $source['value'] }}" @selected($selectedSource === $source['value'])>
                                {{ $source['label'] }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="reviews-filter reviews-filter--sort">
                    <i class="bi bi-sort-down"></i>
                    <span class="visually-hidden">Sort reviews</span>
                    <select name="sort" onchange="this.form.submit()">
                        <option value="newest" @selected($selectedSort === 'newest')>Newest first</option>
                        <option value="highest" @selected($selectedSort === 'highest')>Highest rated</option>
                        <option value="lowest" @selected($selectedSort === 'lowest')>Lowest rated</option>
                    </select>
                </label>
            </form>

            <div class="reviews-layout">
                <aside class="reviews-summary">
                    <p class="reviews-summary-label">Overall Rating</p>
                    <strong class="reviews-score">{{ number_format($averageRating, 1) }}</strong>
                    <div class="reviews-stars" aria-label="{{ number_format($averageRating, 1) }} out of 5 stars">
                        @for($star = 1; $star <= 5; $star++)
                            <i class="bi {{ $star <= round($averageRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                    <p class="reviews-count">Based on {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</p>

                    <div class="reviews-breakdown">
                        @foreach(range(5, 1) as $rating)
                            @php
                                $count = $ratingCounts->get($rating, 0);
                                $percentage = $reviewCount > 0 ? ($count / $reviewCount) * 100 : 0;
                            @endphp
                            <div class="reviews-breakdown-row">
                                <span>{{ $rating }} <i class="bi bi-star-fill"></i></span>
                                <div><span style="width: {{ $percentage }}%"></span></div>
                                <small>({{ $count }})</small>
                            </div>
                        @endforeach
                    </div>

                    <div class="reviews-promise">
                        <i class="bi bi-quote"></i>
                        <p>Every journey has a story worth sharing.</p>
                        <strong>Thank you for trusting SHABDD Travel.</strong>
                    </div>

                    <p class="reviews-verified"><i class="bi bi-patch-check-fill"></i> Admin-published reviews</p>
                </aside>

                <section class="reviews-results" aria-label="Traveller reviews">
                    @forelse($paginatedReviews as $review)
                        @php
                            $initials = collect(preg_split('/\s+/', $review['name']))
                                ->filter()
                                ->take(2)
                                ->map(fn ($part) => Str::upper(Str::substr($part, 0, 1)))
                                ->implode('');
                        @endphp
                        <article class="review-card">
                            <div class="review-avatar" aria-hidden="true">{{ $initials ?: 'ST' }}</div>
                            <div class="review-content">
                                <div class="review-heading">
                                    <div>
                                        <h2>{{ $review['name'] }}</h2>
                                        <div class="review-card-stars" aria-label="{{ $review['rating'] }} out of 5 stars">
                                            @for($star = 1; $star <= 5; $star++)
                                                <i class="bi {{ $star <= $review['rating'] ? 'bi-star-fill' : 'bi-star' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <i class="bi bi-quote review-quote"></i>
                                </div>

                                <span class="review-trip"><i class="bi bi-airplane"></i> {{ $review['source_label'] }}</span>
                                <p>{{ $review['review'] }}</p>
                                @if(!empty($review['images']))
                                    <div class="review-gallery review-gallery--{{ min(count($review['images']), 5) }}">
                                        @foreach($review['images'] as $imageIndex => $image)
                                            <a href="{{ $image }}" target="_blank" rel="noopener"
                                                aria-label="Open image {{ $imageIndex + 1 }} from {{ $review['name'] }}'s review">
                                                <img src="{{ $image }}"
                                                    alt="Travel photo {{ $imageIndex + 1 }} shared by {{ $review['name'] }}"
                                                    loading="lazy">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <footer>
                                    @if($review['location'])
                                        <span><i class="bi bi-geo-alt"></i> {{ $review['location'] }}</span>
                                    @endif
                                    @if($review['updated_at'])
                                        <time datetime="{{ $review['updated_at']->toDateString() }}">
                                            {{ $review['updated_at']->format('M d, Y') }}
                                        </time>
                                    @endif
                                </footer>
                            </div>
                        </article>
                    @empty
                        <div class="reviews-empty">
                            <i class="bi bi-chat-heart"></i>
                            <h2>No reviews match these filters</h2>
                            <p>Try another rating or trip.</p>
                            <a href="{{ route('reviews.index') }}">Clear filters</a>
                        </div>
                    @endforelse

                    @if($paginatedReviews->hasPages())
                        <div class="reviews-pagination">{{ $paginatedReviews->links() }}</div>
                    @endif
                </section>
            </div>

            @if($reviewCount > 0)
                <div class="reviews-trust-bar">
                    <div><i class="bi bi-heart-fill"></i><span><strong>Trusted by happy travellers</strong>Journeys planned with care</span></div>
                    <div><strong>{{ number_format($averageRating, 1) }}/5</strong><span>Average rating</span></div>
                    <div><strong>{{ $reviewCount }}+</strong><span>Traveller stories</span></div>
                    <div><i class="bi bi-award"></i><strong>100%</strong><span>Admin published</span></div>
                </div>
            @endif
        </div>
    </main>
@endsection
