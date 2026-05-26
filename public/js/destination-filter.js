/**
 * SHABDD TRAVEL — Destination Filter JS
 * FILE: public/assets/js/destination-filter.js
 * Add to your layout BEFORE closing </body>:
 *   <script src="{{ asset('assets/js/destination-filter.js') }}" defer></script>
 */

(function () {
    'use strict';

    /* =========================================================
       BUDGET DATA  —  per destination (dynamic)
       Each entry: { label, value, min, max (null = no limit) }
       ========================================================= */
    const BUDGET_MAP = {
        '': [
            { label: 'Under ₹25K',       value: 'u25',  min: 0,      max: 25000  },
            { label: '₹25K – ₹50K',      value: '25-50',min: 25000,  max: 50000  },
            { label: '₹50K – ₹1L',       value: '50-1l',min: 50000,  max: 100000 },
            { label: 'Luxury ₹1L+',       value: 'lux',  min: 100000, max: null   },
        ],
        bali: [
            { label: '₹25K – ₹50K',      value: '25-50',min: 25000,  max: 50000  },
            { label: '₹50K – ₹1L',       value: '50-1l',min: 50000,  max: 100000 },
            { label: 'Luxury ₹1L+',       value: 'lux',  min: 100000, max: null   },
        ],
        goa: [
            { label: 'Under ₹10K',        value: 'u10',  min: 0,      max: 10000  },
            { label: '₹10K – ₹25K',       value: '10-25',min: 10000,  max: 25000  },
            { label: '₹25K+',             value: '25p',  min: 25000,  max: null   },
        ],
        dubai: [
            { label: '₹75K – ₹1.5L',      value: '75-15',min: 75000,  max: 150000 },
            { label: '₹1.5L – ₹3L',       value: '15-3l',min: 150000, max: 300000 },
            { label: 'Ultra Luxury ₹3L+',  value: 'ultra',min: 300000, max: null   },
        ],
        thailand: [
            { label: '₹30K – ₹60K',       value: '30-60',min: 30000,  max: 60000  },
            { label: '₹60K – ₹1L',        value: '60-1l',min: 60000,  max: 100000 },
            { label: 'Luxury ₹1L+',        value: 'lux',  min: 100000, max: null   },
        ],
        maldives: [
            { label: '₹1L – ₹2L',         value: '1l-2l',min: 100000, max: 200000 },
            { label: '₹2L – ₹4L',         value: '2l-4l',min: 200000, max: 400000 },
            { label: 'Ultra Luxury ₹4L+',  value: 'ultra',min: 400000, max: null   },
        ],
        kashmir: [
            { label: 'Under ₹20K',         value: 'u20',  min: 0,      max: 20000  },
            { label: '₹20K – ₹40K',        value: '20-40',min: 20000,  max: 40000  },
            { label: '₹40K+',              value: '40p',  min: 40000,  max: null   },
        ],
        kerala: [
            { label: 'Under ₹15K',         value: 'u15',  min: 0,      max: 15000  },
            { label: '₹15K – ₹30K',        value: '15-30',min: 15000,  max: 30000  },
            { label: '₹30K+',              value: '30p',  min: 30000,  max: null   },
        ],
        switzerland: [
            { label: '₹1.5L – ₹2.5L',     value: '15-25',min: 150000, max: 250000 },
            { label: '₹2.5L – ₹4L',        value: '25-4l',min: 250000, max: 400000 },
            { label: 'Ultra Luxury ₹4L+',   value: 'ultra',min: 400000, max: null   },
        ],
    };

    /* =========================================================
       STATE
       ========================================================= */
    const state = {
        destination: '',
        budget:      null,   // { min, max } or null
        duration:    [],
        style:       [],
        season:      [],
        tripType:    'all',
        rating:      null,
        sort:        'popular',
    };

    /* =========================================================
       DOM REFS
       ========================================================= */
    const $ = id => document.getElementById(id);

    const destSelect      = $('dfDestination');
    const budgetOptions   = $('dfBudgetOptions');
    const durationGroup   = $('dfDurationGroup');
    const styleGroup      = $('dfStyleGroup');
    const seasonGroup     = $('dfSeasonGroup');
    const ratingGroup     = $('dfRatingGroup');
    const tripToggle      = $('dfTripToggle');
    const sortSelect      = $('dfSort');
    const clearBtn        = $('dfClearFilters');
    const clearBtnAlt     = $('dfClearFiltersAlt');
    const exploreBtn      = $('dfExploreBtn');
    const cardsGrid       = $('dfCardsGrid');
    const resultsCount    = $('dfResultsCount');
    const activeFiltersEl = $('dfActiveFilters');
    const noResults       = $('dfNoResults');
    const viewGridBtn     = $('dfViewGrid');
    const viewListBtn     = $('dfViewList');
    const mobileFilterBadge = $('dfMobileFilterBadge');
    const mobileSortSelect  = $('dfMobileSortSelect');

    // Cards NodeList (live)
    const allCards = () => Array.from(cardsGrid.querySelectorAll('.df-card'));

    /* =========================================================
       BUDGET RENDER
       ========================================================= */
    function renderBudgetOptions(dest) {
        const options = BUDGET_MAP[dest] || BUDGET_MAP[''];
        budgetOptions.innerHTML = '';

        options.forEach((opt, i) => {
            const id = `dfBudget_${i}`;
            const div = document.createElement('label');
            div.className = 'df-budget-radio';
            div.htmlFor = id;
            div.innerHTML = `
                <input type="radio" id="${id}" name="dfBudget" value="${opt.value}"
                    data-min="${opt.min}" data-max="${opt.max === null ? '' : opt.max}"
                    aria-label="${opt.label}">
                <span class="df-budget-radio-label">${opt.label}</span>
            `;
            budgetOptions.appendChild(div);

            div.querySelector('input').addEventListener('change', function () {
                document.querySelectorAll('.df-budget-radio').forEach(l => l.classList.remove('df-budget-radio--active'));
                div.classList.add('df-budget-radio--active');
                const max = this.dataset.max === '' ? null : parseFloat(this.dataset.max);
                state.budget = { min: parseFloat(this.dataset.min), max };
                applyFilters();
                updateActiveFilterPills();
            });
        });

        // Also render in offcanvas if open
        renderOffcanvasBudget(options);
    }

    function renderOffcanvasBudget(options) {
        const target = document.querySelector('#dfOffcanvasContent .df-oc-budget');
        if (!target) return;
        target.innerHTML = '';
        options.forEach((opt, i) => {
            const id = `dfOCBudget_${i}`;
            const div = document.createElement('label');
            div.className = 'df-budget-radio';
            div.htmlFor = id;
            div.innerHTML = `
                <input type="radio" id="${id}" name="dfOCBudget" value="${opt.value}"
                    data-min="${opt.min}" data-max="${opt.max === null ? '' : opt.max}"
                    aria-label="${opt.label}">
                <span class="df-budget-radio-label">${opt.label}</span>
            `;
            target.appendChild(div);
            div.querySelector('input').addEventListener('change', function () {
                document.querySelectorAll('[name="dfOCBudget"]').forEach(r => r.closest('label').classList.remove('df-budget-radio--active'));
                div.classList.add('df-budget-radio--active');
                const max = this.dataset.max === '' ? null : parseFloat(this.dataset.max);
                state.budget = { min: parseFloat(this.dataset.min), max };
                applyFilters();
                updateActiveFilterPills();
            });
        });
    }

    /* =========================================================
       CHIP TOGGLE  (multi-select)
       ========================================================= */
    function initChipGroup(container, stateKey) {
        container.querySelectorAll('.df-chip').forEach(chip => {
            chip.addEventListener('click', function () {
                const val = this.dataset.value;
                const active = state[stateKey];
                const idx = active.indexOf(val);
                if (idx === -1) {
                    active.push(val);
                    this.classList.add('df-chip--active');
                    this.setAttribute('aria-pressed', 'true');
                } else {
                    active.splice(idx, 1);
                    this.classList.remove('df-chip--active');
                    this.setAttribute('aria-pressed', 'false');
                }
                applyFilters();
                updateActiveFilterPills();
            });
        });
    }

    /* =========================================================
       TRIP TYPE TOGGLE
       ========================================================= */
    function initTripToggle() {
        if (!tripToggle) return;
        tripToggle.querySelectorAll('.df-toggle-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                tripToggle.querySelectorAll('.df-toggle-btn').forEach(b => {
                    b.classList.remove('df-toggle-btn--active');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('df-toggle-btn--active');
                this.setAttribute('aria-pressed', 'true');
                state.tripType = this.dataset.value;
                applyFilters();
                updateActiveFilterPills();
            });
        });
    }

    /* =========================================================
       RATING  (single select as chip)
       ========================================================= */
    function initRatingGroup() {
        if (!ratingGroup) return;
        ratingGroup.querySelectorAll('.df-chip').forEach(chip => {
            chip.addEventListener('click', function () {
                const val = parseFloat(this.dataset.value);
                if (state.rating === val) {
                    // deselect
                    state.rating = null;
                    this.classList.remove('df-chip--active');
                    this.setAttribute('aria-pressed', 'false');
                } else {
                    ratingGroup.querySelectorAll('.df-chip').forEach(c => {
                        c.classList.remove('df-chip--active');
                        c.setAttribute('aria-pressed', 'false');
                    });
                    state.rating = val;
                    this.classList.add('df-chip--active');
                    this.setAttribute('aria-pressed', 'true');
                }
                applyFilters();
                updateActiveFilterPills();
            });
        });
    }

    /* =========================================================
       DESTINATION CHANGE
       ========================================================= */
    function initDestinationSelect() {
        if (!destSelect) return;
        destSelect.addEventListener('change', function () {
            state.destination = this.value;
            state.budget = null; // reset budget on dest change
            renderBudgetOptions(this.value);
            applyFilters();
            updateActiveFilterPills();
        });
    }

    /* =========================================================
       SORT
       ========================================================= */
    function initSort() {
        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                state.sort = this.value;
                if (mobileSortSelect) mobileSortSelect.value = this.value;
                applyFilters();
            });
        }
        if (mobileSortSelect) {
            mobileSortSelect.addEventListener('change', function () {
                state.sort = this.value;
                if (sortSelect) sortSelect.value = this.value;
                applyFilters();
            });
        }
    }

    /* =========================================================
       APPLY FILTERS  (core logic)
       ========================================================= */
    function applyFilters() {
        const cards = allCards();

        // Brief flash
        cardsGrid.classList.add('df-filtering');

        setTimeout(() => {
            let visibleCount = 0;

            cards.forEach(card => {
                let show = true;

                // 1. Destination
                if (state.destination && card.dataset.destination !== state.destination) show = false;

                // 2. Budget
                if (show && state.budget) {
                    const price = parseFloat(card.dataset.price);
                    if (price < state.budget.min) show = false;
                    if (state.budget.max !== null && price > state.budget.max) show = false;
                }

                // 3. Duration
                if (show && state.duration.length > 0) {
                    if (!state.duration.includes(card.dataset.duration)) show = false;
                }

                // 4. Travel style
                if (show && state.style.length > 0) {
                    const cardStyles = (card.dataset.style || '').split(',');
                    const match = state.style.some(s => cardStyles.includes(s));
                    if (!match) show = false;
                }

                // 5. Season
                if (show && state.season.length > 0) {
                    const cardSeasons = (card.dataset.season || '').split(',');
                    const match = state.season.some(s => cardSeasons.includes(s));
                    if (!match) show = false;
                }

                // 6. Trip type
                if (show && state.tripType !== 'all') {
                    if (card.dataset.type !== state.tripType) show = false;
                }

                // 7. Rating
                if (show && state.rating !== null) {
                    if (parseFloat(card.dataset.rating) < state.rating) show = false;
                }

                // Toggle visibility with animation
                if (show) {
                    card.classList.remove('df-card--hidden');
                    card.style.animationDelay = `${visibleCount * 0.05}s`;
                    card.style.animation = 'none';
                    void card.offsetWidth; // reflow
                    card.style.animation = '';
                    visibleCount++;
                } else {
                    card.classList.add('df-card--hidden');
                }
            });

            // Sort visible cards
            sortCards(visibleCount);

            // Update count
            const total = cards.length;
            if (resultsCount) {
                resultsCount.textContent = visibleCount === total
                    ? `${total} packages found`
                    : `${visibleCount} of ${total} packages`;
            }

            // No results
            if (noResults) noResults.style.display = visibleCount === 0 ? 'block' : 'none';

            // Mobile badge
            updateMobileBadge();

            cardsGrid.classList.remove('df-filtering');
        }, 150);
    }

    /* =========================================================
       SORT CARDS
       ========================================================= */
    function sortCards() {
        const cards = allCards();
        const visible = cards.filter(c => !c.classList.contains('df-card--hidden'));
        const hidden  = cards.filter(c => c.classList.contains('df-card--hidden'));

        const sortFn = {
            popular:  (a, b) => parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating),
            budget:   (a, b) => parseFloat(a.dataset.price)  - parseFloat(b.dataset.price),
            luxury:   (a, b) => parseFloat(b.dataset.price)  - parseFloat(a.dataset.price),
            trending: (a, b) => (b.dataset.tag === 'trending' ? 1 : 0) - (a.dataset.tag === 'trending' ? 1 : 0),
            duration: (a, b) => durationOrder(a.dataset.duration) - durationOrder(b.dataset.duration),
        };

        const sorted = (sortFn[state.sort] ? visible.sort(sortFn[state.sort]) : visible);

        // Re-append in sorted order
        [...sorted, ...hidden].forEach(card => cardsGrid.appendChild(card));
    }

    function durationOrder(d) {
        const order = { 'weekend': 0, '3-5': 1, '5-7': 2, '7+': 3 };
        return order[d] !== undefined ? order[d] : 99;
    }

    /* =========================================================
       ACTIVE FILTER PILLS
       ========================================================= */
    function updateActiveFilterPills() {
        if (!activeFiltersEl) return;
        activeFiltersEl.innerHTML = '';

        const pills = [];

        if (state.destination) {
            const labels = { bali:'Bali', goa:'Goa', dubai:'Dubai', thailand:'Thailand', maldives:'Maldives', kashmir:'Kashmir', kerala:'Kerala', switzerland:'Switzerland' };
            pills.push({ label: labels[state.destination] || state.destination, key: 'destination' });
        }
        if (state.budget) {
            // Find label
            const opts = BUDGET_MAP[state.destination] || BUDGET_MAP[''];
            const opt = opts.find(o => o.min === state.budget.min && (o.max === state.budget.max || (o.max === null && state.budget.max === null)));
            if (opt) pills.push({ label: opt.label, key: 'budget' });
        }
        state.duration.forEach(d => pills.push({ label: d === 'weekend' ? 'Weekend' : d + ' Days', key: 'duration', value: d }));
        state.style.forEach(s  => pills.push({ label: capitalize(s), key: 'style', value: s }));
        state.season.forEach(s  => pills.push({ label: capitalize(s), key: 'season', value: s }));
        if (state.tripType !== 'all') pills.push({ label: capitalize(state.tripType), key: 'tripType' });
        if (state.rating !== null)    pills.push({ label: `${state.rating}★+`, key: 'rating' });

        pills.forEach(pill => {
            const span = document.createElement('span');
            span.className = 'df-active-pill';
            span.innerHTML = `${escHtml(pill.label)} <button class="df-active-pill-close" aria-label="Remove ${escHtml(pill.label)} filter"><i class="bi bi-x"></i></button>`;
            span.querySelector('button').addEventListener('click', () => removePill(pill));
            activeFiltersEl.appendChild(span);
        });
    }

    function removePill(pill) {
        switch (pill.key) {
            case 'destination':
                state.destination = '';
                if (destSelect) destSelect.value = '';
                renderBudgetOptions('');
                break;
            case 'budget':
                state.budget = null;
                document.querySelectorAll('[name="dfBudget"]').forEach(r => r.checked = false);
                document.querySelectorAll('.df-budget-radio').forEach(l => l.classList.remove('df-budget-radio--active'));
                break;
            case 'duration':
                state.duration = state.duration.filter(v => v !== pill.value);
                durationGroup.querySelectorAll(`.df-chip[data-value="${pill.value}"]`).forEach(c => {
                    c.classList.remove('df-chip--active'); c.setAttribute('aria-pressed', 'false');
                });
                break;
            case 'style':
                state.style = state.style.filter(v => v !== pill.value);
                styleGroup.querySelectorAll(`.df-chip[data-value="${pill.value}"]`).forEach(c => {
                    c.classList.remove('df-chip--active'); c.setAttribute('aria-pressed', 'false');
                });
                break;
            case 'season':
                state.season = state.season.filter(v => v !== pill.value);
                seasonGroup.querySelectorAll(`.df-chip[data-value="${pill.value}"]`).forEach(c => {
                    c.classList.remove('df-chip--active'); c.setAttribute('aria-pressed', 'false');
                });
                break;
            case 'tripType':
                state.tripType = 'all';
                tripToggle.querySelectorAll('.df-toggle-btn').forEach(b => {
                    const isAll = b.dataset.value === 'all';
                    b.classList.toggle('df-toggle-btn--active', isAll);
                    b.setAttribute('aria-pressed', String(isAll));
                });
                break;
            case 'rating':
                state.rating = null;
                ratingGroup.querySelectorAll('.df-chip').forEach(c => {
                    c.classList.remove('df-chip--active'); c.setAttribute('aria-pressed', 'false');
                });
                break;
        }
        applyFilters();
        updateActiveFilterPills();
    }

    /* =========================================================
       CLEAR ALL FILTERS
       ========================================================= */
    function clearAllFilters() {
        state.destination = '';
        state.budget      = null;
        state.duration    = [];
        state.style       = [];
        state.season      = [];
        state.tripType    = 'all';
        state.rating      = null;
        state.sort        = 'popular';

        if (destSelect) destSelect.value = '';
        if (sortSelect) sortSelect.value = 'popular';
        if (mobileSortSelect) mobileSortSelect.value = 'popular';

        renderBudgetOptions('');

        document.querySelectorAll('.df-chip').forEach(c => {
            c.classList.remove('df-chip--active');
            c.setAttribute('aria-pressed', 'false');
        });

        if (tripToggle) {
            tripToggle.querySelectorAll('.df-toggle-btn').forEach(b => {
                const isAll = b.dataset.value === 'all';
                b.classList.toggle('df-toggle-btn--active', isAll);
                b.setAttribute('aria-pressed', String(isAll));
            });
        }

        applyFilters();
        updateActiveFilterPills();
    }

    /* =========================================================
       MOBILE BADGE COUNT
       ========================================================= */
    function updateMobileBadge() {
        if (!mobileFilterBadge) return;
        let count = 0;
        if (state.destination) count++;
        if (state.budget)      count++;
        count += state.duration.length + state.style.length + state.season.length;
        if (state.tripType !== 'all') count++;
        if (state.rating !== null) count++;
        if (count > 0) {
            mobileFilterBadge.textContent = count;
            mobileFilterBadge.style.display = 'flex';
        } else {
            mobileFilterBadge.style.display = 'none';
        }
    }

    /* =========================================================
       VIEW TOGGLE  (Grid / List)
       ========================================================= */
    function initViewToggle() {
        if (!viewGridBtn || !viewListBtn || !cardsGrid) return;

        viewGridBtn.addEventListener('click', () => {
            cardsGrid.classList.remove('df-list-mode');
            viewGridBtn.classList.add('df-view-btn--active');
            viewListBtn.classList.remove('df-view-btn--active');
        });

        viewListBtn.addEventListener('click', () => {
            cardsGrid.classList.add('df-list-mode');
            viewListBtn.classList.add('df-view-btn--active');
            viewGridBtn.classList.remove('df-view-btn--active');
        });
    }

    /* =========================================================
       WISHLIST BUTTONS
       ========================================================= */
    function initWishlistButtons() {
        document.querySelectorAll('.df-wishlist-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const wishlisted = this.dataset.wishlisted === 'true';
                this.dataset.wishlisted = String(!wishlisted);

                // Animate
                this.style.transform = 'scale(1.35)';
                setTimeout(() => { this.style.transform = ''; }, 200);
            });
        });
    }

    /* =========================================================
       RECOMMENDED DESTINATIONS CAROUSEL
       ========================================================= */
    function initCardsCarousel() {
        const carouselOuter = $('dfCarouselOuter');
        const arrowLeft = $('dfCarouselArrowLeft');
        const arrowRight = $('dfCarouselArrowRight');
        if (!cardsGrid || !carouselOuter || !arrowLeft || !arrowRight) return;
        if (cardsGrid.dataset.carouselInit === '1') return;
        cardsGrid.dataset.carouselInit = '1';

        const getStep = () => {
            const card = cardsGrid.querySelector('.df-card:not(.df-card--hidden)') || cardsGrid.querySelector('.df-card');
            if (!card) return 280;
            const gap = parseInt(window.getComputedStyle(cardsGrid).gap, 10) || 20;
            return card.getBoundingClientRect().width + gap;
        };

        const updateArrows = () => {
            const maxScrollLeft = cardsGrid.scrollWidth - cardsGrid.clientWidth;
            const isMobile = window.matchMedia('(max-width: 639.98px)').matches;

            if (isMobile) {
                arrowLeft.style.display = 'flex';
                arrowRight.style.display = 'flex';
                arrowLeft.disabled = maxScrollLeft <= 2 || cardsGrid.scrollLeft <= 2;
                arrowRight.disabled = maxScrollLeft <= 2 || cardsGrid.scrollLeft >= (maxScrollLeft - 2);
                return;
            }

            arrowLeft.disabled = false;
            arrowRight.disabled = false;

            if (maxScrollLeft <= 2) {
                arrowLeft.style.display = 'none';
                arrowRight.style.display = 'none';
                return;
            }
            arrowLeft.style.display = cardsGrid.scrollLeft <= 2 ? 'none' : 'flex';
            arrowRight.style.display = cardsGrid.scrollLeft >= (maxScrollLeft - 2) ? 'none' : 'flex';
        };

        const scrollByStep = direction => {
            cardsGrid.scrollBy({ left: direction * getStep(), behavior: 'smooth' });
        };

        arrowRight.addEventListener('click', () => scrollByStep(1));
        arrowLeft.addEventListener('click', () => scrollByStep(-1));
        cardsGrid.addEventListener('scroll', updateArrows, { passive: true });
        window.addEventListener('resize', updateArrows);

        // Drag-to-scroll for touch/mouse without blocking real button/link taps
        let isPointerDown = false;
        let isDragging = false;
        let startX = 0;
        let startScrollLeft = 0;

        cardsGrid.addEventListener('pointerdown', e => {
            const interactive = e.target.closest('a, button, input, select, label, textarea');
            if (interactive) return;
            isPointerDown = true;
            isDragging = false;
            startX = e.clientX;
            startScrollLeft = cardsGrid.scrollLeft;
            cardsGrid.classList.add('df-is-dragging');
            if (cardsGrid.setPointerCapture) {
                cardsGrid.setPointerCapture(e.pointerId);
            }
        });

        cardsGrid.addEventListener('pointermove', e => {
            if (!isPointerDown) return;
            const delta = e.clientX - startX;
            if (Math.abs(delta) > 6) isDragging = true;
            if (isDragging) {
                e.preventDefault();
                cardsGrid.scrollLeft = startScrollLeft - delta;
            }
        });

        const endPointer = e => {
            isPointerDown = false;
            cardsGrid.classList.remove('df-is-dragging');
            if (e && cardsGrid.releasePointerCapture) {
                try {
                    cardsGrid.releasePointerCapture(e.pointerId);
                } catch (_) {}
            }
            setTimeout(() => { isDragging = false; }, 0);
            updateArrows();
        };
        cardsGrid.addEventListener('pointerup', endPointer);
        cardsGrid.addEventListener('pointercancel', endPointer);
        cardsGrid.addEventListener('pointerleave', endPointer);

        if (!window.PointerEvent) {
            cardsGrid.addEventListener('touchstart', e => {
                const interactive = e.target.closest('a, button, input, select, label, textarea');
                if (interactive) return;
                isPointerDown = true;
                isDragging = false;
                startX = e.changedTouches[0].clientX;
                startScrollLeft = cardsGrid.scrollLeft;
                cardsGrid.classList.add('df-is-dragging');
            }, { passive: true });

            cardsGrid.addEventListener('touchmove', e => {
                if (!isPointerDown) return;
                const delta = e.changedTouches[0].clientX - startX;
                if (Math.abs(delta) > 6) isDragging = true;
                if (isDragging) {
                    e.preventDefault();
                    cardsGrid.scrollLeft = startScrollLeft - delta;
                }
            }, { passive: false });

            cardsGrid.addEventListener('touchend', endPointer);
            cardsGrid.addEventListener('touchcancel', endPointer);
        }

        cardsGrid.addEventListener('click', e => {
            if (!isDragging) return;
            const interactive = e.target.closest('a, button');
            if (interactive) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);

        // Keep arrows in sync after filtering/sorting updates
        const syncObserver = new MutationObserver(updateArrows);
        syncObserver.observe(cardsGrid, { childList: true, subtree: false, attributes: true });

        requestAnimationFrame(updateArrows);
    }

    /* =========================================================
       OFFCANVAS MOBILE SIDEBAR  —  clone desktop filters
       ========================================================= */
    function buildOffcanvasContent() {
        const container = $('dfOffcanvasContent');
        if (!container) return;

        container.innerHTML = `
            <!-- Destination -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-geo-alt"></i> Destination</label>
                <div class="df-select-wrap">
                    <select class="df-select" id="dfOCDestination">
                        <option value="">All Destinations</option>
                        <option value="bali">Bali</option>
                        <option value="goa">Goa</option>
                        <option value="dubai">Dubai</option>
                        <option value="thailand">Thailand</option>
                        <option value="maldives">Maldives</option>
                        <option value="kashmir">Kashmir</option>
                        <option value="kerala">Kerala</option>
                        <option value="switzerland">Switzerland</option>
                    </select>
                    <i class="bi bi-chevron-down df-select-chevron"></i>
                </div>
            </div>

            <!-- Budget -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-currency-rupee"></i> Budget</label>
                <div class="df-budget-options df-oc-budget"></div>
            </div>

            <!-- Duration -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-clock"></i> Duration</label>
                <div class="df-chip-group df-chip-group--wrap">
                    <button class="df-chip" data-filter="oc-duration" data-value="weekend">Weekend</button>
                    <button class="df-chip" data-filter="oc-duration" data-value="3-5">3–5 Days</button>
                    <button class="df-chip" data-filter="oc-duration" data-value="5-7">5–7 Days</button>
                    <button class="df-chip" data-filter="oc-duration" data-value="7+">7+ Days</button>
                </div>
            </div>

            <!-- Travel Style -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-heart"></i> Travel Style</label>
                <div class="df-chip-group df-chip-group--wrap">
                    <button class="df-chip" data-filter="oc-style" data-value="honeymoon">💑 Honeymoon</button>
                    <button class="df-chip" data-filter="oc-style" data-value="adventure">🧗 Adventure</button>
                    <button class="df-chip" data-filter="oc-style" data-value="family">👨‍👩‍👧 Family</button>
                    <button class="df-chip" data-filter="oc-style" data-value="solo">🎒 Solo</button>
                    <button class="df-chip" data-filter="oc-style" data-value="friends">🎉 Friends</button>
                    <button class="df-chip" data-filter="oc-style" data-value="luxury">✨ Luxury</button>
                </div>
            </div>

            <!-- Trip Type -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-globe2"></i> Trip Type</label>
                <div class="df-toggle-pill" id="dfOCTripToggle">
                    <button class="df-toggle-btn df-toggle-btn--active" data-value="all">All</button>
                    <button class="df-toggle-btn" data-value="domestic">Domestic</button>
                    <button class="df-toggle-btn" data-value="international">International</button>
                </div>
            </div>

            <!-- Season -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-sun"></i> Season</label>
                <div class="df-chip-group df-chip-group--wrap">
                    <button class="df-chip" data-filter="oc-season" data-value="summer">☀️ Summer</button>
                    <button class="df-chip" data-filter="oc-season" data-value="winter">❄️ Winter</button>
                    <button class="df-chip" data-filter="oc-season" data-value="monsoon">🌧️ Monsoon</button>
                    <button class="df-chip" data-filter="oc-season" data-value="december">🎄 December</button>
                </div>
            </div>

            <!-- Ratings -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-star"></i> Minimum Rating</label>
                <div class="df-chip-group">
                    <button class="df-chip" data-filter="oc-rating" data-value="4">4★ &amp; above</button>
                    <button class="df-chip" data-filter="oc-rating" data-value="4.5">4.5★ &amp; above</button>
                </div>
            </div>

            <!-- Actions -->
            <div class="df-sidebar-actions" style="margin-top: 8px;">
                <button class="df-btn-clear" id="dfOCClear" type="button"><i class="bi bi-x-circle"></i> Clear Filters</button>
                <button class="df-btn-search" id="dfOCExplore" type="button" data-bs-dismiss="offcanvas">
                    <i class="bi bi-search"></i> Explore Packages
                </button>
            </div>
        `;

        // Bind OC destination
        const ocDest = $('dfOCDestination');
        if (ocDest) {
            ocDest.addEventListener('change', function () {
                state.destination = this.value;
                if (destSelect) destSelect.value = this.value;
                state.budget = null;
                renderBudgetOptions(this.value);
                applyFilters();
                updateActiveFilterPills();
            });
        }

        // Bind OC chips (delegated binding for reliable mobile/touch behavior)
        container.addEventListener('click', function (event) {
            const chip = event.target.closest('.df-chip[data-filter^="oc-"]');
            if (!chip) return;

            const filterKey = chip.dataset.filter.replace('oc-', ''); // duration, style, season, rating
            const val = chip.dataset.value;

            if (filterKey === 'rating') {
                const rVal = parseFloat(val);
                if (state.rating === rVal) {
                    state.rating = null;
                    chip.classList.remove('df-chip--active');
                    chip.setAttribute('aria-pressed', 'false');
                } else {
                    container.querySelectorAll('[data-filter="oc-rating"]').forEach(c => {
                        c.classList.remove('df-chip--active');
                        c.setAttribute('aria-pressed', 'false');
                    });
                    state.rating = rVal;
                    chip.classList.add('df-chip--active');
                    chip.setAttribute('aria-pressed', 'true');
                }
            } else {
                const arr = state[filterKey];
                const idx = arr.indexOf(val);
                if (idx === -1) {
                    arr.push(val);
                    chip.classList.add('df-chip--active');
                    chip.setAttribute('aria-pressed', 'true');
                } else {
                    arr.splice(idx, 1);
                    chip.classList.remove('df-chip--active');
                    chip.setAttribute('aria-pressed', 'false');
                }
            }

            applyFilters();
            updateActiveFilterPills();
        });

        // Bind OC trip toggle
        const ocTrip = $('dfOCTripToggle');
        if (ocTrip) {
            ocTrip.querySelectorAll('.df-toggle-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    ocTrip.querySelectorAll('.df-toggle-btn').forEach(b => {
                        b.classList.remove('df-toggle-btn--active'); b.setAttribute('aria-pressed', 'false');
                    });
                    this.classList.add('df-toggle-btn--active');
                    this.setAttribute('aria-pressed', 'true');
                    state.tripType = this.dataset.value;
                    applyFilters();
                    updateActiveFilterPills();
                });
            });
        }

        // Bind OC clear
        const ocClear = $('dfOCClear');
        if (ocClear) ocClear.addEventListener('click', clearAllFilters);

        // Render initial budget options
        renderOffcanvasBudget(BUDGET_MAP['']);
    }

    /* =========================================================
       UTILITIES
       ========================================================= */
    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function escHtml(str) {
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    /* =========================================================
       INIT
       ========================================================= */
    function init() {
        renderBudgetOptions('');
        initDestinationSelect();
        initChipGroup(durationGroup, 'duration');
        initChipGroup(styleGroup, 'style');
        initChipGroup(seasonGroup, 'season');
        initTripToggle();
        initRatingGroup();
        initSort();
        initViewToggle();
        initWishlistButtons();
        // initCardsCarousel(); // Disabled - using grid layout instead
        buildOffcanvasContent();

        if (clearBtn)    clearBtn.addEventListener('click', clearAllFilters);
        if (clearBtnAlt) clearBtnAlt.addEventListener('click', clearAllFilters);
        if (exploreBtn)  exploreBtn.addEventListener('click', applyFilters);

        // Initial render
        applyFilters();
        updateActiveFilterPills();
    }

    // Wait for DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
