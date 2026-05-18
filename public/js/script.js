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
    const pageSearchData = window.ST_PAGE_SEARCH_DATA || {};

    /* ── Destination data ── */
    const defaultLocations = [
        { label: 'Himachal Pradesh', icon: '🏔️' },
        { label: 'Kangra, Himachal',  icon: '🏔️' },
        { label: 'Kullu, Himachal',   icon: '🏔️' },
        { label: 'Kasauli, Himachal', icon: '🏔️' },
        { label: 'Shimla',            icon: '❄️' },
        { label: 'Manali',            icon: '🌨️' },
        { label: 'Goa',               icon: '🏖️' },
        { label: 'Kerala',            icon: '🌴' },
        { label: 'Kashmir',           icon: '🏔️' },
        { label: 'Rajasthan',         icon: '🏜️' },
        { label: 'Andaman',           icon: '🌊' },
        { label: 'Coorg',             icon: '☕' },
        { label: 'Dubai',             icon: '🌆' },
        { label: 'Bali',              icon: '🌺' },
        { label: 'Thailand',          icon: '🐘' },
        { label: 'Maldives',          icon: '🏝️' },
        { label: 'Switzerland',       icon: '🏔️' },
        { label: 'Singapore',         icon: '🦁' },
        { label: 'Malaysia',          icon: '🌆' },
        { label: 'Vietnam',           icon: '🍜' },
        { label: 'Japan',             icon: '⛩️' },
    ];

    const SB_LOCATIONS = (Array.isArray(pageSearchData.locations) && pageSearchData.locations.length
        ? pageSearchData.locations
        : defaultLocations
    ).map(item => (typeof item === 'string' ? { label: item, icon: '' } : item));
 
    const SB_PRICES = [
        { label: 'Any Budget',           icon: '💰', value: 'any'   },
        { label: 'Under ₹25,000',        icon: '💚', value: '25000' },
        { label: '₹25,000 – ₹50,000',   icon: '💛', value: '50000' },
        { label: '₹50,000 – ₹1,00,000', icon: '🧡', value: '100000'},
        { label: 'Luxury ₹1,00,000+',   icon: '👑', value: 'luxury'},
    ];
 
    /* ── Build upcoming 12 months ── */
    function getMonths() {
        if (Array.isArray(pageSearchData.months) && pageSearchData.months.length) {
            return pageSearchData.months;
        }

        const now = new Date();
        return Array.from({ length: 12 }, (_, i) => {
            const d = new Date(now.getFullYear(), now.getMonth() + i, 1);
            return d.toLocaleString('en-IN', { month: 'long', year: 'numeric' });
        });
    }
 
    /* ── Render helpers ── */
    function renderList(containerId, items, onSelect) {
        const el = document.getElementById(containerId);
        if (!el) return;
        el.innerHTML = items.length
            ? items.map(i =>
                `<div class="st-sb-dropdown-item" data-val="${i.label || i}">
                    <span class="sb-item-icon">${i.icon || ''}</span>
                    ${i.label || i}
                 </div>`).join('')
            : `<div class="st-sb-dropdown-item" style="color:#9ca3af;cursor:default;">No results found</div>`;
        el.querySelectorAll('[data-val]').forEach(el =>
            el.addEventListener('click', () => onSelect(el.dataset.val))
        );
    }
 
    /* ── Close all dropdowns ── */
    function closeAll() {
        document.querySelectorAll('.st-sb-dropdown').forEach(d => d.classList.remove('sb-show'));
        document.querySelectorAll('.st-sb-field').forEach(f => f.classList.remove('sb-open'));
    }
 
    /* ── Location ── */
    const locField = document.getElementById('sbLocField');
    if (locField) {
        locField.addEventListener('click', function (e) {
            if (e.target === document.getElementById('sbLocSearch')) return;
            const dd = document.getElementById('sbLocDropdown');
            const wasOpen = dd.classList.contains('sb-show');
            closeAll();
            if (!wasOpen) {
                renderList('sbLocList', SB_LOCATIONS, val => {
                    document.getElementById('sbLocInput').value = val;
                    closeAll();
                });
                dd.classList.add('sb-show');
                this.classList.add('sb-open');
                setTimeout(() => document.getElementById('sbLocSearch')?.focus(), 50);
            }
        });
        const locSearch = document.getElementById('sbLocSearch');
        if (locSearch) {
            locSearch.addEventListener('input', function () {
                const q = this.value.toLowerCase();
                const filtered = SB_LOCATIONS.filter(l => l.label.toLowerCase().includes(q));
                renderList('sbLocList', filtered, val => {
                    document.getElementById('sbLocInput').value = val;
                    closeAll();
                });
            });
            locSearch.addEventListener('click', e => e.stopPropagation());
        }
    }
 
    /* ── Month ── */
    const monthField = document.getElementById('sbMonthField');
    if (monthField) {
        monthField.addEventListener('click', function () {
            const dd = document.getElementById('sbMonthDropdown');
            const wasOpen = dd.classList.contains('sb-show');
            closeAll();
            if (!wasOpen) {
                const months = getMonths().map(m => ({ label: m, icon: '' }));
                // render directly into dropdown (no sub-list div needed)
                dd.innerHTML = months.map(m =>
                    `<div class="st-sb-dropdown-item" data-val="${m.label}">
                        <span class="sb-item-icon">${m.icon}</span>${m.label}
                     </div>`).join('');
                dd.querySelectorAll('[data-val]').forEach(el =>
                    el.addEventListener('click', () => {
                        document.getElementById('sbMonthInput').value = el.dataset.val;
                        closeAll();
                    })
                );
                dd.classList.add('sb-show');
                this.classList.add('sb-open');
            }
        });
    }
 
    /* ── Price ── */
    const priceField = document.getElementById('sbPriceField');
    if (priceField) {
        priceField.addEventListener('click', function () {
            const dd = document.getElementById('sbPriceDropdown');
            const wasOpen = dd.classList.contains('sb-show');
            closeAll();
            if (!wasOpen) {
                dd.innerHTML = SB_PRICES.map(p =>
                    `<div class="st-sb-dropdown-item" data-val="${p.label}">
                        <span class="sb-item-icon">${p.icon}</span>${p.label}
                     </div>`).join('');
                dd.querySelectorAll('[data-val]').forEach(el =>
                    el.addEventListener('click', () => {
                        document.getElementById('sbPriceInput').value = el.dataset.val;
                        closeAll();
                    })
                );
                dd.classList.add('sb-show');
                this.classList.add('sb-open');
            }
        });
    }
 
    /* ── Close on outside click ── */
    document.addEventListener('click', function (e) {
        const bar = document.getElementById('heroSearchbar');
        if (bar && !bar.contains(e.target)) closeAll();
    });
 
})();
