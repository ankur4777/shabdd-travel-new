{{-- ============================================================
   HOLIDAYS BY THEME SECTION
   Modern horizontal slider with promotional content
   ============================================================ --}}

<section class="pilgrimage-section">
    <div class="pilgrimage-container">
        
        {{-- Left Side: Promotional Content --}}
        <div class="pilgrimage-promo">
            <div class="pilgrimage-promo-inner">
                {{-- Background Pattern --}}
                <div class="pilgrimage-pattern" aria-hidden="true"></div>
                
                {{-- Traveler Image --}}
                <div class="pilgrimage-traveler">
                    <img src="{{ asset('images/indian-traveler.png') }}" alt="Traveler" loading="lazy">
                </div>
                
                {{-- Content --}}
                <div class="pilgrimage-content">
                    <p class="pilgrimage-small-heading">EXPLORE</p>
                    <h2 class="pilgrimage-main-heading">HOLIDAYS<br>BY THEME</h2>
                    <p class="pilgrimage-subheading">Pick from our specially curated packages</p>
                </div>
            </div>
        </div>

        {{-- Right Side: Slider --}}
        <div class="pilgrimage-slider-wrap">
            {{-- Navigation Arrows --}}
            <button class="pilgrimage-arrow pilgrimage-arrow-left" id="pilgrimageArrowLeft" aria-label="Previous" type="button">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            {{-- Cards Container --}}
            <div class="pilgrimage-slider" id="pilgrimageSlider" tabindex="0" aria-label="Pilgrimage tour cards">
                @forelse($pilgrimageTours as $tour)
                <article class="pilgrimage-card">
                    <div class="pilgrimage-card-img-wrap">
                        <img src="{{ asset($tour->image) }}" alt="{{ $tour->title }}" class="pilgrimage-card-img" loading="lazy">
                        <div class="pilgrimage-card-overlay"></div>
                    </div>
                    <div class="pilgrimage-card-body">
                        <h3 class="pilgrimage-card-title">{{ $tour->title }}</h3>
                        <div class="pilgrimage-card-tags">
                            @foreach($tour->tags as $tag)
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
                    <p>No pilgrimage tours available at the moment.</p>
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

{{-- JavaScript for Slider --}}
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
