@php
    $profile = $destinationProfile ?? [];
    $primaryColor = $destination->theme_color ?: ($profile['primary_color'] ?? '#2563eb');

    $displayPrice = $destination->formatted_price ?: '₹18,999';
    $displayIdealDays = $destination->ideal_days ?: ($profile['ideal_days'] ?? '5-7 Days');
    $displayBestSeason = $destination->best_season ?: ($profile['best_season'] ?? 'All year');

    $overviewText = trim((string) ($destination->about ?? ''));
    if (\Illuminate\Support\Str::length(strip_tags($overviewText)) < 380 && !empty($profile['overview'])) {
        $overviewText = trim((string) $profile['overview']);
    }
    if ($overviewText === '') {
        $overviewText = $destination->name . ' is a well-rounded destination for sightseeing, local culture, and memorable experiences planned around your travel style.';
    }
    $hasLongOverview = \Illuminate\Support\Str::length(strip_tags($overviewText)) > 420;

    $cityPackages = !empty($destination->city_packages) ? $destination->city_packages : ($profile['city_packages'] ?? []);
    if (empty($cityPackages)) {
        $cityPackages = [
            ['city_name' => $destination->name, 'url' => route('destinations.index', ['city' => \Illuminate\Support\Str::slug($destination->name)])],
        ];
    }

    $places = !empty($destination->places) ? $destination->places : ($profile['places'] ?? []);
    $packages = !empty($destination->packages) ? $destination->packages : ($profile['packages'] ?? []);
    $features = !empty($destination->features) ? $destination->features : ($profile['features'] ?? []);
    $seasons = !empty($destination->seasons) ? $destination->seasons : ($profile['seasons'] ?? []);
    $blogs = !empty($destination->blogs) ? $destination->blogs : ($profile['blogs'] ?? []);
    $testimonials = !empty($destination->testimonials) ? $destination->testimonials : ($profile['testimonials'] ?? []);
    $faqs = !empty($destination->faqs) ? $destination->faqs : ($profile['faqs'] ?? []);
    $popularFor = !empty($destination->popular_for) ? $destination->popular_for : ($profile['popular_for'] ?? ['Culture', 'Sightseeing']);

    $relatedItems = [];

    if (isset($relatedDestinations) && $relatedDestinations->isNotEmpty()) {
        $relatedItems = $relatedDestinations->take(4)->map(function ($item) {
            return [
                'name' => $item->name,
                'country' => $item->country,
                'image' => $item->image_url,
                'url' => route('destinations.show', $item),
            ];
        })->values()->all();
    }

    if (empty($relatedItems)) {
        $relatedByRegion = [
            'india' => ['Kashmir', 'Goa', 'Himachal', 'Kerala'],
            'international' => ['Bali', 'Maldives', 'Dubai', 'Santorini'],
        ];
        $bucket = str_contains(strtolower((string) $destination->country), 'india') ? 'india' : 'international';

        $relatedItems = collect($relatedByRegion[$bucket])
            ->map(fn (string $name) => [
                'name' => $name,
                'country' => $bucket === 'india' ? 'India' : 'International',
                'image' => $destination->image_url,
                'url' => route('destinations.index', ['search' => strtolower($name)]),
            ])
            ->all();
    }
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

<section class="seo-dd" style="--dd-primary: {{ $primaryColor }};">
    <div class="container seo-dd-container">
        <div class="seo-dd-mobile-filter-bar" aria-label="Mobile quick actions">
            <button class="seo-dd-mobile-filter-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#seoTripOffcanvas" aria-controls="seoTripOffcanvas">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
            <button class="seo-dd-mobile-filter-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#seoPageNavOffcanvas" aria-controls="seoPageNavOffcanvas">
                <i class="bi bi-sort-down"></i>
                <span>Sort</span>
            </button>
        </div>

        <div class="offcanvas offcanvas-start seo-dd-offcanvas" tabindex="-1" id="seoTripOffcanvas" aria-labelledby="seoTripOffcanvasLabel">
            <div class="offcanvas-header seo-dd-offcanvas-header">
                <h5 class="offcanvas-title" id="seoTripOffcanvasLabel">Plan {{ $destination->name }} Trip</h5>
                <button type="button" class="seo-dd-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="offcanvas-body seo-dd-offcanvas-body">
                <article class="seo-dd-card seo-dd-booking-card">
                    <p class="seo-dd-kicker">Book Your Trip</p>
                    <h3>Plan {{ $destination->name }} Vacation</h3>
                    <p class="seo-dd-sidebar-price">From {{ $displayPrice }} <span>per person</span></p>

                    <form action="#" method="POST" class="seo-dd-form">
                        @csrf
                        <label>
                            Travel Month
                            <select name="month">
                                <option value="">Select month</option>
                                @foreach($monthOptions ?? ['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label>
                            Guests
                            <select name="guests">
                                @for($guest = 1; $guest <= 10; $guest++)
                                    <option value="{{ $guest }}">{{ $guest }} {{ $guest === 1 ? 'Guest' : 'Guests' }}</option>
                                @endfor
                            </select>
                        </label>

                        <button type="submit" class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-block">Send Enquiry</button>
                        <a href="https://wa.me/" target="_blank" rel="noopener" class="seo-dd-btn seo-dd-btn-whatsapp seo-dd-btn-block">WhatsApp Expert</a>
                    </form>
                </article>

                <article class="seo-dd-card seo-dd-quick-facts">
                    <h4>Quick Destination Facts</h4>
                    <ul>
                        <li><span>Location</span><strong>{{ $destination->country ?? 'India' }}</strong></li>
                        <li><span>Best Time</span><strong>{{ $displayBestSeason }}</strong></li>
                        <li><span>Ideal Duration</span><strong>{{ $displayIdealDays }}</strong></li>
                        <li><span>Rating</span><strong>{{ number_format((float) $destination->rating, 1) }}/5</strong></li>
                        <li><span>Starting From</span><strong>{{ $displayPrice }}</strong></li>
                    </ul>
                </article>
            </div>
        </div>

        <div class="offcanvas offcanvas-end seo-dd-offcanvas seo-dd-offcanvas-nav" tabindex="-1" id="seoPageNavOffcanvas" aria-labelledby="seoPageNavOffcanvasLabel">
            <div class="offcanvas-header seo-dd-offcanvas-header">
                <h5 class="offcanvas-title" id="seoPageNavOffcanvasLabel">On This Page</h5>
                <button type="button" class="seo-dd-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="offcanvas-body seo-dd-offcanvas-body">
                <article class="seo-dd-card seo-dd-sticky-nav seo-dd-mobile-nav-card">
                    <h4>On This Page</h4>
                    <nav>
                        <a href="#overview" class="seo-dd-anchor is-active" data-seo-offcanvas-anchor>Overview</a>
                        <a href="#city-packages" class="seo-dd-anchor" data-seo-offcanvas-anchor>City Packages</a>
                        <a href="#places" class="seo-dd-anchor" data-seo-offcanvas-anchor>Places</a>
                        <a href="#packages" class="seo-dd-anchor" data-seo-offcanvas-anchor>Packages</a>
                        <a href="#besttime" class="seo-dd-anchor" data-seo-offcanvas-anchor>Best Time</a>
                        <a href="#blogs" class="seo-dd-anchor" data-seo-offcanvas-anchor>Blogs</a>
                        <a href="#faq" class="seo-dd-anchor" data-seo-offcanvas-anchor>FAQs</a>
                    </nav>
                </article>
                <article class="seo-dd-card seo-dd-cta-card">
                    <p class="seo-dd-kicker">Limited Offer</p>
                    <h4>Get Free Expert {{ $destination->name }} Itinerary</h4>
                    <p>Unlock seasonal deals and custom routes for your next {{ $destination->name }} holiday.</p>
                    <a href="#" class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-block">Claim Offer</a>
                </article>
            </div>
        </div>

        <section class="seo-dd-quick-strip" aria-label="Quick destination information">
            <article class="seo-dd-quick-card">
                <i class="bi bi-wallet2"></i>
                <p>Starting Price</p>
                <strong>{{ $displayPrice }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-hourglass-split"></i>
                <p>Ideal Duration</p>
                <strong>{{ $displayIdealDays }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-cloud-sun-fill"></i>
                <p>Best Time To Visit</p>
                <strong>{{ $displayBestSeason }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-stars"></i>
                <p>Traveler Rating</p>
                <strong>{{ number_format((float) $destination->rating, 1) }}/5</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-airplane-fill"></i>
                <p>Popular For</p>
                <strong>{{ implode(', ', $popularFor) }}</strong>
            </article>
        </section>

        <div class="seo-dd-grid">
            <main class="seo-dd-main" itemscope itemtype="https://schema.org/TouristDestination">
                <meta itemprop="name" content="{{ $destination->name }} Tour Packages">

                <section id="overview" class="seo-dd-section seo-dd-glass">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Destination Overview</p>
                        <h2 class="seo-dd-title">{{ $destination->name }} Tour Packages</h2>
                    </div>
                    <p class="seo-dd-lead">Explore handpicked <mark>{{ $destination->name }}</mark> itineraries crafted for couples, families, and adventure travelers.</p>
                    <div class="seo-dd-copy {{ $hasLongOverview ? 'is-collapsed' : '' }}" data-seo-readmore itemprop="description">
                        {{ $overviewText }}
                    </div>
                    @if($hasLongOverview)
                        <button type="button" class="seo-dd-link" data-seo-toggle aria-expanded="false">Read More</button>
                    @endif
                </section>

                <section id="city-packages" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Internal Package Links</p>
                        <h2 class="seo-dd-title">{{ $destination->name }} Packages By Cities</h2>
                    </div>
                    <div class="seo-dd-pills" aria-label="City specific {{ $destination->name }} tour package links">
                        @foreach($cityPackages as $packageCity)
                            @php
                                if (is_string($packageCity)) {
                                    $cityName = $packageCity;
                                    $cityUrl = route('destinations.index', ['city' => \Illuminate\Support\Str::slug($packageCity)]);
                                } elseif (is_array($packageCity)) {
                                    $cityName = $packageCity['city_name'] ?? '';
                                    $cityUrl = $packageCity['url'] ?? '#';
                                } else {
                                    $cityName = $packageCity->city_name ?? '';
                                    $cityUrl = $packageCity->url ?? '#';
                                }
                            @endphp
                            <a href="{{ $cityUrl }}" class="seo-dd-pill" title="{{ $cityName }} Tour Packages">
                                {{ $cityName }} Tour Packages
                            </a>
                        @endforeach
                    </div>
                </section>

                <section id="places" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Places To Explore</p>
                        <h2 class="seo-dd-title">Top Places To Explore In {{ $destination->name }}</h2>
                    </div>
                    <div class="seo-dd-card-grid seo-dd-place-grid">
                        @foreach($places as $place)
                            <article class="seo-dd-card seo-dd-place-card">
                                <img src="{{ $place['image'] ?? $destination->image_url }}" alt="{{ $place['name'] }}" loading="lazy">
                                <div class="seo-dd-card-body">
                                    <div class="seo-dd-row-between">
                                        <h3>{{ $place['name'] }}</h3>
                                        <span class="seo-dd-duration">{{ $place['duration'] ?? '2-4 Days' }}</span>
                                    </div>
                                    <p>{{ $place['description'] ?? '' }}</p>
                                    <div class="seo-dd-badges">
                                        @foreach(array_slice(($place['attractions'] ?? []), 0, 3) as $attraction)
                                            <span class="seo-dd-badge">{{ $attraction }}</span>
                                        @endforeach
                                    </div>
                                    <div class="seo-dd-tags">
                                        @foreach(array_slice(($place['tags'] ?? []), 0, 2) as $tag)
                                            <span class="seo-dd-tag">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                    <a href="#" class="seo-dd-btn seo-dd-btn-ghost">Explore {{ $place['name'] }}</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="packages" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Tour Packages</p>
                        <h2 class="seo-dd-title">Explore More {{ $destination->name }} Packages</h2>
                    </div>

                    <div class="swiper seo-dd-swiper" data-swiper-packages>
                        <div class="swiper-wrapper">
                            @foreach($packages as $package)
                                <article class="swiper-slide seo-dd-card seo-dd-package-card">
                                    <img src="{{ $package['image'] ?? $destination->image_url }}" alt="{{ $package['name'] }}" loading="lazy">
                                    <div class="seo-dd-card-body">
                                        <h3>{{ $package['name'] }}</h3>
                                        <div class="seo-dd-package-meta">
                                            <span><i class="bi bi-clock"></i> {{ $package['duration'] ?? '4D/3N' }}</span>
                                            <span><i class="bi bi-star-fill"></i> {{ number_format((float) ($package['rating'] ?? 4.5), 1) }}</span>
                                        </div>
                                        <div class="seo-dd-row-between">
                                            <p class="seo-dd-price">{{ $package['price'] ?? $destination->formatted_price }}</p>
                                            <a href="{{ $package['url'] ?? '#' }}" class="seo-dd-btn seo-dd-btn-primary">View Package</a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="seo-dd-swiper-nav">
                            <button class="seo-dd-swiper-btn prev" type="button" aria-label="Previous package"><i class="bi bi-arrow-left"></i></button>
                            <button class="seo-dd-swiper-btn next" type="button" aria-label="Next package"><i class="bi bi-arrow-right"></i></button>
                        </div>
                    </div>
                </section>

                <section id="why" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Why Choose {{ $destination->name }}</p>
                        <h2 class="seo-dd-title">What Makes This Destination Special</h2>
                    </div>
                    <div class="seo-dd-card-grid seo-dd-feature-grid">
                        @foreach($features as $feature)
                            <article class="seo-dd-card seo-dd-feature-card">
                                <span class="seo-dd-icon"><i class="{{ $feature['icon'] ?? 'bi bi-check2-circle' }}"></i></span>
                                <h3>{{ $feature['title'] ?? '' }}</h3>
                                <p>{{ $feature['desc'] ?? '' }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="besttime" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Season Guide</p>
                        <h2 class="seo-dd-title">Best Time To Visit {{ $destination->name }}</h2>
                    </div>
                    <div class="seo-dd-card-grid seo-dd-season-grid">
                        @foreach($seasons as $season)
                            <article class="seo-dd-card seo-dd-season-card">
                                <span class="seo-dd-icon"><i class="{{ $season['icon'] ?? 'bi bi-cloud-sun' }}"></i></span>
                                <h3>{{ $season['name'] }}</h3>
                                <p class="seo-dd-weather">{{ $season['weather'] }}</p>
                                <div class="seo-dd-badges">
                                    @foreach(($season['activities'] ?? []) as $activity)
                                        <span class="seo-dd-badge">{{ $activity }}</span>
                                    @endforeach
                                </div>
                                <p class="seo-dd-reco">{{ $season['recommendation'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="blogs" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Content Hub</p>
                        <h2 class="seo-dd-title">Travel Guides & Blogs</h2>
                    </div>
                    <div class="seo-dd-card-grid seo-dd-blog-grid">
                        @foreach($blogs as $blog)
                            <article class="seo-dd-card seo-dd-blog-card">
                                <img src="{{ $blog['image'] ?? $destination->image_url }}" alt="{{ $blog['title'] }}" loading="lazy">
                                <div class="seo-dd-card-body">
                                    <time datetime="{{ $blog['date'] }}">{{ \Carbon\Carbon::parse($blog['date'])->format('M d, Y') }}</time>
                                    <h3>{{ $blog['title'] }}</h3>
                                    <p>{{ $blog['excerpt'] }}</p>
                                    <a href="{{ $blog['url'] ?? '#' }}" class="seo-dd-btn seo-dd-btn-ghost">Read More</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="testimonials" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Social Proof</p>
                        <h2 class="seo-dd-title">Traveler Testimonials</h2>
                    </div>

                    <div class="swiper seo-dd-swiper" data-swiper-testimonials>
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                                <article class="swiper-slide seo-dd-card seo-dd-testimonial-card">
                                    <div class="seo-dd-user">
                                        <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}">
                                        <div>
                                            <h3>{{ $testimonial['name'] }}</h3>
                                            <p>{{ $testimonial['location'] }}</p>
                                        </div>
                                    </div>
                                    <p class="seo-dd-stars">★ {{ number_format((float) $testimonial['rating'], 1) }}</p>
                                    <p class="seo-dd-review">{{ $testimonial['text'] }}</p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section id="faq" class="seo-dd-section" itemscope itemtype="https://schema.org/FAQPage">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">FAQs</p>
                        <h2 class="seo-dd-title">Frequently Asked Questions</h2>
                    </div>

                    <div class="seo-dd-faq-list">
                        @foreach($faqs as $index => $faq)
                            <article class="seo-dd-faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                <button class="seo-dd-faq-btn {{ $index === 0 ? 'is-open' : '' }}" type="button" data-faq-toggle>
                                    <span itemprop="name">{{ $faq['q'] }}</span>
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                                <div class="seo-dd-faq-panel {{ $index === 0 ? 'is-open' : '' }}" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                    <p itemprop="text">{{ $faq['a'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="related" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Related Destinations</p>
                        <h2 class="seo-dd-title">Explore More Destinations Like {{ $destination->name }}</h2>
                    </div>
                    <div class="seo-dd-card-grid seo-dd-related-grid">
                        @foreach($relatedItems as $related)
                            <a href="{{ $related['url'] ?? '#' }}" class="seo-dd-card seo-dd-related-card">
                                <img src="{{ $related['image'] ?? $destination->image_url }}" alt="{{ $related['name'] }}">
                                <div class="seo-dd-card-body">
                                    <h3>{{ $related['name'] }}</h3>
                                    <p>{{ $related['country'] ?? 'India' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            </main>

            <aside class="seo-dd-sidebar">
                <div class="seo-dd-sidebar-sticky">
                    <article class="seo-dd-card seo-dd-booking-card">
                        <p class="seo-dd-kicker">Book Your Trip</p>
                        <h3>Plan {{ $destination->name }} Vacation</h3>
                        <p class="seo-dd-sidebar-price">From {{ $destination->formatted_price ?? '₹18,999' }} <span>per person</span></p>

                        <form action="#" method="POST" class="seo-dd-form">
                            @csrf
                            <label>
                                Travel Month
                                <select name="month">
                                    <option value="">Select month</option>
                                    @foreach($monthOptions ?? ['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label>
                                Guests
                                <select name="guests">
                                    @for($guest = 1; $guest <= 10; $guest++)
                                        <option value="{{ $guest }}">{{ $guest }} {{ $guest === 1 ? 'Guest' : 'Guests' }}</option>
                                    @endfor
                                </select>
                            </label>

                            <button type="submit" class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-block">Send Enquiry</button>
                            <a href="https://wa.me/" target="_blank" rel="noopener" class="seo-dd-btn seo-dd-btn-whatsapp seo-dd-btn-block">WhatsApp Expert</a>
                        </form>
                    </article>

                    <article class="seo-dd-card seo-dd-quick-facts">
                        <h4>Quick Destination Facts</h4>
                        <ul>
                            <li><span>Location</span><strong>{{ $destination->country ?? 'India' }}</strong></li>
                            <li><span>Best Time</span><strong>{{ $displayBestSeason }}</strong></li>
                            <li><span>Ideal Duration</span><strong>{{ $displayIdealDays }}</strong></li>
                            <li><span>Rating</span><strong>{{ number_format((float) $destination->rating, 1) }}/5</strong></li>
                            <li><span>Starting From</span><strong>{{ $displayPrice }}</strong></li>
                        </ul>
                    </article>

                    <article class="seo-dd-card seo-dd-sticky-nav">
                        <h4>On This Page</h4>
                        <nav>
                            <a href="#overview" class="seo-dd-anchor is-active">Overview</a>
                            <a href="#city-packages" class="seo-dd-anchor">City Packages</a>
                            <a href="#places" class="seo-dd-anchor">Places</a>
                            <a href="#packages" class="seo-dd-anchor">Packages</a>
                            <a href="#besttime" class="seo-dd-anchor">Best Time</a>
                            <a href="#blogs" class="seo-dd-anchor">Blogs</a>
                            <a href="#faq" class="seo-dd-anchor">FAQs</a>
                        </nav>
                    </article>

                    <article class="seo-dd-card seo-dd-cta-card">
                        <p class="seo-dd-kicker">Limited Offer</p>
                        <h4>Get Free Expert {{ $destination->name }} Itinerary</h4>
                        <p>Unlock seasonal deals and custom routes for your next {{ $destination->name }} holiday.</p>
                        <a href="#" class="seo-dd-btn seo-dd-btn-primary seo-dd-btn-block">Claim Offer</a>
                    </article>
                </div>
            </aside>
        </div>
    </div>
</section>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const readMoreContent = document.querySelector('[data-seo-readmore]');
            const readMoreToggle = document.querySelector('[data-seo-toggle]');

            if (readMoreContent && readMoreToggle) {
                readMoreToggle.addEventListener('click', function () {
                    const isExpanded = readMoreContent.classList.toggle('is-expanded');
                    readMoreContent.classList.toggle('is-collapsed', !isExpanded);
                    readMoreToggle.textContent = isExpanded ? 'Read Less' : 'Read More';
                    readMoreToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                });
            }

            document.querySelectorAll('.seo-dd-anchor').forEach(function (anchor) {
                anchor.addEventListener('click', function (event) {
                    const target = document.querySelector(anchor.getAttribute('href'));
                    if (!target) {
                        return;
                    }
                    event.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });

            document.querySelectorAll('[data-seo-offcanvas-anchor]').forEach(function (anchor) {
                anchor.addEventListener('click', function () {
                    const offcanvasElement = anchor.closest('.offcanvas');
                    if (!offcanvasElement || typeof bootstrap === 'undefined' || !bootstrap.Offcanvas) {
                        return;
                    }
                    const offcanvasInstance = bootstrap.Offcanvas.getOrCreateInstance(offcanvasElement);
                    offcanvasInstance.hide();
                });
            });

            const sections = Array.from(document.querySelectorAll('#overview, #city-packages, #places, #packages, #besttime, #blogs, #faq'));
            const anchors = Array.from(document.querySelectorAll('.seo-dd-anchor'));

            if (sections.length && anchors.length && 'IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        const activeId = '#' + entry.target.id;
                        anchors.forEach(function (anchor) {
                            anchor.classList.toggle('is-active', anchor.getAttribute('href') === activeId);
                        });
                    });
                }, {
                    rootMargin: '-35% 0px -55% 0px',
                    threshold: 0.1,
                });

                sections.forEach(function (section) {
                    observer.observe(section);
                });
            }

            document.querySelectorAll('[data-faq-toggle]').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const panel = toggle.nextElementSibling;
                    const isOpen = panel.classList.contains('is-open');

                    document.querySelectorAll('.seo-dd-faq-btn').forEach(function (btn) {
                        btn.classList.remove('is-open');
                    });
                    document.querySelectorAll('.seo-dd-faq-panel').forEach(function (item) {
                        item.classList.remove('is-open');
                    });

                    if (!isOpen) {
                        toggle.classList.add('is-open');
                        panel.classList.add('is-open');
                    }
                });
            });

            if (typeof Swiper !== 'undefined') {
                const packageSwiperElement = document.querySelector('[data-swiper-packages]');
                if (packageSwiperElement) {
                    new Swiper(packageSwiperElement, {
                        slidesPerView: 1.15,
                        spaceBetween: 16,
                        navigation: {
                            nextEl: '.seo-dd-swiper-btn.next',
                            prevEl: '.seo-dd-swiper-btn.prev',
                        },
                        breakpoints: {
                            640: { slidesPerView: 2.1 },
                            992: { slidesPerView: 2.4 },
                            1200: { slidesPerView: 2.8 }
                        }
                    });
                }

                const testimonialSwiperElement = document.querySelector('[data-swiper-testimonials]');
                if (testimonialSwiperElement) {
                    new Swiper(testimonialSwiperElement, {
                        slidesPerView: 1.05,
                        spaceBetween: 16,
                        breakpoints: {
                            768: { slidesPerView: 2 },
                            1200: { slidesPerView: 2.5 }
                        }
                    });
                }
            }
        });
    </script>

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['a'],
                    ],
                ];
            }, $faqs),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endpush
