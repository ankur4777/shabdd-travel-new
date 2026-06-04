(function () {
    'use strict';

    const listingSelector = '.pkg-listing-section';
    let activeRequest = null;

    const moneyFormatter = new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 0,
    });

    function buildUrl(form) {
        const url = new URL(form.action || window.location.href, window.location.origin);
        const formData = new FormData(form);

        url.search = '';

        formData.forEach((value, key) => {
            if (value !== null && String(value) !== '') {
                url.searchParams.append(key, value);
            }
        });

        return url;
    }

    function cleanupOffcanvas() {
        const openedOffcanvas = document.querySelector('.offcanvas.show');

        if (
            openedOffcanvas &&
            window.bootstrap &&
            typeof window.bootstrap.Offcanvas?.getInstance === 'function'
        ) {
            window.bootstrap.Offcanvas.getInstance(openedOffcanvas)?.hide();
        }

        document.querySelectorAll('.offcanvas-backdrop').forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    }

    function replaceListingFromHtml(html) {
        const parser = new DOMParser();
        const nextDocument = parser.parseFromString(html, 'text/html');
        const currentListing = document.querySelector(listingSelector);
        const nextListing = nextDocument.querySelector(listingSelector);

        if (!currentListing || !nextListing) {
            window.location.reload();
            return;
        }

        cleanupOffcanvas();
        currentListing.replaceWith(nextListing);
        initPackageFilters(nextListing);
    }

    function setLoading(isLoading) {
        document.querySelector(listingSelector)?.classList.toggle('pkg-is-loading', isLoading);
    }

    async function loadFilteredListing(url, pushState = true) {
        if (activeRequest) {
            activeRequest.abort();
        }

        const request = new AbortController();
        activeRequest = request;
        setLoading(true);

        try {
            const response = await fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                signal: request.signal,
            });

            if (!response.ok) {
                throw new Error(`Filter request failed with ${response.status}`);
            }

            const html = await response.text();

            replaceListingFromHtml(html);

            if (pushState) {
                window.history.pushState({ packageFilters: true }, '', url.toString());
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                window.location.href = url.toString();
            }
        } finally {
            if (activeRequest === request) {
                activeRequest = null;
                setLoading(false);
            }
        }
    }

    function submitFormSoon(form) {
        if (!form || form.dataset.submitting === '1') {
            return;
        }

        form.dataset.submitting = '1';

        window.setTimeout(() => {
            form.dataset.submitting = '0';
            loadFilteredListing(buildUrl(form));
        }, 120);
    }

    function initAutoSubmit(form) {
        if (form.dataset.packageFilterReady === '1') {
            return;
        }

        form.dataset.packageFilterReady = '1';

        form.addEventListener('submit', event => {
            event.preventDefault();
            loadFilteredListing(buildUrl(form));
        });

        form.querySelectorAll('[data-package-auto-submit]').forEach(control => {
            control.addEventListener('change', () => submitFormSoon(form));
        });
    }

    function initRange(range) {
        if (range.dataset.packageRangeReady === '1') {
            return;
        }

        range.dataset.packageRangeReady = '1';

        const minInput = range.querySelector('[data-package-range-min]');
        const maxInput = range.querySelector('[data-package-range-max]');
        const progress = range.querySelector('[data-package-range-progress]');
        const form = range.closest('[data-package-filter-form]');
        const minLabel = form?.querySelector('[data-package-price-min-label]');
        const maxLabel = form?.querySelector('[data-package-price-max-label]');
        const boundMin = Number(range.dataset.min || 0);
        const boundMax = Number(range.dataset.max || boundMin);

        if (!minInput || !maxInput || !progress) {
            return;
        }

        function numberValue(input) {
            return Number(input.value || 0);
        }

        function updateProgress() {
            const minValue = numberValue(minInput);
            const maxValue = numberValue(maxInput);
            const span = Math.max(1, boundMax - boundMin);
            const left = ((minValue - boundMin) / span) * 100;
            const right = 100 - (((maxValue - boundMin) / span) * 100);

            progress.style.left = `${Math.max(0, Math.min(left, 100))}%`;
            progress.style.right = `${Math.max(0, Math.min(right, 100))}%`;

            if (minLabel) {
                minLabel.textContent = moneyFormatter.format(minValue);
            }

            if (maxLabel) {
                maxLabel.textContent = moneyFormatter.format(maxValue);
            }
        }

        minInput.addEventListener('input', () => {
            if (numberValue(minInput) > numberValue(maxInput)) {
                maxInput.value = minInput.value;
            }

            updateProgress();
        });

        maxInput.addEventListener('input', () => {
            if (numberValue(maxInput) < numberValue(minInput)) {
                minInput.value = maxInput.value;
            }

            updateProgress();
        });

        minInput.addEventListener('change', () => submitFormSoon(form));
        maxInput.addEventListener('change', () => submitFormSoon(form));

        updateProgress();
    }

    function initClearLinks(root) {
        root.querySelectorAll('.pkg-active-filters a, .pkg-clear-btn, .pkg-empty-state a').forEach(link => {
            if (link.dataset.packageClearReady === '1') {
                return;
            }

            link.dataset.packageClearReady = '1';
            link.addEventListener('click', event => {
                event.preventDefault();
                loadFilteredListing(new URL(link.href, window.location.origin));
            });
        });
    }

    function initPackageFilters(root = document) {
        root.querySelectorAll('[data-package-filter-form]').forEach(initAutoSubmit);
        root.querySelectorAll('[data-package-range]').forEach(initRange);
        initClearLinks(root);
    }

    window.addEventListener('popstate', () => {
        loadFilteredListing(new URL(window.location.href), false);
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPackageFilters);
        return;
    }

    initPackageFilters();
})();
