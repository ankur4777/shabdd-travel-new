<main class="mb-page mb-page--{{ $journeySlug }}" style="--mb-accent: {{ $journey['accent'] }};">
        <section class="mb-hero" style="--mb-hero: url('{{ $journey['hero_image'] }}');">
            <div class="mb-shell mb-hero__inner">
                <div class="mb-hero__copy" data-mb-reveal>
                    <nav class="mb-breadcrumb" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}">Home</a>
                        <span>/</span>
                        <span>Most Booked</span>
                        <span>/</span>
                        <span>{{ $journey['short_name'] }}</span>
                    </nav>
                    <p class="mb-kicker">{{ $journey['eyebrow'] }}</p>
                    <h1>{{ $journey['headline'] }}</h1>
                    <p class="mb-hero__intro">{{ $journey['intro'] }}</p>
                    <div class="mb-hero__actions">
                        <a href="#journeyPackages" class="mb-button mb-button--gold">See holiday plans <i class="bi bi-arrow-down"></i></a>
                        <a href="{{ route('contact') }}" class="mb-button mb-button--ghost">Build it around my dates</a>
                    </div>    <div><a class="mb-hero__scroll" href="#journeyOverview" aria-label="Continue to overview"><span></span>Scroll to wander</a></div>
                </div>

          
                    
            </div>
        
        </section>

        <section class="mb-overview" id="journeyOverview">
            <div class="mb-shell mb-overview__grid">
                <div data-mb-reveal>
                    <p class="mb-section-label">A note from our planners</p>
                    <h2>{{ $journey['overview_title'] }}</h2>
                </div>
                <div class="mb-overview__text" data-mb-reveal>
                    @foreach($journey['overview'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                    <div class="mb-signoff"><span>SHABDD</span> itinerary desk</div>
                </div>
            </div>
        </section>

        <section class="mb-highlights">
            <div class="mb-shell">
                <header class="mb-heading" data-mb-reveal>
                    <div><p class="mb-section-label">The trip, in four chapters</p><h2>What deserves a place in the plan</h2></div>
                    <p>We choose fewer experiences and give each one a better hour of the day.</p>
                </header>
                <div class="mb-highlight-grid">
                    @foreach($journey['highlights'] as $highlight)
                        <article data-mb-reveal>
                            <div class="mb-highlight__top"><span>{{ $highlight['number'] }}</span><i class="{{ $highlight['icon'] }}"></i></div>
                            <h3>{{ $highlight['title'] }}</h3>
                            <p>{{ $highlight['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mb-itinerary">
            <div class="mb-shell mb-itinerary__grid">
                <div class="mb-itinerary__intro" data-mb-reveal>
                    <p class="mb-section-label">A five-day rhythm</p>
                    <h2>A route that knows when to stop.</h2>
                    <p>This is a starting shape, not a locked schedule. Swap experiences, add a night or keep an afternoon completely free.</p>
                    <a href="{{ route('contact') }}" class="mb-text-link">Ask for the detailed itinerary <i class="bi bi-arrow-right"></i></a>
                </div>
                <ol class="mb-timeline">
                    @foreach($journey['day_plan'] as $day)
                        <li data-mb-reveal>
                            <span>{{ $day['day'] }}</span>
                            <div><h3>{{ $day['title'] }}</h3><p>{{ $day['text'] }}</p></div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        @php
            $adminPackages = $journeyPackages ?? collect();
        @endphp

        <section class="mb-packages" id="journeyPackages">
            <div class="mb-shell">
                <header class="mb-heading" data-mb-reveal>
                    <div><p class="mb-section-label">Packages from admin</p><h2>{{ $journey['short_name'] }} holidays ready to book</h2></div>
                    <p>Only International packages with {{ $journey['short_name'] }} in the package title appear here.</p>
                </header>

                @if($adminPackages->isNotEmpty())
                    <div class="mb-package-grid mb-package-grid--admin">
                        @foreach($adminPackages as $package)
                            @php
                                $packageImage = \App\Support\MediaUrl::asset($package->image, 'images/couple-bg.jpg');
                                $packageDuration = $package->duration_text ?: ($package->days ? $package->days . ' days' : 'Flexible duration');
                                $packageHighlights = collect([$package->feature_1, $package->feature_2, $package->feature_3])->filter()->take(3);
                            @endphp
                            <article class="mb-admin-package-card {{ $loop->iteration === 2 ? 'is-featured' : '' }}" data-mb-reveal>
                                <a class="mb-admin-package-card__image" href="{{ route('packages.show', $package->slug) }}">
                                    <img src="{{ $packageImage }}" alt="{{ $package->title }}"
                                        width="420"
                                        height="300"
                                        loading="{{ $loop->iteration <= 3 ? 'eager' : 'lazy' }}"
                                        fetchpriority="{{ $loop->first ? 'high' : 'auto' }}"
                                        decoding="async">
                                    <span>{{ $package->category ?: 'International' }}</span>
                                </a>
                                <div class="mb-admin-package-card__body">
                                    <p>{{ $packageDuration }}</p>
                                    <h3><a href="{{ route('packages.show', $package->slug) }}">{{ $package->title }}</a></h3>
                                    @if($packageHighlights->isNotEmpty())
                                        <ul>
                                            @foreach($packageHighlights as $feature)
                                                <li><i class="bi bi-check2"></i>{{ $feature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <div class="mb-package__price">
                                        <span>from</span>
                                        @if($package->old_price && $package->old_price > $package->price)
                                            <del>₹{{ number_format($package->old_price) }}</del>
                                        @endif
                                        <strong>{{ $package->price ? '₹' . number_format($package->price) : 'On request' }}</strong>
                                        <small>per person*</small>
                                    </div>
                                    <a href="{{ route('packages.show', $package->slug) }}">View package <i class="bi bi-arrow-up-right"></i></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <p class="mb-price-note">*Final pricing and inclusions depend on dates, availability and traveller count.</p>
                @else
                    <div class="mb-package-empty" data-mb-reveal>
                        <i class="bi bi-suitcase2"></i>
                        <h3>No matching package published yet</h3>
                        <p>Add an International package from the admin panel with {{ $journey['short_name'] }} in its title, and it will appear here automatically.</p>
                        <a href="{{ route('contact') }}" class="mb-button mb-button--gold">Build this trip manually <i class="bi bi-arrow-right"></i></a>
                    </div>
                @endif
            </div>
        </section>

        <section class="mb-stays">
            <div class="mb-shell">
                <header class="mb-heading mb-heading--light" data-mb-reveal>
                    <div><p class="mb-section-label" style="color:white">Where you stay changes the trip</p><h2 style="color:white">Pick a neighbourhood, not just a hotel.</h2></div>
                </header>
                <div class="mb-stay-grid">
                    @foreach($journey['stay_areas'] as $area)
                        <article data-mb-reveal>
                            <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <p>{{ $area['best_for'] }}</p>
                            <h3>{{ $area['name'] }}</h3>
                            <div>{{ $area['text'] }}</div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mb-notes">
            <div class="mb-shell mb-notes__grid">
                <div data-mb-reveal><p class="mb-section-label">Small things that improve the holiday</p><h2 class="mb-notes__title">Before you book.</h2></div>
                <div>
                    @foreach($journey['notes'] as $note)
                        <article data-mb-reveal>
                            <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <div><h3>{{ $note['title'] }}</h3><p>{{ $note['text'] }}</p></div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mb-faq">
            <div class="mb-shell mb-faq__grid">
                <div data-mb-reveal><p class="mb-section-label">Useful answers</p>
                
                <h2 style="color:black">Questions travellers usually ask us.</h2>
            </div>
                <div class="mb-faq__list">
                    @foreach($journey['faqs'] as $faq)
                        <details data-mb-reveal>
                            <summary>{{ $faq['question'] }}<i class="bi bi-plus-lg"></i></summary>
                            <p>{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mb-more">
            <div class="mb-shell">
                <p class="mb-section-label" data-mb-reveal>More from our most-booked shelf</p>
                <div class="mb-more__links">
                    @foreach($mostBookedJourneys as $slug => $item)
                        @if($slug !== $journeySlug)
                            <a href="{{ route('most-booked.show', $slug) }}" data-mb-reveal>
                                <span>{{ $item['country'] }}</span><strong>{{ $item['name'] }}</strong><i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>

        <section class="mb-cta" style="--mb-cta-image: url('{{ $journey['hero_image'] }}');">
            <div class="mb-shell" data-mb-reveal>
                <p class="mb-section-label">Make it yours</p>
                <h2>Dates first. Details after.</h2>
                <p>Tell us who is travelling and roughly when. We will return with a sensible route, stay options and a clear starting budget.</p>
                <a href="{{ route('contact') }}" class="mb-button mb-button--gold">Plan my {{ $journey['short_name'] }} holiday <i class="bi bi-arrow-right"></i></a>
            </div>
        </section>
    </main>
