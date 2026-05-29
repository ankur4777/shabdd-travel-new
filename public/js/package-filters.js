(function () {
    'use strict';

    const moneyFormatter = new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        maximumFractionDigits: 0,
    });

    function submitFormSoon(form) {
        if (!form || form.dataset.submitting === '1') {
            return;
        }

        form.dataset.submitting = '1';

        window.setTimeout(() => {
            if (typeof form.requestSubmit === 'function') {
                form.requestSubmit();
                return;
            }

            form.submit();
        }, 120);
    }

    function initAutoSubmit(form) {
        form.querySelectorAll('[data-package-auto-submit]').forEach(control => {
            control.addEventListener('change', () => submitFormSoon(form));
        });
    }

    function initRange(range) {
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

    function initPackageFilters() {
        document.querySelectorAll('[data-package-filter-form]').forEach(initAutoSubmit);
        document.querySelectorAll('[data-package-range]').forEach(initRange);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPackageFilters);
        return;
    }

    initPackageFilters();
})();
