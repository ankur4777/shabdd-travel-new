{{-- ============================================================
   PILGRIMAGE TOURS SECTION
   Dynamic horizontal slider with left promotional content
   ============================================================ --}}

@props(['destinations' => []])

<section class="pilgrimage-section" id="pilgrimageSection">
    <div class="pilgrimage-container">
        
        {{-- Left Side: Promotional Content --}}
        <div class="pilgrimage-promo">
            <div class="pilgrimage-promo-inner">
                {{-- Background Pattern --}}
                <div class="pilgrimage-mandala" aria-hidden="true">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="mandalaPattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                                <circle cx="50" cy="50" r="30" fill="none" stroke="rgba(255,140,0,0.08)" stroke-width="1"/>
                                <circle cx="50" cy="50" r="20" fill="none" stroke="rgba(255,140,0,0.06)" stroke-width="1"/>
                                <circle cx="50" cy="50" r="10" fill="none" stroke="rgba(255,140,0,0.04)" stroke-width="1"/>
                            </pattern>
                        </defs>
                        <rect width="200" height="200" fill="url(#mandalaPattern)"/>
                    </svg>
                </div>

                {{-- Traveler Image --}}
                <div class="pilgrimage-traveler-img">
                    <img src="https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=600&q=80" 
                         alt="Indian Traveler" 
                         loading="lazy">
                </div>

                {{-- Text Content --}}
                <div class="pilgrimage-promo-content">
                    <span class="pilgrimage-eyebrow">EXPLORE</span>
                    <h2 class="pilgrimage-promo-title">PILGRIMAGE<br>TOURS</h2>
                    <p class="pilgrimage-promo-text">
                        Discover India's most sacred spiritual destinations with specially curated pilgrimage packages.
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Side: Destination Cards Slider --}}
        <div class="pilgrimage-slider-wrap">
            {{-- Navigation Arrows --}}
            <button class="pilgrimage-arrow pilgrimage-arrow-left" 
                    id="pilgrimageArrowLeft" 
                    aria-label="Previous destinations"
                    style="display:none;">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" 
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            {{-- Cards Track --}}
            <div class="pilgrimage-track-outer">
                <div class="pilgrimage-track" id="pilgrimageTrack">
                    @forelse($destinations as $destination)
                        <article class="pilgrimage-card">
                            <div class="pilgrimage-card-img-wrap">
                                <img src="{{ $destination->image_url }}" 
                                     alt="{{ $destination->name }}" 
                                     class="pilgrimage-card-img"
                                     loading="lazy">
                                <div class="pilgrimage-card-overlay"></div>
                            </div>
                            
                            <div class="pilgrimage-card-body">
                                <h3 class="pilgrimage-card-title">{{ $destination->name }}</h3>
                                
                                @if($destination->tags && count($destination->tags) > 0)
                                    <div class="pilgrimage-tags">
                                        @foreach(array_slice($destination->tags, 0, 4) as $tag)
                                            <span class="pilgrimage-tag">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <a href="{{ route('destinations.show', $destination->slug) }}" 
                                   class="pilgrimage-btn">
                                    VIEW MORE
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" 
                                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="pilgrimage-empty">
                            <p>No pilgrimage destinations available at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <button class="pilgrimage-arrow pilgrimage-arrow-right" 
                    id="pilgrimageArrowRight" 
                    aria-label="Next destinations">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.5" 
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

    </div>
</section>

{{-- JavaScript for Slider Functionality --}}
@push('scripts')
<script>
(function() {
    const track = document.getElementById('pilgrimageTrack');
    const arrowLeft = document.getElementById('pilgrimageArrowLeft');
    const arrowRight = document.getElementById('pilgrimageArrowRight');
    
    if (!track || !arrowLeft || !arrowRight) return;
    
    const cards = Array.from(track.children);
    const totalCards = cards.length;
    
    if (totalCards === 0) return;
    
    let currentIndex = 0;
    
    function getVisibleCount() {
        const trackWidth = track.offsetWidth;
        const cardWidth = cards[0]?.offsetWidth || 280;
        const gap = 20;
        return Math.max(1, Math.floor(trackWidth / (cardWidth + gap)));
    }
    
    function maxIndex() {
        return Math.max(0, totalCards - getVisibleCount());
    }
    
    function getCardStep() {
        const card = cards[0];
        if (!card) return 300;
        const gap = 20;
        return card.offsetWidth + gap;
    }
    
    function updateTransform() {
        const step = getCardStep();
        track.style.transform = `translateX(-${currentIndex * step}px)`;
    }
    
    function updateArrows() {
        const max = maxIndex();
        arrowLeft.style.display = currentIndex <= 0 ? 'none' : 'flex';
        arrowRight.style.display = currentIndex >= max ? 'none' : 'flex';
    }
    
    function slideRight() {
        if (currentIndex < maxIndex()) {
            currentIndex++;
            updateTransform();
            updateArrows();
        }
    }
    
    function slideLeft() {
        if (currentIndex > 0) {
            currentIndex--;
            updateTransform();
            updateArrows();
        }
    }
    
    arrowRight.addEventListener('click', slideRight);
    arrowLeft.addEventListener('click', slideLeft);
    
    // Touch support
    let touchStartX = 0;
    track.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].clientX;
    }, { passive: true });
    
    track.addEventListener('touchend', (e) => {
        const delta = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(delta) > 50) {
            delta > 0 ? slideRight() : slideLeft();
        }
    }, { passive: true });
    
    // Resize handler
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            currentIndex = Math.min(currentIndex, maxIndex());
            updateTransform();
            updateArrows();
        }, 150);
    });
    
    // Initialize
    updateTransform();
    updateArrows();
})();
</script>
@endpush
