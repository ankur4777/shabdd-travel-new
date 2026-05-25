{{-- ============================================================
   HOLIDAYS BY THEME SECTION
   Modern horizontal slider with promotional content
   ============================================================ --}}

<section class="pilgrimage-section">
    <div class="pilgrimage-container">
        <div class="pilgrimage-promo">
            <div class="pilgrimage-promo-inner">
                <div class="pilgrimage-pattern" aria-hidden="true"></div>

                <div class="pilgrimage-content">
                    <p class="pilgrimage-small-heading">EXPLORE</p>
                    <h2 class="pilgrimage-main-heading">HOLIDAYS<br>BY THEME</h2>
                    <p class="pilgrimage-subheading">Pick from our specially curated packages</p>
                </div>
            </div>
        </div>

        <div class="pilgrimage-slider-wrap">
            <button class="pilgrimage-arrow pilgrimage-arrow-left" id="pilgrimageArrowLeft" aria-label="Previous" type="button">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="pilgrimage-slider" id="pilgrimageSlider" tabindex="0" aria-label="Pilgrimage tour cards">
                @forelse($pilgrimageTours as $tour)
                @php
                    $fallbackImages = [
                        'kedarnath' => 'https://images.unsplash.com/photo-1623082574085-157d955f8e3d?auto=format&fit=crop&w=900&q=80',
                        'varanasi' => 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=900&q=80',
                        'haridwar' => 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=900&q=80',
                        'rishikesh' => 'https://images.unsplash.com/photo-1583417267826-aebc4d1542e1?auto=format&fit=crop&w=900&q=80',
                        'amritsar' => 'https://images.unsplash.com/photo-1587914187980-3689e0d4e6cb?auto=format&fit=crop&w=900&q=80',
                        'jagannath-puri' => 'https://images.unsplash.com/photo-1606298855672-3efb63017be8?auto=format&fit=crop&w=900&q=80',
                        'shirdi' => 'https://images.unsplash.com/photo-1624862074295-2a8b4c5bc9b4?auto=format&fit=crop&w=900&q=80',
                        'tirupati' => 'https://images.unsplash.com/photo-1594453385841-a2b7e4f87e43?auto=format&fit=crop&w=900&q=80',
                    ];

                    $imagePath = (string) ($tour->image ?? '');
                    $imageSrc = '';

                    if ($imagePath !== '' && \Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://'])) {
                        $imageSrc = $imagePath;
                    } elseif ($imagePath !== '' && file_exists(public_path($imagePath))) {
                        $imageSrc = asset($imagePath);
                    } else {
                        $imageSrc = $fallbackImages[$tour->slug] ?? 'https://images.unsplash.com/photo-1502904550040-7534597429ae?auto=format&fit=crop&w=900&q=80';
                    }
                @endphp
                <article class="pilgrimage-card">
                    <div class="pilgrimage-card-img-wrap">
                        <img src="{{ $imageSrc }}" alt="{{ $tour->title }}" class="pilgrimage-card-img" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('images/himachal.jpg') }}';">
                        <div class="pilgrimage-card-overlay"></div>
                    </div>
                    <div class="pilgrimage-card-body">
                        <h3 class="pilgrimage-card-title">{{ $tour->title }}</h3>
                        <div class="pilgrimage-card-tags">
                            @foreach(($tour->tags ?? []) as $tag)
                                <span class="pilgrimage-tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('destinations.show', $tour->slug) }}" class="pilgrimage-btn">
                            VIEW MORE
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </article>
                @empty
                <div class="pilgrimage-empty">
                    <p>No spiritual places are available at the moment.</p>
                </div>
                @endforelse
            </div>

            <button class="pilgrimage-arrow pilgrimage-arrow-right" id="pilgrimageArrowRight" aria-label="Next" type="button">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
</section>

<script>
(function() {
    const slider = document.getElementById('pilgrimageSlider');
    const leftArrow = document.getElementById('pilgrimageArrowLeft');
    const rightArrow = document.getElementById('pilgrimageArrowRight');

    if (!slider || !leftArrow || !rightArrow) return;

    const cards = slider.querySelectorAll('.pilgrimage-card');
    if (cards.length === 0) return;

    function getCardWidth() {
        const gap = parseFloat(window.getComputedStyle(slider).columnGap || window.getComputedStyle(slider).gap || '0');
        return cards[0].getBoundingClientRect().width + gap;
    }

    function updateArrows() {
        const maxScrollLeft = slider.scrollWidth - slider.clientWidth;
        const atStart = slider.scrollLeft <= 5;
        const atEnd = slider.scrollLeft >= (maxScrollLeft - 5);

        leftArrow.disabled = atStart;
        rightArrow.disabled = atEnd;
    }

    function slideLeft() {
        slider.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
    }

    function slideRight() {
        slider.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
    }

    leftArrow.addEventListener('click', slideLeft);
    rightArrow.addEventListener('click', slideRight);

    slider.addEventListener('scroll', updateArrows, { passive: true });
    window.addEventListener('resize', updateArrows);

    slider.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowRight') {
            event.preventDefault();
            slideRight();
        } else if (event.key === 'ArrowLeft') {
            event.preventDefault();
            slideLeft();
        }
    });

    updateArrows();
})();
</script>
