@php
    $heroMediaUrl = function ($path) {
        if (is_array($path)) {
            $path = $path['path'] ?? $path['url'] ?? $path[0] ?? '';
        }

        $path = trim((string) $path);

        if ($path === '') {
            return asset('images/couple-bg.jpg');
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/', 'storage/', '/images/', 'images/'])) {
            return asset(ltrim($path, '/'));
        }

        if (\Illuminate\Support\Str::startsWith($path, 'livewire-file:')) {
            return asset('storage/livewire-tmp/' . \Illuminate\Support\Str::after($path, 'livewire-file:'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $heroVideo = $destination->hero_video ? $heroMediaUrl($destination->hero_video) : null;
    $heroCards = collect($destination->hero_cards ?? [])
        ->filter(fn ($card) => is_array($card) && filled($card['title'] ?? null))
        ->take(3)
        ->values();
    $heroDescription = trim((string) ($destination->hero_description ?: $destination->short_description));
    $heroPrimaryUrl = $destination->hero_primary_url ?: '#destination-packages';
    $heroSecondaryUrl = $destination->hero_secondary_url ?: '#destination-gallery';
@endphp

<section class="destination-st-hero destination-cinematic-hero" data-hero-media="video">
    <div class="hero-3d" aria-hidden="true">
        @if ($heroVideo)
            <video class="destination-st-hero-video" autoplay muted loop playsinline preload="auto">
                <source src="{{ $heroVideo }}" type="video/mp4">
            </video>
        @endif
        <div class="hero-layer hero-layer--back"></div>
        <div class="hero-layer hero-layer--mid"></div>
        <div class="hero-layer hero-layer--front"></div>
        <div class="destination-st-hero-overlay" aria-hidden="true"></div>

        <div class="container destination-st-hero-inner">
            <div class="destination-st-hero-copy">
                @if ($destination->hero_subtitle)
                    <p class="destination-st-hero-eyebrow"><span class="st-eyebrow-dot"></span>{{ $destination->hero_subtitle }}</p>
                @endif
                <h1 class="destination-st-hero-title">{{ $destination->name }}</h1>
                @if ($heroDescription)
                    <p class="destination-st-hero-text">{{ $heroDescription }}</p>
                @endif
                @if ($destination->hero_primary_text || $destination->hero_secondary_text)
                    <div class="destination-st-hero-actions">
                        @if ($destination->hero_primary_text)
                            <a class="destination-st-hero-btn destination-st-hero-btn--primary" href="{{ $heroPrimaryUrl }}">{{ $destination->hero_primary_text }} <span aria-hidden="true">&rarr;</span></a>
                        @endif
                        @if ($destination->hero_secondary_text)
                            <a class="destination-st-hero-btn destination-st-hero-btn--ghost" href="{{ $heroSecondaryUrl }}">{{ $destination->hero_secondary_text }}</a>
                        @endif
                    </div>
                @endif
            </div>

            @if ($heroCards->isNotEmpty())
                <div class="destination-hero-cards" aria-label="Highlights for {{ $destination->name }}">
                    @foreach ($heroCards as $card)
                        @php
                            $cardImage = $card['image'] ?? null;
                            $cardImage = $cardImage ? $heroMediaUrl($cardImage) : null;
                            $cardUrl = $card['url'] ?? null;
                        @endphp
                        <article class="destination-hero-card destination-hero-card--{{ $loop->iteration }}">
                            @if ($cardUrl)
                                <a class="destination-hero-card-link" href="{{ $cardUrl }}" aria-label="Explore {{ $card['title'] }}"></a>
                            @endif
                            <div class="destination-hero-card-image" @if ($cardImage) style="background-image:url('{{ $cardImage }}')" @endif></div>
                            <div class="destination-hero-card-content">
                                @if (!empty($card['badge']))
                                    <span class="destination-hero-card-badge">{{ $card['badge'] }}</span>
                                @endif
                                <h2>{{ $card['title'] }}</h2>
                                @if (!empty($card['description']))
                                    <p>{{ $card['description'] }}</p>
                                @endif
                                @if (filled($card['rating'] ?? null))
                                    <div class="destination-hero-card-rating" aria-label="Rated {{ $card['rating'] }} out of 5">{{ str_repeat('★', (int) round((float) $card['rating'])) }} <span>{{ number_format((float) $card['rating'], 1) }}</span></div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
    </div>

    <div class="destination-st-hero-searchbar-wrap">
        <div class="container">
            <form class="st-searchbar" id="heroSearchbar" action="{{ route('destinations.show', $destination) }}"
                method="get">
                <div class="st-sb-field" id="sbLocField" role="button" tabindex="0" aria-expanded="false">
                    <svg class="st-sb-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                            stroke="currentColor" stroke-width="1.7" />
                        <circle cx="12" cy="9.5" r="2.8" stroke="currentColor" stroke-width="1.7" />
                    </svg>
                    <div class="st-sb-field-inner">
                        <label class="st-sb-label" for="sbLocInput">Location</label>
                        <input id="sbLocInput" name="city" class="st-sb-input"
                            value="{{ request('city', $locationOptions[0] ?? $destination->name) }}"
                            placeholder="Select location" readonly />
                    </div>
                    <svg class="st-sb-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        aria-hidden="true">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div class="st-sb-dropdown" id="sbLocDropdown">
                        <div class="st-sb-dropdown-search">
                            <input type="text" id="sbLocSearch" placeholder="Search city" />
                        </div>
                        <div class="st-sb-dropdown-list" id="sbLocList"></div>
                    </div>
                </div>

                <div class="st-sb-divider"></div>

                <div class="st-sb-field" id="sbMonthField" role="button" tabindex="0" aria-expanded="false">
                    <svg class="st-sb-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="3.5" y="5" width="17" height="15" rx="2.5" stroke="currentColor" stroke-width="1.6" />
                        <path d="M3.5 9.5h17M8 3.5v3M16 3.5v3" stroke="currentColor" stroke-width="1.6"
                            stroke-linecap="round" />
                    </svg>
                    <div class="st-sb-field-inner">
                        <label class="st-sb-label" for="sbMonthInput">Month</label>
                        <input id="sbMonthInput" name="month" class="st-sb-input" value="{{ request('month', '') }}"
                            placeholder="Select month" readonly />
                    </div>
                    <svg class="st-sb-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        aria-hidden="true">
                        <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div class="st-sb-dropdown" id="sbMonthDropdown"></div>
                </div>

                <button class="st-sb-search-btn" type="submit">Explore</button>
            </form>
        </div>
    </div>
</section>

<script>
    window.ST_PAGE_SEARCH_DATA = {
        locations: @json($locationOptions),
        months: @json($monthOptions),
    };
</script>
