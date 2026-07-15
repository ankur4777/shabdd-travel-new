@php
    $travelGalleryItems = collect($items ?? [])
        ->map(function ($item, int $index) {
            if (is_array($item)) {
                $image = $item['image'] ?? $item['url'] ?? $item['path'] ?? '';
                $label = $item['label'] ?? $item['caption'] ?? $item['title'] ?? '';
                $alt = $item['alt'] ?? '';
            } else {
                $image = (string) $item;
                $label = '';
                $alt = '';
            }

            $image = trim((string) $image);

            return [
                'image' => $image,
                'label' => trim((string) $label),
                'alt' => trim((string) ($alt ?: (($title ?? 'Travel gallery') . ' image ' . ($index + 1)))),
            ];
        })
        ->filter(fn ($item) => $item['image'] !== '')
        ->values();

    $travelGalleryId = $galleryId ?? ('travel-gallery-' . substr(md5(($title ?? 'gallery') . $travelGalleryItems->count()), 0, 8));
    $travelGallerySectionId = $sectionId ?? 'gallery';
    $travelGalleryClass = trim('travel-gallery-section ' . ($sectionClass ?? ''));
    $travelGalleryTitle = $title ?? 'Gallery';
    $travelGalleryEyebrow = $eyebrow ?? 'Visual Journey';
    $travelGalleryDescription = $description ?? '';
    $travelGalleryModalTitle = $modalTitle ?? $travelGalleryTitle;
    $travelGallerySpeed = $speed ?? '58s';
@endphp

@if($travelGalleryItems->isNotEmpty())
    <section
        id="{{ $travelGallerySectionId }}"
        class="{{ $travelGalleryClass }} {{ $travelGalleryItems->count() === 1 ? 'is-single' : '' }}"
        style="--travel-gallery-speed: {{ $travelGallerySpeed }};"
        data-travel-gallery="{{ $travelGalleryId }}"
        aria-label="{{ $travelGalleryTitle }}"
    >
        <div class="travel-gallery-section__header">
            <p class="seo-dd-kicker">{{ $travelGalleryEyebrow }}</p>
            <h2 class="seo-dd-title">{{ $travelGalleryTitle }}</h2>
            @if($travelGalleryDescription !== '')
                <p class="travel-gallery-section__lead">{{ $travelGalleryDescription }}</p>
            @endif
        </div>

        <div class="travel-gallery-scroller">
            <div class="travel-gallery-scroller__track">
                @foreach($travelGalleryItems as $item)
                    <button
                        type="button"
                        class="travel-gallery-card"
                        data-travel-gallery-open
                        data-travel-gallery-target="{{ $travelGalleryId }}"
                        data-travel-gallery-index="{{ $loop->index }}"
                        aria-label="Open {{ $travelGalleryTitle }} image {{ $loop->iteration }}"
                    >
                        <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" loading="lazy">
                        @if($item['label'] !== '')
                            <span class="travel-gallery-card__caption">{{ $item['label'] }}</span>
                        @endif
                    </button>
                @endforeach

                @if($travelGalleryItems->count() > 1)
                    @foreach($travelGalleryItems as $item)
                        <button
                            type="button"
                            class="travel-gallery-card"
                            data-travel-gallery-open
                            data-travel-gallery-target="{{ $travelGalleryId }}"
                            data-travel-gallery-index="{{ $loop->index }}"
                            tabindex="-1"
                            aria-label="Open {{ $travelGalleryTitle }} image {{ $loop->iteration }}"
                        >
                            <img src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" loading="lazy">
                            @if($item['label'] !== '')
                                <span class="travel-gallery-card__caption">{{ $item['label'] }}</span>
                            @endif
                        </button>
                    @endforeach
                @endif
            </div>
        </div>

        <script type="application/json" data-travel-gallery-data>
            {!! json_encode($travelGalleryItems->all(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
        </script>
    </section>

    <div class="travel-gallery-lightbox" data-travel-gallery-modal="{{ $travelGalleryId }}" data-travel-gallery-title="{{ $travelGalleryModalTitle }}" aria-hidden="true">
        <div class="travel-gallery-lightbox__backdrop" data-travel-gallery-close></div>
        <div class="travel-gallery-lightbox__panel" role="dialog" aria-modal="true" aria-label="{{ $travelGalleryModalTitle }} gallery">
            <button type="button" class="travel-gallery-lightbox__close" data-travel-gallery-close aria-label="Close gallery">
                <i class="bi bi-x-lg"></i>
            </button>
            <button type="button" class="travel-gallery-lightbox__nav travel-gallery-lightbox__nav--prev" data-travel-gallery-prev aria-label="Previous image">
                <i class="bi bi-arrow-left"></i>
            </button>
            <figure class="travel-gallery-lightbox__figure">
                <img src="{{ $travelGalleryItems->first()['image'] }}" alt="{{ $travelGalleryItems->first()['alt'] }}" data-travel-gallery-image>
                <figcaption class="travel-gallery-lightbox__caption">
                    <strong data-travel-gallery-caption>{{ $travelGalleryItems->first()['label'] ?: $travelGalleryModalTitle }}</strong>
                    <span data-travel-gallery-count>1 / {{ $travelGalleryItems->count() }}</span>
                </figcaption>
            </figure>
            <button type="button" class="travel-gallery-lightbox__nav travel-gallery-lightbox__nav--next" data-travel-gallery-next aria-label="Next image">
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>
@endif

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-travel-gallery]').forEach(function (gallery) {
                    const galleryId = gallery.dataset.travelGallery;
                    const modal = document.querySelector('[data-travel-gallery-modal="' + galleryId + '"]');
                    const dataElement = gallery.querySelector('[data-travel-gallery-data]');
                    let items = [];
                    let activeIndex = 0;

                    try {
                        items = JSON.parse(dataElement ? dataElement.textContent : '[]');
                    } catch (error) {
                        items = [];
                    }

                    if (!modal || items.length === 0) {
                        return;
                    }

                    const image = modal.querySelector('[data-travel-gallery-image]');
                    const caption = modal.querySelector('[data-travel-gallery-caption]');
                    const counter = modal.querySelector('[data-travel-gallery-count]');
                    const previousButton = modal.querySelector('[data-travel-gallery-prev]');
                    const nextButton = modal.querySelector('[data-travel-gallery-next]');
                    const openButtons = document.querySelectorAll('[data-travel-gallery-target="' + galleryId + '"][data-travel-gallery-index]');

                    function render(index) {
                        activeIndex = (index + items.length) % items.length;
                        const item = items[activeIndex];

                        image.src = item.image;
                        image.alt = item.alt || '';
                        caption.textContent = item.label || modal.dataset.travelGalleryTitle || '';
                        counter.textContent = (activeIndex + 1) + ' / ' + items.length;
                    }

                    function open(index) {
                        render(index);
                        modal.classList.add('is-open');
                        modal.setAttribute('aria-hidden', 'false');
                        document.body.classList.add('travel-gallery-lightbox-open');
                    }

                    function close() {
                        modal.classList.remove('is-open');
                        modal.setAttribute('aria-hidden', 'true');
                        document.body.classList.remove('travel-gallery-lightbox-open');
                    }

                    openButtons.forEach(function (button) {
                        button.addEventListener('click', function () {
                            open(Number(button.dataset.travelGalleryIndex || 0));
                        });
                    });

                    modal.querySelectorAll('[data-travel-gallery-close]').forEach(function (button) {
                        button.addEventListener('click', close);
                    });

                    previousButton.addEventListener('click', function () {
                        render(activeIndex - 1);
                    });

                    nextButton.addEventListener('click', function () {
                        render(activeIndex + 1);
                    });

                    document.addEventListener('keydown', function (event) {
                        if (!modal.classList.contains('is-open')) {
                            return;
                        }

                        if (event.key === 'Escape') {
                            close();
                        }

                        if (event.key === 'ArrowLeft') {
                            render(activeIndex - 1);
                        }

                        if (event.key === 'ArrowRight') {
                            render(activeIndex + 1);
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce
