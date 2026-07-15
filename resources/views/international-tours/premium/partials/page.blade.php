<main class="pj-page pj-page--{{ $journeySlug }}" style="--pj-accent: {{ $journey['accent'] }};">
    <section class="pj-hero" style="--pj-hero: url('{{ $journey['hero'] }}');">
        <div class="pj-hero__wash"></div>
        <div class="pj-shell pj-hero__inner">
            <div class="pj-hero__content" data-pj-reveal>
                <nav class="pj-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a><span>/</span><span>Premium Journeys</span><span>/</span><span>{{ $journey['shortName'] }}</span>
                </nav>
                <p class="pj-kicker">{{ $journey['eyebrow'] }}</p>
                <h1>{{ $journey['headline'] }}</h1>
                <p class="pj-hero__dek">{{ $journey['dek'] }}</p>
                <div class="pj-hero__actions">
                    <a href="#premiumRoute" class="pj-button pj-button--solid">Read the route <i class="bi bi-arrow-down"></i></a>
                    <a href="{{ route('contact') }}" class="pj-button pj-button--line">Request a private proposal</a>
                </div>
            </div>
            <aside class="pj-hero__folio" data-pj-reveal>
                <span>SHABDD / Premium No. {{ str_pad(array_search($journeySlug, array_keys($premiumJourneys->all())) + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <strong>{{ $journey['countries'] }}</strong>
                <dl>
                    <div><dt>From</dt><dd>₹{{ number_format($journey['price']) }}</dd></div>
                    <div><dt>Length</dt><dd>{{ $journey['duration'] }}</dd></div>
                    <div><dt>Best window</dt><dd>{{ $journey['season'] }}</dd></div>
                </dl>
            </aside>
        </div>
    </section>

    <section class="pj-manifesto">
        <div class="pj-shell pj-manifesto__grid">
            <div data-pj-reveal><p class="pj-label">Our point of view</p><h2>{{ $journey['philosophyTitle'] }}</h2></div>
            <div data-pj-reveal>
                <p class="pj-manifesto__lead">{{ $journey['philosophy'] }}</p>
                <div class="pj-detail-grid">
                    @foreach($journey['details'] as $detail)
                        <div><span>{{ $detail['label'] }}</span><strong>{{ $detail['value'] }}</strong></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="pj-route" id="premiumRoute">
        <div class="pj-shell">
            <header class="pj-heading" data-pj-reveal>
                <p class="pj-label">The route</p>
                <h2>A sequence with a reason.</h2>
                <div class="pj-route__line" aria-label="{{ implode(' to ', $journey['route']) }}">
                    @foreach($journey['route'] as $place)
                        <span>{{ $place }}</span>
                    @endforeach
                </div>
            </header>
            <div class="pj-route__chapters">
                @foreach($journey['routeNotes'] as $chapter)
                    <article data-pj-reveal>
                        <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <p>{{ $chapter['days'] }}</p>
                        <h3>{{ $chapter['city'] }}</h3>
                        <div>{{ $chapter['note'] }}</div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pj-moments">
        <div class="pj-shell">
            <header class="pj-heading pj-heading--split" data-pj-reveal>
                <div><p class="pj-label">The moments we protect</p><h2>Not everything important needs a ticket.</h2></div>
                <p>Small, well-timed experiences give a premium journey its texture.</p>
            </header>
            <div class="pj-moment-grid">
                @foreach($journey['moments'] as $moment)
                    <article data-pj-reveal>
                        <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $moment['title'] }}</h3>
                        <p>{{ $moment['text'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pj-gallery" data-pj-gallery>
        <div class="pj-shell">
            <header class="pj-heading pj-heading--split" data-pj-reveal>
                <div><p class="pj-label">Visual notebook</p><h2>A glimpse, not the whole story.</h2></div>
                <p>Click any image to open the gallery. Use the arrows or keyboard to continue.</p>
            </header>
            <div class="pj-gallery__grid">
                @foreach($journey['gallery'] as $image)
                    <button type="button" class="pj-gallery__item {{ $loop->first ? 'pj-gallery__item--lead' : '' }}"
                        data-pj-gallery-open="{{ $loop->index }}" aria-label="Open {{ $image['caption'] }}" data-pj-reveal>
                        <img src="{{ $image['src'] }}" alt="{{ $image['caption'] }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                        <span><small>{{ $image['location'] }}</small><strong>{{ $image['caption'] }}</strong></span>
                        <i class="bi bi-arrows-fullscreen"></i>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="pj-lightbox" data-pj-lightbox aria-hidden="true" role="dialog" aria-modal="true" aria-label="{{ $journey['name'] }} image gallery">
            <button type="button" class="pj-lightbox__close" data-pj-gallery-close aria-label="Close gallery"><i class="bi bi-x-lg"></i></button>
            <button type="button" class="pj-lightbox__nav pj-lightbox__nav--prev" data-pj-gallery-prev aria-label="Previous image"><i class="bi bi-arrow-left"></i></button>
            <figure>
                <img src="" alt="" data-pj-lightbox-image>
                <figcaption><span data-pj-lightbox-location></span><strong data-pj-lightbox-caption></strong><small data-pj-lightbox-count></small></figcaption>
            </figure>
            <button type="button" class="pj-lightbox__nav pj-lightbox__nav--next" data-pj-gallery-next aria-label="Next image"><i class="bi bi-arrow-right"></i></button>
        </div>
    </section>

    <section class="pj-stays">
        <div class="pj-shell pj-stays__layout">
            <div data-pj-reveal><p class="pj-label">Where the day ends</p><h2>Hotels chosen for their part in the route.</h2></div>
            <div class="pj-stays__list">
                @foreach($journey['stays'] as $stay)
                    <article data-pj-reveal>
                        <div><span>{{ $stay['place'] }}</span><h3>{{ $stay['style'] }}</h3></div>
                        <p>{{ $stay['note'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pj-quote">
        <div class="pj-shell" data-pj-reveal>
            <i class="bi bi-quote"></i>
            <blockquote>“{{ $journey['quote'] }}”</blockquote>
            <cite>{{ $journey['quoteBy'] }}</cite>
        </div>
    </section>

    @php
        $adminPackages = $journeyPackages ?? collect();
    @endphp

    <section class="pj-packages" id="journeyPackages">
        <div class="pj-shell">
            <header class="pj-heading pj-heading--split" data-pj-reveal>
                <div><p class="pj-label">Packages from admin</p><h2>{{ $journey['shortName'] }} journeys ready to book</h2></div>
                <p>Only International packages with matching destination keywords in the title appear here.</p>
            </header>

            @if($adminPackages->isNotEmpty())
                <div class="pj-package-grid">
                    @foreach($adminPackages as $package)
                        @php
                            $packageImage = \App\Support\MediaUrl::asset($package->image, 'images/couple-bg.jpg');
                            $packageDuration = $package->duration_text ?: ($package->days ? $package->days . ' days' : 'Flexible duration');
                            $packageHighlights = collect([$package->feature_1, $package->feature_2, $package->feature_3])->filter()->take(3);
                        @endphp
                        <article class="{{ $loop->iteration === 2 ? 'is-featured' : '' }}" data-pj-reveal>
                            <a class="pj-package-card__image" href="{{ route('packages.show', $package->slug) }}">
                                <img src="{{ $packageImage }}" alt="{{ $package->title }}"
                                    width="420"
                                    height="300"
                                    loading="{{ $loop->iteration <= 3 ? 'eager' : 'lazy' }}"
                                    fetchpriority="{{ $loop->first ? 'high' : 'auto' }}"
                                    decoding="async">
                                <span>{{ $package->category ?: 'International' }}</span>
                            </a>
                            <div class="pj-package-card__body">
                                <p>{{ $packageDuration }}</p>
                                <h3><a href="{{ route('packages.show', $package->slug) }}">{{ $package->title }}</a></h3>
                                @if($packageHighlights->isNotEmpty())
                                    <ul>
                                        @foreach($packageHighlights as $feature)
                                            <li><i class="bi bi-check2"></i>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="pj-package-card__footer">
                                    <div>
                                        <span>from</span>
                                        @if($package->old_price && $package->old_price > $package->price)
                                            <del>₹{{ number_format($package->old_price) }}</del>
                                        @endif
                                        <strong>{{ $package->price ? '₹' . number_format($package->price) : 'On request' }}</strong>
                                    </div>
                                    <a href="{{ route('packages.show', $package->slug) }}" aria-label="View {{ $package->title }}"><i class="bi bi-arrow-up-right"></i></a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <p class="pj-price-note">Final pricing and inclusions depend on dates, availability and traveller count.</p>
            @else
                <div class="pj-package-empty" data-pj-reveal>
                    <i class="bi bi-suitcase2"></i>
                    <h3>No matching package published yet</h3>
                    <p>Add an International package from the admin panel with a matching destination keyword in its title, and it will appear here automatically.</p>
                    <a href="{{ route('contact') }}" class="pj-button pj-button--solid">Request a private proposal <i class="bi bi-arrow-right"></i></a>
                </div>
            @endif
        </div>
    </section>

    <section class="pj-collection">
        <div class="pj-shell">
            <p class="pj-label" data-pj-reveal>Continue through the premium collection</p>
            <div class="pj-collection__grid">
                @foreach($premiumJourneys as $slug => $item)
                    @if($slug !== $journeySlug)
                        <a href="{{ route('premium-journeys.show', $slug) }}" data-pj-reveal>
                            <span>{{ $item['countries'] }}</span><strong>{{ $item['name'] }}</strong><i class="bi bi-arrow-up-right"></i>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="pj-cta" style="--pj-cta: url('{{ $journey['hero'] }}');">
        <div class="pj-shell" data-pj-reveal>
            <p class="pj-label">Private planning begins here</p>
            <h2>Bring us the dates. We will shape the journey.</h2>
            <p>We will return with a route, hotel point of view and starting budget—not a generic PDF with your name added.</p>
            <a href="{{ route('contact') }}" class="pj-button pj-button--solid">Request my proposal <i class="bi bi-arrow-right"></i></a>
        </div>
    </section>
</main>
