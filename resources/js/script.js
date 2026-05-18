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


(function () {
    /* ── Slider ── */
    const track   = document.getElementById('tbTrack');
    const prevBtn = document.getElementById('tbPrev');
    const nextBtn = document.getElementById('tbNext');
    const dotsEl  = document.getElementById('tbDots');
 
    if (!track) return;
 
    let cards   = Array.from(track.children);
    let current = 0;
 
    function visibleCount() {
        const w = track.parentElement.offsetWidth;
        if (w >= 900) return 2;
        return 1;
    }
 
    function cardStep() {
        const card = cards.find(c => c.style.display !== 'none');
        if (!card) return 0;
        const gap = parseInt(getComputedStyle(track).gap) || 20;
        return card.offsetWidth + gap;
    }
 
    function visibleCards() {
        return cards.filter(c => c.style.display !== 'none');
    }
 
    function maxIndex() {
        return Math.max(0, visibleCards().length - visibleCount());
    }
 
    function goTo(idx) {
        current = Math.max(0, Math.min(idx, maxIndex()));
        track.style.transform = `translateX(-${current * cardStep()}px)`;
        if (prevBtn) prevBtn.disabled = current === 0;
        if (nextBtn) nextBtn.disabled = current >= maxIndex();
        updateDots();
    }
 
    function buildDots() {
        if (!dotsEl) return;
        dotsEl.innerHTML = '';
        const count = maxIndex() + 1;
        if (count <= 1) { dotsEl.style.display = 'none'; return; }
        dotsEl.style.display = 'flex';
        for (let i = 0; i < count; i++) {
            const d = document.createElement('button');
            d.className = 'tb-dot';
            d.setAttribute('aria-label', `Go to slide ${i + 1}`);
            d.addEventListener('click', () => goTo(i));
            dotsEl.appendChild(d);
        }
        updateDots();
    }
 
    function updateDots() {
        if (!dotsEl) return;
        Array.from(dotsEl.children).forEach((d, i) => {
            d.classList.toggle('tb-dot--active', i === current);
        });
    }
 
    /* Touch swipe */
    let tx = 0;
    track.addEventListener('touchstart', e => { tx = e.changedTouches[0].clientX; }, { passive: true });
    track.addEventListener('touchend',   e => {
        const delta = tx - e.changedTouches[0].clientX;
        if (Math.abs(delta) > 40) delta > 0 ? goTo(current + 1) : goTo(current - 1);
    }, { passive: true });
 
    if (prevBtn) prevBtn.addEventListener('click', () => goTo(current - 1));
    if (nextBtn) nextBtn.addEventListener('click', () => goTo(current + 1));
 
    /* Resize */
    let rt;
    window.addEventListener('resize', () => {
        clearTimeout(rt);
        rt = setTimeout(() => { buildDots(); goTo(Math.min(current, maxIndex())); }, 120);
    });
 
    /* ── Category Filter Tabs ── */
    const tabs = document.querySelectorAll('.tb-tab');
    const featured = document.querySelector('.tb-featured');
 
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => { t.classList.remove('tb-tab--active'); t.setAttribute('aria-selected', 'false'); });
            tab.classList.add('tb-tab--active');
            tab.setAttribute('aria-selected', 'true');
 
            const cat = tab.dataset.category;
            current = 0;
            track.style.transform = 'translateX(0)';
 
            cards.forEach(card => {
                const cardCat = card.dataset.category;
                const show = cat === 'all' || cardCat === cat;
                card.style.display = show ? 'flex' : 'none';
            });
 
            /* Featured visibility */
            if (featured) {
                const featCat = featured.dataset.category;
                featured.style.opacity = (cat === 'all' || featCat === cat) ? '1' : '0.35';
            }
 
            buildDots();
            goTo(0);
        });
    });
 
    /* ── Bookmark toggle ── */
    document.querySelectorAll('.tb-bookmark').forEach(btn => {
        btn.addEventListener('click', () => {
            const saved = btn.dataset.saved === 'true';
            btn.dataset.saved = saved ? 'false' : 'true';
            btn.setAttribute('aria-pressed', !saved);
        });
    });
 
    /* ── Init ── */
    buildDots();
    goTo(0);
})();
 
/* Newsletter */
function tbHandleNewsletter(e) {
    e.preventDefault();
    const btn  = e.target.querySelector('.tb-newsletter-btn');
    const input = e.target.querySelector('.tb-newsletter-input');
    btn.textContent  = 'Subscribed ✓';
    btn.style.background = '#22c55e';
    input.value = '';
    setTimeout(() => {
        btn.textContent  = 'Subscribe';
        btn.style.background = '';
    }, 3000);
}

 (function () {
            const hero = document.querySelector('.hero-3d');
            if (!hero) return;
            const layers = {
                back: hero.querySelector('.hero-layer--back'),
                mid: hero.querySelector('.hero-layer--mid'),
                front: hero.querySelector('.hero-layer--front')
            };

            // Initialize background images for layers
            const bg = getComputedStyle(hero).backgroundImage;
            Object.values(layers).forEach(l => { if (l) l.style.backgroundImage = bg; });

            // Parallax / tilt handler
            let rect = hero.getBoundingClientRect();
            const clamp = (v, a, b) => Math.max(a, Math.min(b, v));

            function onMove(x, y) {
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = (x - cx) / rect.width;
                const dy = (y - cy) / rect.height;

                const rx = clamp(dy * -6, -10, 10);
                const ry = clamp(dx * 10, -15, 15);

                if (layers.back) layers.back.style.transform = `translateZ(-120px) scale(1.15) translate(${ry * 0.6}px, ${rx * 0.6}px)`;
                if (layers.mid) layers.mid.style.transform = `translateZ(-40px) scale(1.06) translate(${ry * 0.9}px, ${rx * 0.9}px)`;
                if (layers.front) layers.front.style.transform = `translateZ(0px) scale(1) translate(${ry}px, ${rx}px)`;

                // slight tilt of copy
                const copy = hero.querySelector('.destination-st-hero-copy');
                if (copy) copy.style.transform = `translateZ(30px) rotateX(${rx * 0.15}deg) rotateY(${ry * 0.12}deg)`;
            }

            let raf = null;
            function pointerMove(e) {
                const p = e.touches ? e.touches[0] : e;
                if (raf) cancelAnimationFrame(raf);
                raf = requestAnimationFrame(() => onMove(p.clientX, p.clientY));
            }

            function updateRect() { rect = hero.getBoundingClientRect(); }
            window.addEventListener('resize', updateRect);
            hero.addEventListener('mousemove', pointerMove);
            hero.addEventListener('touchmove', pointerMove, { passive: true });
            hero.addEventListener('mouseleave', () => {
                // reset transforms
                if (layers.back) layers.back.style.transform = '';
                if (layers.mid) layers.mid.style.transform = '';
                if (layers.front) layers.front.style.transform = '';
                const copy = hero.querySelector('.destination-st-hero-copy');
                if (copy) copy.style.transform = '';
            });
        })();