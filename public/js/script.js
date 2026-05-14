// Carousel script for the "Recommended Destinations" section.
(function () {
    'use strict';

    function initRecommendedSlider() {
        const track = document.getElementById('rdTrack');
        const prevBtn = document.getElementById('rdPrev');
        const nextBtn = document.getElementById('rdNext');
        const dotsEl = document.getElementById('rdDots');

        if (!track || !prevBtn || !nextBtn || !dotsEl) return;
        if (track.dataset.sliderInit === '1') return;
        track.dataset.sliderInit = '1';

        const cards = Array.from(track.querySelectorAll('.rd-card'));
        if (!cards.length) return;

        let current = 0;

        function gap() {
            const styles = window.getComputedStyle(track);
            return parseFloat(styles.columnGap || styles.gap) || 20;
        }

        function cardStep() {
            return cards[0].getBoundingClientRect().width + gap();
        }

        function visibleCount() {
            const outer = track.parentElement;
            const step = cardStep();
            if (!outer || step <= 0) return 1;
            return Math.max(1, Math.floor((outer.clientWidth + gap()) / step));
        }

        function maxIndex() {
            return Math.max(0, cards.length - visibleCount());
        }

        function updateDots() {
            Array.from(dotsEl.children).forEach((dot, index) => {
                dot.classList.toggle('rd-dot--active', index === current);
            });
        }

        function updateButtons() {
            prevBtn.disabled = current === 0;
            nextBtn.disabled = current >= maxIndex();
        }

        function goTo(index) {
            current = Math.max(0, Math.min(index, maxIndex()));
            track.style.transform = `translate3d(-${current * cardStep()}px, 0, 0)`;
            updateButtons();
            updateDots();
        }

        function buildDots() {
            dotsEl.innerHTML = '';
            for (let i = 0; i <= maxIndex(); i++) {
                const dot = document.createElement('button');
                dot.className = 'rd-dot';
                dot.type = 'button';
                dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                dot.addEventListener('click', () => goTo(i));
                dotsEl.appendChild(dot);
            }
        }

        prevBtn.addEventListener('click', () => goTo(current - 1));
        nextBtn.addEventListener('click', () => goTo(current + 1));

        let touchStartX = 0;
        track.addEventListener('touchstart', event => {
            touchStartX = event.changedTouches[0].clientX;
        }, { passive: true });

        track.addEventListener('touchend', event => {
            const delta = touchStartX - event.changedTouches[0].clientX;
            if (Math.abs(delta) > 40) {
                goTo(delta > 0 ? current + 1 : current - 1);
            }
        }, { passive: true });

        document.querySelectorAll('.rd-wishlist').forEach(button => {
            button.addEventListener('click', () => {
                const saved = button.dataset.saved === 'true';
                button.dataset.saved = String(!saved);
                button.classList.toggle('rd-wishlist--saved', !saved);
            });
        });

        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                buildDots();
                goTo(current);
            }, 120);
        });

        buildDots();
        goTo(0);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRecommendedSlider);
    } else {
        initRecommendedSlider();
    }
})();
