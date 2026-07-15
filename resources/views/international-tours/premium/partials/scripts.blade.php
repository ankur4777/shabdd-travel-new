@push('scripts')
    <script>
        (() => {
            const revealItems = document.querySelectorAll('[data-pj-reveal]');
            revealItems.forEach(item => item.classList.add('is-visible'));

            const gallery = document.querySelector('[data-pj-gallery]');
            if (!gallery) return;

            const images = @json($journey['gallery']);
            const lightbox = gallery.querySelector('[data-pj-lightbox]');
            const lightboxImage = gallery.querySelector('[data-pj-lightbox-image]');
            const caption = gallery.querySelector('[data-pj-lightbox-caption]');
            const location = gallery.querySelector('[data-pj-lightbox-location]');
            const count = gallery.querySelector('[data-pj-lightbox-count]');
            const closeButton = gallery.querySelector('[data-pj-gallery-close]');
            let currentIndex = 0;
            let previousFocus = null;

            const render = () => {
                const image = images[currentIndex];
                lightboxImage.src = image.src;
                lightboxImage.alt = image.caption;
                caption.textContent = image.caption;
                location.textContent = image.location;
                count.textContent = `${currentIndex + 1} / ${images.length}`;
            };

            const open = (index, trigger) => {
                currentIndex = index;
                previousFocus = trigger;
                render();
                lightbox.classList.add('is-open');
                lightbox.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
                closeButton.focus();
            };

            const close = () => {
                lightbox.classList.remove('is-open');
                lightbox.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                previousFocus?.focus();
            };

            const move = (step) => {
                currentIndex = (currentIndex + step + images.length) % images.length;
                render();
            };

            gallery.querySelectorAll('[data-pj-gallery-open]').forEach(button => {
                button.addEventListener('click', () => open(Number(button.dataset.pjGalleryOpen), button));
            });
            gallery.querySelector('[data-pj-gallery-prev]').addEventListener('click', () => move(-1));
            gallery.querySelector('[data-pj-gallery-next]').addEventListener('click', () => move(1));
            closeButton.addEventListener('click', close);
            lightbox.addEventListener('click', event => {
                if (event.target === lightbox) close();
            });
            document.addEventListener('keydown', event => {
                if (!lightbox.classList.contains('is-open')) return;
                if (event.key === 'Escape') close();
                if (event.key === 'ArrowLeft') move(-1);
                if (event.key === 'ArrowRight') move(1);
            });
        })();
    </script>
@endpush
