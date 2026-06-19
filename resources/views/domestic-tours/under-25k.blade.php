@extends('layouts.app')

@section('meta')
    <title>Domestic Tours Under ₹25,000 | SHABDD Travel</title>
    <meta name="description"
        content="Explore India under ₹25,000 with dynamic domestic tour packages, destination filters, FAQs, testimonials, and budget-friendly getaways across top Indian destinations.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/under-25k.css') }}">
    <link rel="stylesheet" href="{{ asset('css/beach-escapes.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@php
    use Illuminate\Support\Str;

    $testimonials = [
        [
            'name' => 'Aarti Sharma',
            'destination' => 'Kerala',
            'rating' => 5,
            'image' => asset('images/user1.jpg'),
            'review' => 'The package felt far more premium than the price. Transfers were smooth, the hotel was comfortable, and the itinerary was perfect for our family.',
        ],
        [
            'name' => 'Rohan Mehta',
            'destination' => 'Manali',
            'rating' => 5,
            'image' => asset('images/user2.jpg'),
            'review' => 'Exactly what we wanted for a quick mountain escape. Great value, clear inclusions, and no stress during the trip.',
        ],
        [
            'name' => 'Sneha Verma',
            'destination' => 'Goa',
            'rating' => 5,
            'image' => asset('images/user1.jpg'),
            'review' => 'Budget-friendly without feeling basic. The team helped us pick the right package and the stay exceeded our expectations.',
        ],
    ];

    $faqs = [
        [
            'question' => "What's included in the package?",
            'answer' => 'Most packages include hotel stays, sightseeing, and route-based transfers. Exact inclusions are listed on each package detail page before booking.',
        ],
        [
            'question' => 'Are flights included?',
            'answer' => 'Flights are not automatically included in every under ₹25,000 package. Check the package detail page or talk to our team for flight-inclusive custom quotes.',
        ],
        [
            'question' => 'Can I customize the itinerary?',
            'answer' => 'Yes. You can shortlist a package and then request hotel upgrades, extra nights, or sightseeing changes based on your travel plan.',
        ],
        [
            'question' => 'What is the cancellation policy?',
            'answer' => 'Cancellation terms depend on the package, hotel, and travel dates. Our team shares the applicable policy before confirmation.',
        ],
        [
            'question' => 'Are these packages suitable for families?',
            'answer' => 'Yes. Many options are ideal for couples, families, and small groups, especially packages with balanced travel time and comfortable stays.',
        ],
    ];

    $activeFilters = collect([
        $selectedDestination ? 'Destination: ' . $selectedDestination : null,
        $selectedDuration
        ? 'Duration: ' . match ($selectedDuration) {
            '2-4' => '2 to 4 days',
            '4-6' => '4 to 6 days',
            '6-8' => '6 to 8 days',
            '8+' => '8+ days',
            default => $selectedDuration,
        }
        : null,
        $selectedMonth ? 'Month: ' . Str::headline($selectedMonth) : null,
        $selectedSort && $selectedSort !== 'popularity'
        ? 'Sort: ' . match ($selectedSort) {
            'price_low' => 'Price Low to High',
            'duration' => 'Duration',
            default => 'Popularity',
        }
        : null,
    ])->filter()->values();
@endphp

@section('content')
    <main class="budget25-page">

        <section class="budget25-hero">
            <div class="budget25-hero__media" aria-hidden="true"></div>
            <div class="budget25-hero__veil" aria-hidden="true"></div>
            <div class="container budget25-hero__container">
                <div class="budget25-hero__content">
                    <span class="budget25-kicker">Budget domestic getaways</span>
                    <h1>Explore India Under ₹25,000</h1>
                    <p>Handpicked budget-friendly tours for unforgettable experiences.</p>
                </div>
            </div>
        </section>

        <section class="budget25-section budget25-section--packages" id="packages">
            <div class="container">
                <div class="budget25-section__head budget25-section__head--split">
                    <div>
                        <span class="budget25-eyebrow">Featured packages</span>
                        <h2>Affordable domestic tours from the admin panel</h2>
                        <p>{{ $packageCount }} package{{ $packageCount === 1 ? '' : 's' }} matched your current filters.</p>
                    </div>

                    <form method="GET" action="{{ route('under-25k') }}" class="budget25-sort">
                        <input type="hidden" name="destination" value="{{ $selectedDestination }}">
                        <input type="hidden" name="duration" value="{{ $selectedDuration }}">
                        <input type="hidden" name="month" value="{{ $selectedMonth }}">
                        <label for="budget25Sort">Sort by</label>
                        <select id="budget25Sort" name="sort" onchange="this.form.submit()">
                            <option value="popularity" {{ $selectedSort === 'popularity' ? 'selected' : '' }}>Popularity
                            </option>
                            <option value="price_low" {{ $selectedSort === 'price_low' ? 'selected' : '' }}>Price Low to High
                            </option>
                            <option value="duration" {{ $selectedSort === 'duration' ? 'selected' : '' }}>Duration</option>
                        </select>
                    </form>
                </div>

                @if($activeFilters->isNotEmpty())
                    <div class="budget25-active-filters" aria-label="Active filters">
                        @foreach($activeFilters as $filter)
                            <span>{{ $filter }}</span>
                        @endforeach
                        <a href="{{ route('under-25k') }}">Clear all</a>
                    </div>
                @endif

                @if($packages->isEmpty())
                    <div class="budget25-empty">
                        <h3>No packages found for this combination</h3>
                        <p>Try changing the destination, duration, or month filter to reveal more budget-friendly domestic
                            tours.</p>
                    </div>
                @else
                    <div class="budget25-grid">
                        @foreach($packages as $package)
                            @php
                                $packageImage = blank($package->image)
                                    ? asset('images/couple-bg.jpg')
                                    : (Str::startsWith($package->image, ['http://', 'https://'])
                                        ? $package->image
                                        : asset('storage/' . ltrim($package->image, '/')));
                                $packageDuration = $package->duration_text ?: ($package->days ? $package->days . 'D' : 'Flexible');
                                $packageLocation = collect([$package->city, $package->state, $package->country])->filter()->implode(', ');
                                $packageHighlights = collect([$package->feature_1, $package->feature_2, $package->feature_3])->filter()->take(3);
                                $packageDescription = $package->description
                                    ? Str::limit(strip_tags($package->description), 120)
                                    : 'Curated stays, seamless transfers, and practical sightseeing for value-first domestic travel.';
                            @endphp

                            <article class="budget25-card">
                                <a href="{{ route('packages.show', $package->slug) }}" class="budget25-card__media">
                                    <img src="{{ $packageImage }}" alt="{{ $package->title }}" loading="lazy">
                                    <span class="budget25-card__price">From ₹{{ number_format((int) $package->price) }}</span>
                                </a>

                                <div class="budget25-card__body">
                                    <div class="budget25-card__meta">
                                        <span><i class="bi bi-geo-alt"></i> {{ $packageLocation ?: 'India' }}</span>
                                        <span><i class="bi bi-calendar3"></i> {{ $packageDuration }}</span>
                                    </div>

                                    <div class="budget25-card__heading">
                                        <h3>{{ $package->title }}</h3>
                                        <div class="budget25-rating">
                                            <i class="bi bi-star-fill"></i>
                                            <span>{{ $package->rating ? number_format((float) $package->rating, 1) : '4.5' }}</span>
                                        </div>
                                    </div>

                                    <p>{{ $packageDescription }}</p>

                                    @if($packageHighlights->isNotEmpty())
                                        <ul class="budget25-highlights">
                                            @foreach($packageHighlights as $highlight)
                                                <li>{{ $highlight }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <a href="{{ route('packages.show', $package->slug) }}" class="budget25-btn budget25-btn--ghost">
                                        View Details
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        <section class="beach-banner-slider" aria-label="Featured beach banner">
            <div class="container">
                <div class="beach-banner-frame">
                    <div class="swiper beach-banner-swiper" data-beach-banner-swiper>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <article class="beach-banner-slide"
                                    style="--beach-banner-image: url('{{ asset('images/kerala.avif') }}');">
                                    <div class="beach-banner-slide__overlay"></div>
                                    <div class="beach-banner-slide__content">
                                        <span class="beach-banner-slide__eyebrow">
                                            <i class="bi bi-sunrise-fill" aria-hidden="true"></i> Coastal spotlight
                                        </span>
                                        <h2>Beach breaks with a premium holiday feel</h2>
                                        <p>Use this space to highlight your strongest beach offer before visitors move into
                                            the package slider.</p>
                                    </div>
                                </article>
                            </div>
                            <div class="swiper-slide">
                                <article class="beach-banner-slide"
                                    style="--beach-banner-image: url('{{ asset('images/contact-us-bg.jpg') }}');">
                                    <div class="beach-banner-slide__overlay"></div>
                                    <div class="beach-banner-slide__content">
                                        <span class="beach-banner-slide__eyebrow">
                                            <i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Island favorite
                                        </span>
                                        <h2>Go from planning to sea breeze in one click</h2>
                                        <p>Feature Andaman, Lakshadweep, or Goa in a large visual banner that breaks up the
                                            page and keeps momentum high.</p>
                                    </div>
                                </article>
                            </div>
                            <div class="swiper-slide">
                                <article class="beach-banner-slide"
                                    style="--beach-banner-image: url('{{ asset('images/world-map.avif') }}');">
                                    <div class="beach-banner-slide__overlay"></div>
                                    <div class="beach-banner-slide__content">
                                        <span class="beach-banner-slide__eyebrow">
                                            <i class="bi bi-stars" aria-hidden="true"></i> Curated highlights
                                        </span>
                                        <h2>Use a bold transition section to keep the page moving</h2>
                                        <p>This banner works as a visual bridge between your filter results and the package
                                            cards below.</p>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="beach-banner-swiper__btn beach-banner-swiper__btn--prev"
                        aria-label="Previous beach banner">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <button type="button" class="beach-banner-swiper__btn beach-banner-swiper__btn--next"
                        aria-label="Next beach banner">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                <div class="beach-banner-swiper__pagination"></div>
            </div>
        </section>
        <section class="budget25-section">
            <div class="container">
                <div class="budget25-section__head">
                    <span class="budget25-eyebrow">Popular destinations under ₹25K</span>
                    <h2>Budget-friendly places travelers love</h2>
                    <p>These destination tiles are built from the live domestic package inventory currently available under
                        ₹25,000.</p>
                </div>

                <div class="budget25-destination-grid">
                    @forelse($popularDestinations as $destination)
                        <a href="{{ $destination['url'] }}" class="budget25-destination-card">
                            <img src="{{ $destination['image'] }}" alt="{{ $destination['name'] }}" loading="lazy">
                            <div class="budget25-destination-card__overlay"></div>
                            <div class="budget25-destination-card__content">
                                <span>{{ $destination['count'] }} package{{ $destination['count'] === 1 ? '' : 's' }}</span>
                                <h3>{{ $destination['name'] }}</h3>
                                <strong>Starts from ₹{{ number_format($destination['starting_price']) }}</strong>
                            </div>
                        </a>
                    @empty
                        <div class="budget25-empty budget25-empty--soft">
                            <h3>Popular destinations will appear here automatically</h3>
                            <p>Add or update domestic packages in the admin panel and this section will fill from live package
                                data.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="budget25-section budget25-section--tint">
            <div class="container">
                <div class="budget25-section__head">
                    <span class="budget25-eyebrow">Budget travel categories</span>
                    <h2>Choose your comfort zone</h2>
                    <p>Compare how many domestic tour options are currently available in each price band.</p>
                </div>

                <div class="budget25-category-grid">
                    @foreach($budgetCategories as $category)
                        <article class="budget25-category-card">
                            <h3>{{ $category['label'] }}</h3>
                            <strong>{{ $category['count'] }} package{{ $category['count'] === 1 ? '' : 's' }}</strong>
                            <p>
                                @if($category['starting_price'] > 0)
                                    Starts from ₹{{ number_format($category['starting_price']) }}
                                @else
                                    New options will appear here as packages are added.
                                @endif
                            </p>
                            @if(!empty($category['destinations']))
                                <div class="budget25-pills">
                                    @foreach($category['destinations'] as $destinationName)
                                        <span>{{ $destinationName }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="budget25-section">
            <div class="container">
                <div class="budget25-section__head">
                    <span class="budget25-eyebrow">Traveller testimonials</span>
                    <h2>Stories from value-first explorers</h2>
                    <p>Shortlisted for travelers who want dependable planning, attractive pricing, and memorable domestic
                        escapes.</p>
                </div>

                <div class="budget25-testimonial-grid">
                    @foreach($testimonials as $testimonial)
                        <article class="budget25-testimonial-card">
                            <div class="budget25-testimonial-card__top">
                                <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}" loading="lazy"
                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($testimonial['name']) }}&background=0f766e&color=ffffff'">
                                <div>
                                    <h3>{{ $testimonial['name'] }}</h3>
                                    <p>{{ $testimonial['destination'] }}</p>
                                </div>
                            </div>
                            <div class="budget25-testimonial-card__stars" aria-label="{{ $testimonial['rating'] }} star rating">
                                @for($i = 0; $i < $testimonial['rating']; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                            <blockquote>{{ $testimonial['review'] }}</blockquote>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="budget25-section" id="faq" itemscope itemtype="https://schema.org/FAQPage">
            <div class="container">
                <div class="budget25-section__head">
                    <span class="budget25-eyebrow">FAQ</span>
                    <h2>Quick answers before you book</h2>
                    <p>Everything a budget-conscious traveler usually wants to know before choosing a domestic package.</p>
                </div>

                <div class="budget25-faq">
                    @foreach($faqs as $faq)
                        <details class="budget25-faq__item" itemscope itemprop="mainEntity"
                            itemtype="https://schema.org/Question" {{ $loop->first ? 'open' : '' }}>
                            <summary itemprop="name">{{ $faq['question'] }}</summary>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <p itemprop="text">{{ $faq['answer'] }}</p>
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="budget25-cta">
            <div class="container">
                <div class="budget25-cta__panel">
                    <div class="budget25-cta__copy">
                        <span class="budget25-eyebrow budget25-eyebrow--light">Final call</span>
                        <h2>Ready for Your Next Adventure?</h2>
                        <p>Tell us your destination idea, travel month, and budget target. We’ll help you shortlist the
                            right under ₹25,000 package faster.</p>
                        <div class="budget25-cta__actions">
                            <a href="tel:+919999999999" class="budget25-btn budget25-btn--light">
                                <i class="bi bi-telephone-fill"></i> Call Now
                            </a>
                            <a href="https://wa.me/919999999999?text={{ urlencode('Hi, I want help planning a domestic trip under ₹25,000.') }}"
                                target="_blank" rel="noopener" class="budget25-btn budget25-btn--whatsapp">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('contact') }}" class="budget25-cta__form">
                        <div class="budget25-form__field">
                            <label for="budget25Name">Full name</label>
                            <input id="budget25Name" type="text" name="name" placeholder="Your name">
                        </div>
                        <div class="budget25-form__field">
                            <label for="budget25Phone">Phone number</label>
                            <input id="budget25Phone" type="tel" name="phone" placeholder="+91">
                        </div>
                        <div class="budget25-form__field">
                            <label for="budget25DestinationIdea">Destination</label>
                            <input id="budget25DestinationIdea" type="text" name="destination"
                                placeholder="Goa, Manali, Kerala...">
                        </div>
                        <div class="budget25-form__field">
                            <label for="budget25Budget">Budget range</label>
                            <select id="budget25Budget" name="budget">
                                <option>Under ₹10,000</option>
                                <option>₹10,000 - ₹15,000</option>
                                <option>₹15,000 - ₹20,000</option>
                                <option selected>₹20,000 - ₹25,000</option>
                            </select>
                        </div>
                        <div class="budget25-form__field budget25-form__field--full">
                            <label for="budget25TravelMonth">Travel month</label>
                            <select id="budget25TravelMonth" name="month">
                                @foreach($monthOptions as $monthOption)
                                    <option value="{{ $monthOption['value'] }}">{{ $monthOption['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="budget25-btn budget25-btn--primary budget25-btn--full">Send
                            Enquiry</button>
                    </form>
                </div>
            </div>
        </section>
    </main>


@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bannerSwiperElement = document.querySelector('[data-beach-banner-swiper]');

            if (typeof Swiper !== 'undefined') {
                if (bannerSwiperElement) {
                    const bannerFrame = bannerSwiperElement.closest('.beach-banner-frame');

                    new Swiper(bannerSwiperElement, {
                        slidesPerView: 1,
                        spaceBetween: 18,
                        speed: 700,
                        loop: true,
                        autoplay: {
                            delay: 5500,
                            disableOnInteraction: false,
                        },
                        navigation: {
                            nextEl: bannerFrame?.querySelector('.beach-banner-swiper__btn--next'),
                            prevEl: bannerFrame?.querySelector('.beach-banner-swiper__btn--prev'),
                        },
                        pagination: {
                            el: bannerFrame?.parentElement?.querySelector('.beach-banner-swiper__pagination'),
                            clickable: true,
                        },
                    });
                }
            }
        });
    </script>
    <script type="application/ld+json">
                            {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => route('home'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Domestic Tours',
                'item' => route('all-domestic'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => 'Domestic Tours Under ₹25,000',
                'item' => route('under-25k'),
            ],
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
                        </script>
@endpush
