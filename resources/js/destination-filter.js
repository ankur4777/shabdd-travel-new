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
    const DEFAULT_BUDGET_OPTIONS = [
        { label: 'Under ₹25K',  value: 'u25',   min: 0,      max: 25000  },
        { label: '₹25K – ₹50K', value: '25-50', min: 25000,  max: 50000  },
        { label: '₹50K – ₹1L',  value: '50-1l', min: 50000,  max: 100000 },
        { label: 'Luxury ₹1L+', value: 'lux',   min: 100000, max: null   },
    ];

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
        category:    [],
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
    const allCards = () => cardsGrid ? Array.from(cardsGrid.querySelectorAll('.df-card')) : [];

    function initializeCardSortIndexes() {
        allCards().forEach((card, index) => {
            if (!card.dataset.originalIndex) {
                card.dataset.originalIndex = String(index);
            }
        });
    }

    function getDestinationOptions() {
        if (!destSelect) return [];

        return Array.from(destSelect.options)
            .filter(option => option.value !== '')
            .map(option => ({
                value: option.value,
                label: option.textContent.trim(),
            }));
    }

    function getDestinationLabel(value) {
        if (!destSelect) return value;

        const option = Array.from(destSelect.options).find(item => item.value === value);
        return option ? option.textContent.trim() : value;
    }

    function getSortLabel(value) {
        const select = sortSelect || mobileSortSelect;
        if (!select) return capitalize(value);

        const option = Array.from(select.options).find(item => item.value === value);
        return option ? option.textContent.trim() : capitalize(value);
    }

    /* =========================================================
       BUDGET RENDER
       ========================================================= */
    function renderBudgetOptions(dest) {
        if (!budgetOptions) return;

        const options = DEFAULT_BUDGET_OPTIONS;
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
        if (!container) return;

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
                applySortSelection(this.value);
                if (mobileSortSelect) mobileSortSelect.value = this.value;
                applyFilters();
                updateActiveFilterPills();
            });
        }
        if (mobileSortSelect) {
            mobileSortSelect.addEventListener('change', function () {
                applySortSelection(this.value);
                if (sortSelect) sortSelect.value = this.value;
                applyFilters();
                updateActiveFilterPills();
            });
        }
    }

    function applySortSelection(value) {
        state.sort = value;
        state.category = categoryKeysForSort(value);
    }

    function categoryKeysForSort(value) {
        const categories = {
            popular: ['popular'],
            budget: ['budget-friendly', 'budget'],
            luxury: ['premium', 'luxury'],
            trending: ['trending'],
        };

        return categories[value] || [];
    }

    /* =========================================================
       APPLY FILTERS  (core logic)
       ========================================================= */
    function applyFilters() {
        if (!cardsGrid) return;

        const cards = allCards();
        let visibleCount = 0;

        cards.forEach(card => {
            let show = true;

            if (state.destination && card.dataset.destination !== state.destination) show = false;

            if (show && state.category.length > 0) {
                if (!state.category.includes(card.dataset.category)) show = false;
            }

            if (show && state.budget) {
                const price = parseFloat(card.dataset.price);
                if (price < state.budget.min) show = false;
                if (state.budget.max !== null && price > state.budget.max) show = false;
            }

            if (show && state.duration.length > 0) {
                if (!state.duration.includes(card.dataset.duration)) show = false;
            }

            if (show && state.style.length > 0) {
                const cardStyles = (card.dataset.style || '').split(',');
                const match = state.style.some(s => cardStyles.includes(s));
                if (!match) show = false;
            }

            if (show && state.season.length > 0) {
                const cardSeasons = (card.dataset.season || '').split(',');
                const match = state.season.some(s => cardSeasons.includes(s));
                if (!match) show = false;
            }

            if (show && state.tripType !== 'all') {
                if (card.dataset.type !== state.tripType) show = false;
            }

            if (show && state.rating !== null) {
                if (parseFloat(card.dataset.rating) < state.rating) show = false;
            }

            card.classList.toggle('df-card--hidden', !show);
            if (show) visibleCount++;
        });

        sortCards();

        const total = cards.length;
        if (resultsCount) {
            const resultLabel = resultsCount.dataset.resultLabel || 'destinations';
            resultsCount.textContent = visibleCount === total
                ? `${total} ${resultLabel} found`
                : `${visibleCount} of ${total} ${resultLabel}`;
        }

        if (noResults) noResults.style.display = visibleCount === 0 ? 'block' : 'none';

        updateMobileBadge();
    }

    /* =========================================================
       SORT CARDS
       ========================================================= */
    function sortCards() {
        const cards = allCards();
        const visible = cards.filter(c => !c.classList.contains('df-card--hidden'));
        const hidden  = cards.filter(c => c.classList.contains('df-card--hidden'));

        const originalOrder = card => numberValue(card.dataset.originalIndex, 0);
        const compareOriginal = (a, b) => originalOrder(a) - originalOrder(b);
        const comparePriceAsc = (a, b) => compareNumber(a, b, 'price', 'asc') || compareOriginal(a, b);
        const comparePriceDesc = (a, b) => compareNumber(a, b, 'price', 'desc') || compareOriginal(a, b);
        const compareRatingDesc = (a, b) => compareNumber(a, b, 'rating', 'desc') || compareOriginal(a, b);

        const sortFn = {
            popular:  compareRatingDesc,
            budget:   comparePriceAsc,
            luxury:   (a, b) => sortRank(b, 'luxury') - sortRank(a, 'luxury') || comparePriceDesc(a, b),
            trending: (a, b) => sortRank(b, 'trending') - sortRank(a, 'trending') || compareRatingDesc(a, b),
            duration: (a, b) => durationOrder(a.dataset.duration) - durationOrder(b.dataset.duration) || compareOriginal(a, b),
        };

        const sorted = (sortFn[state.sort] ? visible.sort(sortFn[state.sort]) : visible);

        // Re-append in sorted order
        [...sorted, ...hidden].forEach(card => cardsGrid.appendChild(card));
    }

    function durationOrder(d) {
        const order = { 'weekend': 0, '3-5': 1, '5-7': 2, '7+': 3 };
        return order[d] !== undefined ? order[d] : 99;
    }

    function numberValue(value, fallback = Number.POSITIVE_INFINITY) {
        const normalized = String(value ?? '').replace(/[^0-9.-]/g, '');
        const number = Number.parseFloat(normalized);

        return Number.isFinite(number) ? number : fallback;
    }

    function compareNumber(a, b, key, direction = 'asc') {
        const fallback = direction === 'asc' ? Number.POSITIVE_INFINITY : Number.NEGATIVE_INFINITY;
        const aValue = numberValue(a.dataset[key], fallback);
        const bValue = numberValue(b.dataset[key], fallback);

        return direction === 'asc' ? aValue - bValue : bValue - aValue;
    }

    function sortRank(card, value) {
        const tag = String(card.dataset.tag || '').toLowerCase();
        const styles = String(card.dataset.style || '').toLowerCase().split(',').map(item => item.trim());

        return Number(tag === value || styles.includes(value));
    }

    /* =========================================================
       ACTIVE FILTER PILLS
       ========================================================= */
    function updateActiveFilterPills() {
        if (!activeFiltersEl) return;
        activeFiltersEl.innerHTML = '';

        const pills = [];

        if (state.destination) {
            pills.push({ label: getDestinationLabel(state.destination), key: 'destination' });
        }
        if (state.category.length > 0) {
            pills.push({ label: getSortLabel(state.sort), key: 'category' });
        }
        if (state.budget) {
            const opts = DEFAULT_BUDGET_OPTIONS;
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
            case 'category':
                state.category = [];
                state.sort = 'popular';
                if (sortSelect) sortSelect.value = 'popular';
                if (mobileSortSelect) mobileSortSelect.value = 'popular';
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
        state.category    = [];
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
        if (state.category.length > 0) count++;
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

    function syncChipGroupSelection(container, stateKey) {
        if (!container) return;

        container.querySelectorAll('.df-chip').forEach(chip => {
            const isActive = state[stateKey].includes(chip.dataset.value);
            chip.classList.toggle('df-chip--active', isActive);
            chip.setAttribute('aria-pressed', String(isActive));
        });
    }

    function normalizeStyleValue(value) {
        return String(value || '')
            .trim()
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    function applyInitialQueryFilters() {
        const params = new URLSearchParams(window.location.search);
        const style = normalizeStyleValue(params.get('travel_style') || params.get('style'));

        if (!style) return;

        state.style = [style];
        syncChipGroupSelection(styleGroup, 'style');
        document
            .querySelectorAll('#dfOffcanvasContent .df-chip[data-filter="oc-style"]')
            .forEach(chip => {
                const isActive = state.style.includes(chip.dataset.value);
                chip.classList.toggle('df-chip--active', isActive);
                chip.setAttribute('aria-pressed', String(isActive));
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

        const destinationOptionsHtml = destSelect
            ? destSelect.innerHTML
            : '<option value="">All Destinations</option>';

        container.innerHTML = `
            <!-- Destination -->
            <div class="df-filter-group">
                <label class="df-filter-label"><i class="bi bi-geo-alt"></i> Destination</label>
                <div class="df-select-wrap">
                    <select class="df-select" id="dfOCDestination">
                        ${destinationOptionsHtml}
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
                    <button class="df-chip" data-filter="oc-style" data-value="corporate-tour">🏢 Corporate Tour</button>
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
        renderOffcanvasBudget(DEFAULT_BUDGET_OPTIONS);
    }

    /* =========================================================
       UTILITIES
       ========================================================= */
    function capitalize(str) {
        return String(str)
            .replace(/[-_]+/g, ' ')
            .replace(/\b\w/g, char => char.toUpperCase());
    }

    function escHtml(str) {
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    /* =========================================================
       INIT
       ========================================================= */
    function init() {
        if (!cardsGrid && !budgetOptions && !destSelect) return;

        renderBudgetOptions('');
        initializeCardSortIndexes();
        initDestinationSelect();
        initChipGroup(durationGroup, 'duration');
        initChipGroup(styleGroup, 'style');
        initChipGroup(seasonGroup, 'season');
        initTripToggle();
        initRatingGroup();
        initSort();
        initViewToggle();
        initWishlistButtons();
        initCardsCarousel();
        buildOffcanvasContent();
        applyInitialQueryFilters();

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
