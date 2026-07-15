/**
 * SHABDD TRAVEL — Carousel JS
 * Handles horizontal card carousel scrolling with navigation arrows
 */

(function () {
    'use strict';

    function initCarousel() {
        const cardsGrid = document.getElementById('dfCardsGrid');
        const arrowLeft = document.getElementById('dfCarouselArrowLeft');
        const arrowRight = document.getElementById('dfCarouselArrowRight');

        if (!cardsGrid || !arrowLeft || !arrowRight) {
            return;
        }

        // Destination filter script owns this carousel; avoid double-binding handlers.
        if (cardsGrid.dataset.carouselInit === '1') {
            return;
        }
        cardsGrid.dataset.carouselInit = '1';

        // Get responsive card width
        function getCardWidth() {
            const firstCard = cardsGrid.querySelector('.df-card');
            if (!firstCard) return 280; // Fallback

            const gridStyle = window.getComputedStyle(cardsGrid);
            const gap = parseFloat(gridStyle.columnGap || gridStyle.gap) || 0;
            return firstCard.getBoundingClientRect().width + gap;
        }

        // Update arrow visibility based on scroll position
        function updateArrows() {
            const scrollPos = cardsGrid.scrollLeft;
            const maxScroll = cardsGrid.scrollWidth - cardsGrid.clientWidth;
            const isMobile = window.matchMedia('(max-width: 639.98px)').matches;

            if (isMobile) {
                arrowLeft.style.display = 'flex';
                arrowRight.style.display = 'flex';
                arrowLeft.disabled = maxScroll <= 2 || scrollPos <= 2;
                arrowRight.disabled = maxScroll <= 2 || scrollPos >= maxScroll - 10;
                return;
            }

            arrowLeft.disabled = false;
            arrowRight.disabled = false;

            // Hide left arrow if at the beginning
            if (scrollPos <= 0) {
                arrowLeft.style.display = 'none';
            } else {
                arrowLeft.style.display = 'flex';
            }

            // Hide right arrow if at the end
            if (scrollPos >= maxScroll - 10) {
                arrowRight.style.display = 'none';
            } else {
                arrowRight.style.display = 'flex';
            }
        }

        // Scroll handler for arrows
        arrowLeft.addEventListener('click', () => {
            const scrollStep = getCardWidth();
            cardsGrid.scrollBy({
                left: -scrollStep,
                behavior: 'smooth'
            });
            // Update arrows after scroll animation
            setTimeout(updateArrows, 300);
        });

        arrowRight.addEventListener('click', () => {
            const scrollStep = getCardWidth();
            cardsGrid.scrollBy({
                left: scrollStep,
                behavior: 'smooth'
            });
            // Update arrows after scroll animation
            setTimeout(updateArrows, 300);
        });

        // Update arrows on scroll
        cardsGrid.addEventListener('scroll', updateArrows);

        // Touch devices use native momentum scrolling. Add mouse drag support only.
        let isDragging = false;
        let startX = 0;
        let startScrollLeft = 0;
        let dragMoved = false;

        cardsGrid.addEventListener('pointerdown', (event) => {
            if (event.pointerType !== 'mouse' || event.button !== 0) {
                return;
            }

            if (event.target.closest('a, button, input, select, label, textarea')) {
                return;
            }

            isDragging = true;
            dragMoved = false;
            startX = event.clientX;
            startScrollLeft = cardsGrid.scrollLeft;
            cardsGrid.classList.add('df-is-dragging');
            cardsGrid.setPointerCapture(event.pointerId);
        });

        cardsGrid.addEventListener('pointermove', (event) => {
            if (!isDragging || event.pointerType !== 'mouse') {
                return;
            }

            const deltaX = event.clientX - startX;
            if (Math.abs(deltaX) > 3) {
                dragMoved = true;
                event.preventDefault();
            }

            cardsGrid.scrollLeft = startScrollLeft - deltaX;
        });

        function stopDragging(event) {
            if (!isDragging) {
                return;
            }

            isDragging = false;
            cardsGrid.classList.remove('df-is-dragging');
            if (cardsGrid.hasPointerCapture(event.pointerId)) {
                cardsGrid.releasePointerCapture(event.pointerId);
            }
            if (dragMoved) {
                setTimeout(updateArrows, 80);
            }
        }

        cardsGrid.addEventListener('pointerup', stopDragging);
        cardsGrid.addEventListener('pointercancel', stopDragging);
        cardsGrid.addEventListener('pointerleave', stopDragging);

        // Update arrows on window resize (for responsive card widths)
        window.addEventListener('resize', () => {
            setTimeout(updateArrows, 100);
        });

        // Initial arrow state
        updateArrows();
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }

})();
