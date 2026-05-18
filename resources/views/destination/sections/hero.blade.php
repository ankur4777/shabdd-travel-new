    <section class="destination-st-hero" data-hero-media="image">
        <div class="hero-3d" style="background-image: url('{{ $destination->image_url }}')" aria-hidden="true">
            <div class="hero-layer hero-layer--back"></div>
            <div class="hero-layer hero-layer--mid"></div>
            <div class="hero-layer hero-layer--front"></div>
            <div class="destination-st-hero-overlay" aria-hidden="true"></div>

            <div class="container destination-st-hero-inner">
                <div class="destination-st-hero-copy">
                    <h1 class="destination-hero-word">{{ $destination->name }}</h1>
                    <p class="destination-hero-subtitle">Uncover the World’s Natural Wonders.</p>
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
