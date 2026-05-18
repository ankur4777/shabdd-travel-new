@php
    $primaryColor = $destination->theme_color ?? '#2563eb';

    $cityPackages = $destination->city_packages ?? [
        ['city_name' => 'Manali', 'url' => route('destinations.index', ['city' => 'manali'])],
        ['city_name' => 'Shimla', 'url' => route('destinations.index', ['city' => 'shimla'])],
        ['city_name' => 'Dharamshala', 'url' => route('destinations.index', ['city' => 'dharamshala'])],
        ['city_name' => 'Kasol', 'url' => route('destinations.index', ['city' => 'kasol'])],
        ['city_name' => 'Dalhousie', 'url' => route('destinations.index', ['city' => 'dalhousie'])],
        ['city_name' => 'Kullu', 'url' => route('destinations.index', ['city' => 'kullu'])],
        ['city_name' => 'Spiti Valley', 'url' => route('destinations.index', ['city' => 'spiti-valley'])],
        ['city_name' => 'Kufri', 'url' => route('destinations.index', ['city' => 'kufri'])],
        ['city_name' => 'Bir Billing', 'url' => route('destinations.index', ['city' => 'bir-billing'])],
    ];

    $places = $destination->places ?? [
        [
            'name' => 'Shimla',
            'description' => 'Colonial charm with pine valleys, local cafes, and beautiful ridge views for family-friendly getaways.',
            'attractions' => ['Mall Road', 'Jakhoo Temple', 'Christ Church'],
            'duration' => '2-3 Days',
            'image' => $destination->image_url,
            'tags' => ['Family', 'Scenic'],
        ],
        [
            'name' => 'Manali',
            'description' => 'A mountain favorite for snow activities, riverside stays, and adventure-packed itineraries.',
            'attractions' => ['Solang Valley', 'Hadimba Temple', 'Rohtang Pass'],
            'duration' => '3-4 Days',
            'image' => $destination->image_url,
            'tags' => ['Adventure', 'Snow'],
        ],
        [
            'name' => 'Dharamshala',
            'description' => 'A peaceful Himalayan retreat blending monasteries, culture, and scenic walking routes.',
            'attractions' => ['McLeod Ganj', 'Bhagsu Falls', 'Namgyal Monastery'],
            'duration' => '2-3 Days',
            'image' => $destination->image_url,
            'tags' => ['Spiritual', 'Culture'],
        ],
        [
            'name' => 'Spiti Valley',
            'description' => 'High-altitude desert landscapes and monastery circuits for offbeat explorers and road trip lovers.',
            'attractions' => ['Kaza', 'Key Monastery', 'Chandratal'],
            'duration' => '5-7 Days',
            'image' => $destination->image_url,
            'tags' => ['Offbeat', 'Roadtrip'],
        ],
        [
            'name' => 'Kasol',
            'description' => 'Riverside village vibes, short treks, and laid-back mountain stays perfect for young travelers.',
            'attractions' => ['Parvati Valley', 'Tosh', 'Manikaran'],
            'duration' => '2-3 Days',
            'image' => $destination->image_url,
            'tags' => ['Backpacking', 'Nature'],
        ],
    ];

    $packages = $destination->packages ?? [
        ['name' => 'Honeymoon Package', 'duration' => '5D/4N', 'rating' => 4.8, 'price' => '₹27,999', 'image' => $destination->image_url, 'url' => '#'],
        ['name' => 'Family Package', 'duration' => '6D/5N', 'rating' => 4.7, 'price' => '₹31,499', 'image' => $destination->image_url, 'url' => '#'],
        ['name' => 'Adventure Package', 'duration' => '4D/3N', 'rating' => 4.9, 'price' => '₹24,999', 'image' => $destination->image_url, 'url' => '#'],
        ['name' => 'Snow Package', 'duration' => '5D/4N', 'rating' => 4.6, 'price' => '₹26,999', 'image' => $destination->image_url, 'url' => '#'],
        ['name' => 'Luxury Package', 'duration' => '7D/6N', 'rating' => 4.9, 'price' => '₹44,999', 'image' => $destination->image_url, 'url' => '#'],
    ];

    $features = $destination->features ?? [
        ['icon' => 'bi bi-snow2', 'title' => 'Snow Adventures', 'desc' => 'Winter sports, snowfall views, and mountain experiences.'],
        ['icon' => 'bi bi-image-alt', 'title' => 'Mountain Views', 'desc' => 'Postcard landscapes, valleys, and scenic drives.'],
        ['icon' => 'bi bi-people', 'title' => 'Family Friendly', 'desc' => 'Safe routes, comfortable stays, and all-age itineraries.'],
        ['icon' => 'bi bi-heart', 'title' => 'Honeymoon Destination', 'desc' => 'Romantic stays and curated private experiences.'],
        ['icon' => 'bi bi-backpack3', 'title' => 'Trekking & Camping', 'desc' => 'Trail options for beginner to advanced explorers.'],
        ['icon' => 'bi bi-brightness-high', 'title' => 'Spiritual Tourism', 'desc' => 'Monasteries, temples, and mindful mountain escapes.'],
    ];

    $seasons = $destination->seasons ?? [
        ['name' => 'April to June', 'weather' => 'Pleasant weather (15°C to 28°C)', 'activities' => ['Sightseeing', 'Family trips', 'Adventure sports'], 'recommendation' => 'Best for first-time travelers.', 'icon' => 'bi bi-sun'],
        ['name' => 'July to September', 'weather' => 'Monsoon freshness (12°C to 22°C)', 'activities' => ['Nature stays', 'Waterfalls', 'Budget travel'], 'recommendation' => 'Ideal for off-season discounts.', 'icon' => 'bi bi-cloud-rain'],
        ['name' => 'October to March', 'weather' => 'Cold and snowy (0°C to 15°C)', 'activities' => ['Snow fun', 'Honeymoon', 'Winter photography'], 'recommendation' => 'Great for snowfall experiences.', 'icon' => 'bi bi-cloud-snow'],
    ];

    $blogs = $destination->blogs ?? [
        ['title' => 'Best Places To Visit In Himachal', 'excerpt' => 'A practical guide to top scenic towns and hidden valleys in Himachal.', 'date' => '2026-01-18', 'image' => $destination->image_url, 'url' => '#'],
        ['title' => 'Best Time To Visit Manali', 'excerpt' => 'Season-by-season trip planning for Manali adventures and family holidays.', 'date' => '2026-02-06', 'image' => $destination->image_url, 'url' => '#'],
        ['title' => 'Hidden Gems Of Himachal', 'excerpt' => 'Discover lesser-known villages and offbeat places beyond mainstream routes.', 'date' => '2026-03-11', 'image' => $destination->image_url, 'url' => '#'],
        ['title' => 'Himachal Honeymoon Guide', 'excerpt' => 'Romantic itineraries, best stays, and travel tips for couples.', 'date' => '2026-04-01', 'image' => $destination->image_url, 'url' => '#'],
    ];

    $testimonials = $destination->testimonials ?? [
        ['name' => 'Ananya Mehra', 'rating' => 5, 'text' => 'Smooth planning and excellent stays. Our Himachal trip felt premium and stress-free.', 'location' => 'Delhi', 'image' => 'https://i.pravatar.cc/100?img=12'],
        ['name' => 'Rohit Malhotra', 'rating' => 5, 'text' => 'The itinerary balance was perfect for our family. Great support throughout the trip.', 'location' => 'Mumbai', 'image' => 'https://i.pravatar.cc/100?img=16'],
        ['name' => 'Kavya Singh', 'rating' => 4.8, 'text' => 'Loved the hotel quality and mountain experiences. Will book again.', 'location' => 'Bengaluru', 'image' => 'https://i.pravatar.cc/100?img=32'],
    ];

    $faqs = $destination->faqs ?? [
        ['q' => 'What is the best time to visit Himachal?', 'a' => 'April to June is best for pleasant weather, while October to March is ideal for snowfall and winter trips.'],
        ['q' => 'How many days are enough for Himachal?', 'a' => 'A 5 to 7 day itinerary covers major highlights comfortably, while shorter 3 to 4 day trips work for one or two cities.'],
        ['q' => 'Is Himachal good for honeymoon?', 'a' => 'Yes, Himachal is one of India\'s top honeymoon destinations with scenic views, cozy stays, and romantic activities.'],
        ['q' => 'Which is the best hill station in Himachal?', 'a' => 'Manali and Shimla are top picks, while Dharamshala and Spiti Valley are ideal for culture and offbeat travel.'],
    ];

    $popularFor = $destination->popular_for ?? ['Snow', 'Nature', 'Adventure'];

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
        $relatedItems = [
            ['name' => 'Kashmir', 'country' => 'India', 'image' => $destination->image_url, 'url' => route('destinations.index', ['search' => 'kashmir'])],
            ['name' => 'Uttarakhand', 'country' => 'India', 'image' => $destination->image_url, 'url' => route('destinations.index', ['search' => 'uttarakhand'])],
            ['name' => 'Leh Ladakh', 'country' => 'India', 'image' => $destination->image_url, 'url' => route('destinations.index', ['search' => 'ladakh'])],
            ['name' => 'Sikkim', 'country' => 'India', 'image' => $destination->image_url, 'url' => route('destinations.index', ['search' => 'sikkim'])],
        ];
    }
@endphp

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

<section class="seo-dd" style="--dd-primary: {{ $primaryColor }};">
    <div class="container seo-dd-container">
        <section class="seo-dd-quick-strip" aria-label="Quick destination information">
            <article class="seo-dd-quick-card">
                <i class="bi bi-currency-rupee"></i>
                <p>Starting Price</p>
                <strong>{{ $destination->formatted_price ?? '₹18,999' }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-calendar3"></i>
                <p>Ideal Duration</p>
                <strong>{{ $destination->ideal_days ?? '5-7 Days' }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-cloud-sun"></i>
                <p>Best Time To Visit</p>
                <strong>{{ $destination->best_season ?? 'Apr-Jun, Oct-Mar' }}</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-star-fill"></i>
                <p>Traveler Rating</p>
                <strong>{{ number_format((float) $destination->rating, 1) }}/5</strong>
            </article>
            <article class="seo-dd-quick-card">
                <i class="bi bi-compass"></i>
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
                    <div class="seo-dd-copy is-collapsed" data-seo-readmore itemprop="description">
                        {{ $destination->about }}
                    </div>
                    <button type="button" class="seo-dd-link" data-seo-toggle aria-expanded="false">Read More</button>
                </section>

                <section id="city-packages" class="seo-dd-section">
                    <div class="seo-dd-title-wrap">
                        <p class="seo-dd-kicker">Internal Package Links</p>
                        <h2 class="seo-dd-title">{{ $destination->name }} Packages By Cities</h2>
                    </div>
                    <div class="seo-dd-pills" aria-label="City specific Himachal tour package links">
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
                        <h2 class="seo-dd-title">Explore More Himachal Packages</h2>
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
                        <p class="seo-dd-kicker">Why Choose Himachal</p>
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
                        <h2 class="seo-dd-title">Best Time To Visit Himachal</h2>
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
                        <h2 class="seo-dd-title">Explore More Mountain Holidays</h2>
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
                            <li><span>Best Time</span><strong>{{ $destination->best_season ?? 'Apr-Jun, Oct-Mar' }}</strong></li>
                            <li><span>Ideal Duration</span><strong>{{ $destination->ideal_days ?? '5-7 Days' }}</strong></li>
                            <li><span>Rating</span><strong>{{ number_format((float) $destination->rating, 1) }}/5</strong></li>
                            <li><span>Starting From</span><strong>{{ $destination->formatted_price ?? '₹18,999' }}</strong></li>
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
                        <h4>Get Free Expert Itinerary</h4>
                        <p>Unlock seasonal deals and custom routes for your next mountain holiday.</p>
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
