@extends('layouts.app')

@section('content')
    @php
        $pd = $packagePageData;
        $galleryImages = $pd['gallery_images'] ?? [];
        $mainImage = $pd['main_image'] ?? $destination->image_url;
        $hotelImage = $pd['hotel_image'] ?: $mainImage;
        $packageUrl = url()->current();
        $packageFaqs = $pd['faqs'] ?? [];
        $packageGalleryItems = collect([$mainImage])
            ->merge($galleryImages)
            ->filter()
            ->unique()
            ->values()
            ->map(fn ($image, $index) => [
                'image' => $image,
                'alt' => $pd['package_title'] . ' gallery image ' . ($index + 1),
                'label' => $pd['package_title'] . ' photo ' . ($index + 1),
            ]);
    @endphp

    <section id="xpkd-root-shell" class="xpkd-page-shell">
        <div class="container xpkd-container-wrap">
            <nav class="xpkd-breadcrumb-line" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('destinations.show', $destination) }}">{{ $destination->name }}</a>
                <span>/</span>
                <strong>{{ $pd['package_title'] }}</strong>
            </nav>

            <header class="xpkd-head-cluster">
                <p class="xpkd-head-kicker">{{ $pd['destination_tagline'] }}</p>
                <h1 class="xpkd-head-title">{{ $pd['package_title'] }}</h1>
                <div class="xpkd-head-metrics">
                    <span>{{ $pd['night_count'] }} Nights / {{ $pd['day_count'] }} Days</span>
                    <span>{{ $pd['package_rating'] }}/5 Rating</span>
                    <span>{{ number_format((int) $pd['review_count']) }} Reviews</span>
                </div>
            </header>

            <div class="xpkd-grid-shell">
                <main class="xpkd-main-column">
                    <section class="xpkd-hero-media-card">
                        <div class="xpkd-hero-media-main">
                            <button type="button" class="xpkd-gallery-trigger xpkd-gallery-trigger-main"
                                data-xpkd-gallery-open data-xpkd-gallery-index="0"
                                aria-label="Open {{ $pd['package_title'] }} gallery image 1">
                                <img src="{{ $mainImage }}" alt="{{ $pd['package_title'] }}" loading="lazy">
                            </button>
                        </div>
                        @if(count($galleryImages) > 0)
                            <div class="xpkd-hero-media-strip">
                                @foreach(array_slice($galleryImages, 0, 3) as $index => $image)
                                    @php
                                        $galleryIndex = $packageGalleryItems->search(fn ($item) => $item['image'] === $image);
                                    @endphp
                                    <button type="button" class="xpkd-gallery-trigger"
                                        data-xpkd-gallery-open data-xpkd-gallery-index="{{ $galleryIndex === false ? $index + 1 : $galleryIndex }}"
                                        aria-label="Open {{ $pd['package_title'] }} gallery image {{ $index + 2 }}">
                                        <img src="{{ $image }}" alt="{{ $pd['package_title'] }} gallery image" loading="lazy">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </section>



                    <nav class="xpkd-anchor-tabs" aria-label="Package sections">
                        <a href="#xpkd-overview-block">Overview</a>
                        <a href="#xpkd-hotel-block">Hotel Details</a>
                        <a href="#xpkd-itinerary-block">Day Wise Itinerary</a>
                        <a href="#xpkd-inclexc-block">Inclusions / Exclusions</a>
                        @if(!empty($packageFaqs))
                            <a href="#xpkd-faq-block">FAQs</a>
                        @endif
                    </nav>

                    <section id="xpkd-overview-block" class="xpkd-content-card">
                        <h2>Package Overview</h2>
                        <div class="xpkd-overview-copy">{!! $pd['overview_text'] !!}</div>

                        <div class="xpkd-highlight-badges">
                            @foreach($pd['highlight_points'] as $point)
                                <span>{{ $point }}</span>
                            @endforeach
                        </div>
                    </section>

                    <section id="xpkd-hotel-block" class="xpkd-content-card">
                        <h2>Hotel Details</h2>
                        <article class="xpkd-hotel-panel">
                            <div class="xpkd-hotel-image">
                                <img src="{{ $hotelImage }}" alt="{{ $pd['hotel_name'] }}" loading="lazy">
                            </div>
                            <div class="xpkd-hotel-copy">
                                <h3>{{ $pd['hotel_name'] }}</h3>
                                <p>{{ $pd['hotel_category'] }} • {{ $pd['hotel_area'] }}</p>
                                <ul>
                                    @foreach($pd['hotel_highlights'] as $hotelHighlight)
                                        <li>{{ $hotelHighlight }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </article>
                    </section>

                    <section id="xpkd-itinerary-block" class="xpkd-content-card">
                        <h2>Day Wise Itinerary</h2>
                        <div class="xpkd-itinerary-stack">
                            @foreach($pd['itinerary_items'] as $dayItem)
                                <article class="xpkd-itinerary-card">
                                    <span class="xpkd-itinerary-day">Day {{ $dayItem['day'] }}</span>
                                    <h3>{{ $dayItem['title'] }}</h3>
                                    <p>{{ $dayItem['summary'] }}</p>
                                </article>
                            @endforeach
                        </div>
                    </section>

                    <section id="xpkd-inclexc-block" class="xpkd-content-card">
                        <h2>Inclusions / Exclusions</h2>
                        <div class="xpkd-inclexc-grid">
                            <article class="xpkd-inclexc-box xpkd-inclexc-box-in">
                                <h3>Inclusions</h3>
                                <ul>
                                    @foreach($pd['inclusions'] as $inclusion)
                                        <li>{{ $inclusion }}</li>
                                    @endforeach
                                </ul>
                            </article>
                            <article class="xpkd-inclexc-box xpkd-inclexc-box-ex">
                                <h3>Exclusions</h3>
                                <ul>
                                    @foreach($pd['exclusions'] as $exclusion)
                                        <li>{{ $exclusion }}</li>
                                    @endforeach
                                </ul>
                            </article>
                        </div>
                    </section>

                    @if(!empty($packageFaqs))
                        <section id="xpkd-faq-block" class="seo-dd-section seo-dd-faq-section xpkd-faq-section" itemscope itemtype="https://schema.org/FAQPage">
                            <div class="seo-dd-faq-copy">
                                <h2>General Questions asked by customers.</h2>
                                <div class="seo-dd-faq-support">
                                    <p>Our friendly team is always here to help you with quick, clear, and reliable answers whenever needed.</p>
                                    <a href="{{ route('contact') }}" class="seo-dd-faq-cta">Contact Sales</a>
                                </div>
                            </div>
                            <div class="seo-dd-faq-list">
                                @foreach($packageFaqs as $index => $faq)
                                    <article class="seo-dd-faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                                        <button class="seo-dd-faq-btn {{ $index === 0 ? 'is-open' : '' }}" type="button"
                                            data-xpkd-faq-toggle aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                            <span itemprop="name">{{ $faq['question'] ?? ($faq['q'] ?? '') }}</span>
                                            <span class="seo-dd-faq-icon" aria-hidden="true"></span>
                                        </button>
                                        <div class="seo-dd-faq-panel {{ $index === 0 ? 'is-open' : '' }}" itemscope
                                            itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                            <p itemprop="text">{{ $faq['answer'] ?? ($faq['a'] ?? '') }}</p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if(!empty($pd['other_packages']))
                        <section class="xpkd-content-card">
                            <h2>More {{ $destination->name }} Packages</h2>
                            <div class="xpkd-other-pack-grid">
                                @foreach($pd['other_packages'] as $otherPackage)
                                    <article class="xpkd-other-pack-card">
                                        <p>{{ $otherPackage['duration'] ?? '5D/4N' }}</p>
                                        <h3>{{ $otherPackage['name'] }}</h3>
                                        <strong>{{ $otherPackage['discounted_price'] ?: ($otherPackage['price'] ?? '') }}</strong>
                                        <a href="{{ $otherPackage['detail_url'] ?? '#' }}">View Details</a>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </main>

                <aside class="xpkd-side-column">
                    <article class="xpkd-package-info-card">

                        @if(!empty($pd['pdf_url']))
                            <div class="xpkd-pdf-download-section">
                                <a href="{{ $pd['pdf_url'] }}" class="xpkd-pdf-btn" download>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Download PDF
                                </a>
                            </div>
                        @endif

                        <div class="xpkd-includes-section">
                            <h4>Package Includes</h4>
                            <div class="xpkd-includes-grid">
                                <div class="xpkd-include-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    <span>Hotel</span>
                                </div>
                                <div class="xpkd-include-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                                    </svg>
                                    <span>Sightseeing</span>
                                </div>
                                <div class="xpkd-include-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path d="M9 10h6v4H9z"></path>
                                    </svg>
                                    <span>Transfer</span>
                                </div>
                                <div class="xpkd-include-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <path d="M12 5v14M7 12h10M5 8l14 8M5 16l14-8"></path>
                                    </svg>
                                    <span>Meal</span>
                                </div>
                            </div>
                        </div>

                        <div class="xpkd-side-split"></div>
                    </article>

                    <article class="xpkd-booking-card">
                        <p class="xpkd-price-kicker">Starting From</p>
                        <h3>{{ $pd['starting_price'] }}</h3>
                        @if(!empty($pd['original_price']) && $pd['original_price'] !== $pd['starting_price'])
                            <p class="xpkd-strike-price">{{ $pd['original_price'] }}</p>
                        @endif
                        <p class="xpkd-price-note">Per person on twin sharing</p>

                        <a href="#" class="xpkd-cta-btn">Send Enquiry</a>
                        <a href="https://wa.me/" target="_blank" rel="noopener"
                            class="xpkd-cta-btn xpkd-cta-btn-lite">WhatsApp Expert</a>

                        <div class="xpkd-side-split"></div>
                        <ul class="xpkd-side-facts">
                            <li><span>Duration</span><strong>{{ $pd['package_duration'] }}</strong></li>
                            <li><span>Destination</span><strong>{{ $destination->name }}</strong></li>
                            <li><span>Rating</span><strong>{{ $pd['package_rating'] }}/5</strong></li>
                        </ul>
                    </article>

                    <article class="xpkd-support-card">
                        <h4>Need Help?</h4>
                        <a href="tel:{{ preg_replace('/\s+/', '', $pd['contact_phone']) }}">{{ $pd['contact_phone'] }}</a>
                        <a href="mailto:{{ $pd['contact_email'] }}">{{ $pd['contact_email'] }}</a>
                    </article>
                </aside>
            </div>
        </div>
    </section>
    <!-- Package Section Card -->
    <section class="CTA-section-container"
        style="background-image: url('{{ $mainImage }}'); background-size: cover; background-position: center;">
        <div class="CTA-section-overlay"></div>
        <div class="CTA-section-content">

            <div class="CTA-section-main">
                <h2 class="CTA-section-title">{{ $pd['package_title'] }}</h2>
                <p class="CTA-section-description">{{ strip_tags($pd['overview_text']) }}</p>

                <div class="CTA-section-columns">

                    <!-- Right Column -->
                    <div class="CTA-section-col CTA-section-col-right">
                        <div class="CTA-section-info-box">
                            <h3 class="CTA-section-subtitle">⛏️ Difficulty</h3>
                            <p class="CTA-section-difficulty">{{ $pd['difficulty'] }}</p>
                            <h3 class="CTA-section-subtitle">🌤️ Seasons</h3>
                            @foreach($pd['seasons'] as $season)
                                <div class="CTA-section-season-item">
                                    <strong>{{ $season['name'] }}</strong>
                                    <small>{{ $season['note'] }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </section>

    @if($packageGalleryItems->isNotEmpty())
        <div class="xpkd-gallery-modal" id="xpkdGalleryModal" aria-hidden="true">
            <div class="xpkd-gallery-modal-backdrop" data-xpkd-gallery-close></div>
            <div class="xpkd-gallery-modal-panel" role="dialog" aria-modal="true" aria-label="{{ $pd['package_title'] }} gallery">
                <button type="button" class="xpkd-gallery-modal-close" data-xpkd-gallery-close aria-label="Close gallery">&times;</button>
                <button type="button" class="xpkd-gallery-modal-nav xpkd-gallery-modal-prev" data-xpkd-gallery-prev aria-label="Previous image">&lsaquo;</button>
                <img class="xpkd-gallery-modal-image" src="{{ $packageGalleryItems->first()['image'] }}" alt="{{ $packageGalleryItems->first()['alt'] }}" data-xpkd-gallery-image>
                <button type="button" class="xpkd-gallery-modal-nav xpkd-gallery-modal-next" data-xpkd-gallery-next aria-label="Next image">&rsaquo;</button>
                <div class="xpkd-gallery-modal-caption">
                    <strong data-xpkd-gallery-caption>{{ $packageGalleryItems->first()['label'] }}</strong>
                    <span data-xpkd-gallery-count>1 / {{ $packageGalleryItems->count() }}</span>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const packageGalleryItems = @json($packageGalleryItems->values());
            const galleryModal = document.getElementById('xpkdGalleryModal');
            const galleryImage = galleryModal ? galleryModal.querySelector('[data-xpkd-gallery-image]') : null;
            const galleryCaption = galleryModal ? galleryModal.querySelector('[data-xpkd-gallery-caption]') : null;
            const galleryCount = galleryModal ? galleryModal.querySelector('[data-xpkd-gallery-count]') : null;
            let galleryIndex = 0;

            const renderGalleryImage = function (index) {
                if (!packageGalleryItems.length || !galleryImage) {
                    return;
                }

                galleryIndex = (index + packageGalleryItems.length) % packageGalleryItems.length;
                const item = packageGalleryItems[galleryIndex];
                galleryImage.src = item.image;
                galleryImage.alt = item.alt || item.label || '';

                if (galleryCaption) {
                    galleryCaption.textContent = item.label || '';
                }

                if (galleryCount) {
                    galleryCount.textContent = `${galleryIndex + 1} / ${packageGalleryItems.length}`;
                }
            };

            const openGallery = function (index) {
                if (!galleryModal || !packageGalleryItems.length) {
                    return;
                }

                renderGalleryImage(index);
                galleryModal.classList.add('is-open');
                galleryModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('xpkd-gallery-modal-open');
            };

            const closeGallery = function () {
                if (!galleryModal) {
                    return;
                }

                galleryModal.classList.remove('is-open');
                galleryModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('xpkd-gallery-modal-open');
            };

            document.querySelectorAll('[data-xpkd-gallery-open]').forEach(function (button) {
                button.addEventListener('click', function () {
                    openGallery(Number(button.dataset.xpkdGalleryIndex || 0));
                });
            });

            if (galleryModal) {
                galleryModal.querySelectorAll('[data-xpkd-gallery-close]').forEach(function (button) {
                    button.addEventListener('click', closeGallery);
                });

                const previousButton = galleryModal.querySelector('[data-xpkd-gallery-prev]');
                const nextButton = galleryModal.querySelector('[data-xpkd-gallery-next]');

                if (previousButton) {
                    previousButton.addEventListener('click', function () {
                        renderGalleryImage(galleryIndex - 1);
                    });
                }

                if (nextButton) {
                    nextButton.addEventListener('click', function () {
                        renderGalleryImage(galleryIndex + 1);
                    });
                }
            }

            document.addEventListener('keydown', function (event) {
                if (!galleryModal || !galleryModal.classList.contains('is-open')) {
                    return;
                }

                if (event.key === 'Escape') {
                    closeGallery();
                } else if (event.key === 'ArrowLeft') {
                    renderGalleryImage(galleryIndex - 1);
                } else if (event.key === 'ArrowRight') {
                    renderGalleryImage(galleryIndex + 1);
                }
            });

            document.querySelectorAll('[data-xpkd-faq-toggle]').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const panel = toggle.nextElementSibling;
                    const faqSection = toggle.closest('.seo-dd-faq-section') || document;
                    if (!panel) {
                        return;
                    }
                    const isOpen = panel.classList.contains('is-open');

                    faqSection.querySelectorAll('.seo-dd-faq-btn').forEach(function (btn) {
                        btn.classList.remove('is-open');
                        btn.setAttribute('aria-expanded', 'false');
                    });
                    faqSection.querySelectorAll('.seo-dd-faq-panel').forEach(function (item) {
                        item.classList.remove('is-open');
                    });

                    if (!isOpen) {
                        toggle.classList.add('is-open');
                        toggle.setAttribute('aria-expanded', 'true');
                        panel.classList.add('is-open');
                    }
                });
            });

        });
    </script>
@endpush
