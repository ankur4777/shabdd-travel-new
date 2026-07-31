<header class="st-header">
    <div class="st-topbar st-desktop-only">
        <div class="container st-topbar-inner">
            <div class="st-topbar-cluster">
                <a href="tel:+91-9999999999" class="st-topbar-link">
                    <span class="st-topbar-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path
                                d="M7.56 3h2.11c.44 0 .83.29.95.71l.89 3.13a1 1 0 0 1-.25.98l-1.42 1.42a13.11 13.11 0 0 0 4.92 4.92l1.42-1.42a1 1 0 0 1 .98-.25l3.13.89c.42.12.71.51.71.95v2.11a1 1 0 0 1-.88 1A17.5 17.5 0 0 1 3.44 4.88 1 1 0 0 1 4.44 4h3.12Z"
                                stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span>+91 99999 99999</span>
                </a>
                <span class="st-sep" aria-hidden="true"></span>
                <a href="mailto:support@shabddtravel.com" class="st-topbar-link">
                    <span class="st-topbar-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M4 7.5 12 13l8-5.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <rect x="3.25" y="5.25" width="17.5" height="13.5" rx="2.75" stroke="currentColor"
                                stroke-width="1.5" />
                        </svg>
                    </span>
                    <span>support@shabddtravel.com</span>
                </a>
            </div>

            <div class="st-topbar-cluster st-topbar-actions">
                <a href="{{ route('travel-agent.join') }}" class="st-utility-link">Travel Agent Join Us</a>
                <a href="#" class="st-utility-link st-offers-link">
                    <span>Offers</span>
                    <span class="st-badge">3</span>
                </a>
                <a href="#" class="st-utility-link">Blog</a>
                <a href="#" class="st-utility-link">Download App</a>
                {{-- <a href="#" class="st-login-chip">
                    <span class="st-chip-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.7" />
                            <path d="M5 19.25c1.68-2.69 4.06-4.03 7-4.03 2.94 0 5.32 1.34 7 4.03" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                    </span>
                    <span>Login</span>
                </a> --}}
            </div>
        </div>
    </div>

    <div class="st-nav-shell">
        <nav class="st-navbar navbar navbar-expand-xl" id="stNavbar">
            <div class="container st-nav-inner">
                <a class="st-brand navbar-brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="SHABDD TRAVEL logo">
                    <span class="st-brand-copy st-desktop-only">
                        <span class="st-brand-kicker">Luxury Travel Platform</span>
                        <span class="st-brand-subtitle">Curated holidays across India and beyond</span>
                    </span>
                </a>

                <div class="st-nav-desktop st-desktop-only">
                    <ul class="navbar-nav st-nav-links">
                        <li class="nav-item dropdown">
                            <a class="nav-link st-navlink st-dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span>Domestic Tours</span>
                                <span class="st-dropdown-indicator" aria-hidden="true"></span>
                            </a>
                            <div class="dropdown-menu st-megamenu">
                                <div class="st-mega-grid">
                                    <div class="st-mega-col">
                                        <p class="st-mega-title">Top Destinations</p>
                                        @forelse(($topDomesticDestinations ?? collect()) as $destination)
                                            <a class="dropdown-item st-mega-link"
                                                href="{{ route('destinations.show', $destination->slug) }}">
                                                {{ $destination->name }}
                                            </a>
                                        @empty
                                            <a class="dropdown-item st-mega-link" href="{{ route('destinations.index') }}">
                                                View All Destinations
                                            </a>
                                        @endforelse
                                    </div>
                                    <div class="st-mega-col">
                                        <p class="st-mega-title">Travel Theme</p>
                                        <a class="dropdown-item st-mega-link" href="{{ route('beach-escapes') }}">Beach
                                            Escapes</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('hill-station-retreats') }}">Hill Station Retreats</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('island-getaways') }}">Island Getaways</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('desert-adventures') }}">Desert Adventures</a>
                                    </div>
                                    <div class="st-mega-col">
                                        <p class="st-mega-title">Quick Plan</p>
                                        <a class="dropdown-item st-mega-link" href="{{ route('under-25k') }}">Under 25k
                                            Packages</a>
                                        <a class="dropdown-item st-mega-link" href="{{ route('all-domestic') }}">View
                                            All Domestic Tours</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link st-navlink st-dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span>International Tours</span>
                                <span class="st-dropdown-indicator" aria-hidden="true"></span>
                            </a>
                            <div class="dropdown-menu st-megamenu">
                                <div class="st-mega-grid">
                                    <div class="st-mega-col">
                                        <p class="st-mega-title">Most Booked</p>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('most-booked.show', 'dubai-dream-holidays') }}">Dubai Dream
                                            Holidays</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('most-booked.show', 'thailand-beach-journeys') }}">Thailand
                                            Beach Journeys</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('most-booked.show', 'bali-island-escape') }}">Bali Island
                                            Escape</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('most-booked.show', 'singapore-family-fun') }}">Singapore
                                            Family Fun</a>
                                    </div>
                                    <div class="st-mega-col">
                                        <p class="st-mega-title">Premium Journeys</p>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('premium-journeys.show', 'europe-signature-circuits') }}">Europe
                                            Signature Circuits</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('premium-journeys.show', 'swiss-alpine-luxury') }}">Swiss
                                            Alpine Luxury</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('premium-journeys.show', 'japan-seasonal-trails') }}">Japan
                                            Seasonal Trails</a>
                                        <a class="dropdown-item st-mega-link"
                                            href="{{ route('premium-journeys.show', 'turkey-and-greece') }}">Turkey and
                                            Greece</a>
                                    </div>
                                    <div class="st-mega-col">
                                        <p class="st-mega-title">Travel Help</p>
                                        <a class="dropdown-item st-mega-link" href="{{ route('international-tours.visa-assistance') }}">Visa Assistance</a>
                                        <a class="dropdown-item st-mega-link" href="{{ route('international-tours.group-departures') }}">Group Departures</a>
                                        <a class="dropdown-item st-mega-link" href="{{ route('international-tours.fixed-departure-dates') }}">Fixed Departure Dates</a>
                                        <a class="dropdown-item st-mega-link" href="{{ route('international-tours.index') }}">View All International Tours</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"><a class="nav-link st-navlink"
                                href="{{ route('honeymoon') }}">Honeymoon</a></li>

                        <li class="nav-item">
                            <a class="nav-link st-navlink" href="{{ route('family-trips') }}">
                                Family Trips
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link st-navlink"
                                href="{{ route('religious') }}">Religious</a></li>
                        <li class="nav-item"><a class="nav-link st-navlink" href="{{ route('budget-friendly') }}">Budget
                                Friendly</a></li>
                        <li class="nav-item"><a class="nav-link st-navlink" href="{{ route('blog.index') }}">Blogs</a>
                        </li>

                        <li class="nav-item"><a class="nav-link st-navlink"
                                href="{{ route('contact', [], false) }}">Contact</a></li>
                    </ul>
                </div>

                <div class="st-nav-actions st-desktop-only">
                    <button class="st-iconbtn" type="button" aria-label="Search" data-st-search-open>
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.7" />
                            <path d="m20 20-4.35-4.35" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" />
                        </svg>
                    </button>
                    <a href="#" class="st-iconbtn" aria-label="Login">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.7" />
                            <path d="M4.75 19.25c1.74-2.83 4.16-4.25 7.25-4.25s5.51 1.42 7.25 4.25"
                                stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                        </svg>
                    </a>
                    <a href="#" class="st-cta btn" role="button">
                        <span>Plan My Trip</span>
                        <span class="st-cta-arrow" aria-hidden="true">→</span>
                    </a>
                </div>

                <button class="navbar-toggler st-mobile-only st-mobile-toggle" type="button" id="stMobileToggle"
                    aria-label="Open menu" aria-expanded="false">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>
    </div>

    <div class="st-search-overlay" id="stSearchOverlay" aria-hidden="true"></div>
    <section class="st-search-panel" id="stSearchPanel" aria-hidden="true" aria-label="Site search">
        <div class="st-search-dialog" role="search">
            <div class="st-search-head">
                <form class="st-search-form" id="stSearchForm" autocomplete="off">
                    <span class="st-search-form-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.7" />
                            <path d="m20 20-4.35-4.35" stroke="currentColor" stroke-width="1.7"
                                stroke-linecap="round" />
                        </svg>
                    </span>
                    <input type="search" id="stSearchInput" name="q" placeholder="Search packages, destinations, blogs"
                        aria-label="Search packages, destinations, blogs" aria-describedby="stSearchStatus">
                    <button class="st-search-submit" type="submit">Search</button>
                </form>
                <button class="st-search-close" id="stSearchClose" type="button" aria-label="Close search">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M6 6 18 18M18 6 6 18" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                </button>
            </div>
            <p class="st-search-status" id="stSearchStatus">Type at least 2 characters to search.</p>
            <div class="st-search-results" id="stSearchResults" role="list"></div>
        </div>
    </section>

    <div class="st-mobile-overlay" id="stMobileOverlay" aria-hidden="true"></div>

    <aside class="st-mobile-drawer" id="stMobileDrawer" aria-label="Mobile navigation">
        <div class="st-mobile-head">
            <a class="st-brand" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="SHABDD TRAVEL logo">
            </a>
            <button class="st-mobile-close" id="stMobileClose" aria-label="Close menu">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M6 6 18 18M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                </svg>
            </button>
        </div>

        <div class="st-mobile-utility">
            <a href="tel:+91-9999999999" class="st-mobile-pill">Call Support</a>
            <a href="#" class="st-mobile-pill st-mobile-pill-alt">WhatsApp</a>
        </div>

        <div class="st-mobile-links" id="stMobileLinksMain">
            <div class="st-mobile-menu-item st-has-submenu">
                <button class="st-mobile-link st-mobile-link--tour st-mobile-link--domestic st-mobile-menu-toggle" type="button" data-submenu="domestic"
                    aria-expanded="false">
                    <span class="st-mobile-link-icon" aria-hidden="true">
                        <img class="st-mobile-link-india-icon" src="https://www.svgrepo.com/show/308279/india-map-country.svg" alt="">
                    </span>
                    Domestic Tours <span aria-hidden="true">›</span>
                </button>
            </div>

            <div class="st-mobile-menu-item st-has-submenu">
                <button class="st-mobile-link st-mobile-link--tour st-mobile-link--international st-mobile-menu-toggle" type="button" data-submenu="international"
                    aria-expanded="false">
                    <span class="st-mobile-link-icon" aria-hidden="true"><i class="bi bi-airplane"></i></span>
                    International Tours <span aria-hidden="true">›</span>
                </button>
            </div>

            <a href="{{ route('honeymoon') }}" class="st-mobile-link st-mobile-link--context st-mobile-link--honeymoon">
                <span class="st-mobile-link-icon" aria-hidden="true"><i class="bi bi-heart"></i></span>
                <span>Honeymoon</span>
            </a>

            <a href="{{ route('family-trips') }}" class="st-mobile-link st-mobile-link--context st-mobile-link--family">
                <span class="st-mobile-link-icon" aria-hidden="true"><i class="bi bi-people"></i></span>
                <span>Family Trips</span>
            </a>
            <a href="{{ route('religious') }}" class="st-mobile-link st-mobile-link--context st-mobile-link--religious">
                <span class="st-mobile-link-icon" aria-hidden="true"><i class="bi bi-bank"></i></span>
                <span>Religious</span>
            </a>
            <a href="{{ route('budget-friendly') }}" class="st-mobile-link st-mobile-link--context st-mobile-link--budget">
                <span class="st-mobile-link-icon" aria-hidden="true"><i class="bi bi-wallet2"></i></span>
                <span>Budget Friendly</span>
            </a>
            <a href="{{ route('blog.index') }}" class="st-mobile-link st-mobile-link--context st-mobile-link--blogs">
                <span class="st-mobile-link-icon" aria-hidden="true"><i class="bi bi-journal-text"></i></span>
                <span>Blogs</span>
            </a>


            <a href="{{ route('contact', [], false) }}" class="st-mobile-link st-mobile-link--context st-mobile-link--contact">
                <span class="st-mobile-link-icon" aria-hidden="true"><i class="bi bi-headset"></i></span>
                <span>Contact</span>
            </a>
        </div>

        <div class="st-mobile-submenu" id="stMobileSubmenu">
            <div class="st-mobile-submenu-header">
                <button class="st-mobile-submenu-close" id="stMobileSubmenuClose" type="button"
                    aria-label="Close submenu">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M6 6 18 18M18 6 6 18" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                </button>
                <h3 class="st-mobile-submenu-title-main" id="stMobileSubmenuTitle"></h3>
            </div>

            <div id="stMobileSubmenuContent"></div>
        </div>

        <div class="st-mobile-footer">
            <a href="#" class="st-cta btn">
                <span>Plan My Trip</span>
                <span class="st-cta-arrow" aria-hidden="true">→</span>
            </a>
            <div class="st-mobile-mini-actions">
                <button class="st-iconbtn" type="button" aria-label="Search" data-st-search-open>
                    <svg viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.7" />
                        <path d="m20 20-4.35-4.35" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                    </svg>
                </button>
                <a href="#" class="st-iconbtn" aria-label="Login">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.7" />
                        <path d="M4.75 19.25c1.74-2.83 4.16-4.25 7.25-4.25s5.51 1.42 7.25 4.25" stroke="currentColor"
                            stroke-width="1.7" stroke-linecap="round" />
                    </svg>
                </a>
            </div>
        </div>
    </aside>
</header>

@php
    $topDomesticDestinationLinks = collect($topDomesticDestinations ?? [])
        ->map(function ($destination) {
            return [
                'text' => $destination->name,
                'url' => route('destinations.show', $destination->slug),
            ];
        })
        ->values()
        ->all();
@endphp

<script>
    (function () {
        const overlay = document.getElementById('stMobileOverlay');
        const drawer = document.getElementById('stMobileDrawer');
        const openBtn = document.getElementById('stMobileToggle');
        const closeBtn = document.getElementById('stMobileClose');
        const navbar = document.getElementById('stNavbar');
        const navShell = navbar ? navbar.closest('.st-nav-shell') : null;
        const headerEl = navbar ? navbar.closest('.st-header') : null;
        const desktopMq = window.matchMedia('(min-width: 1200px)');
        const searchEndpoint = @json(route('search.live', [], false));
        const searchOverlay = document.getElementById('stSearchOverlay');
        const searchPanel = document.getElementById('stSearchPanel');
        const searchDialog = searchPanel ? searchPanel.querySelector('.st-search-dialog') : null;
        const searchInput = document.getElementById('stSearchInput');
        const searchForm = document.getElementById('stSearchForm');
        const searchResults = document.getElementById('stSearchResults');
        const searchStatus = document.getElementById('stSearchStatus');
        const searchClose = document.getElementById('stSearchClose');
        const searchOpeners = document.querySelectorAll('[data-st-search-open]');
        let searchTimer = null;
        let searchAbortController = null;
        let latestSearchResults = [];

        if (!overlay || !drawer || !openBtn || !closeBtn || !navbar) {
            return;
        }

        // Submenu data structure
        const topDomesticDestinations = @json($topDomesticDestinationLinks);

        const submenuData = {
            domestic: {
                title: 'Domestic Tours',
                sections: [
                    {
                        title: 'Top Destinations',
                        items: topDomesticDestinations.length ? topDomesticDestinations : [
                            { text: 'View All Destinations', url: @json(route('destinations.index')) }
                        ]
                    },
                    {
                        title: 'Travel Styles',
                        items: [
                            { text: 'Beach Escapes', url: 'beach-escapes' },
                            { text: 'Hill Station Tours', url: @json(route('hill-station-retreats')) },
                            { text: 'Island Getaways', url: @json(route('island-getaways')) },
                            { text: 'Desert Adventures', url: @json(route('desert-adventures')) }
                        ]
                    },
                    {
                        title: 'Quick Plan',
                        items: [
                            { text: 'Under 25k Packages', url: @json(route('under-25k')) },
                            { text: 'View All Domestic Tours', url: @json(route('all-domestic')) }
                        ]
                    }
                ]
            },
            international: {
                title: 'International Tours',
                sections: [
                    {
                        title: 'Most Booked',
                        items: [
                            { text: 'Dubai Dream Holidays', url: @json(route('most-booked.show', 'dubai-dream-holidays')) },
                            { text: 'Thailand Beach Journeys', url: @json(route('most-booked.show', 'thailand-beach-journeys')) },
                            { text: 'Bali Island Escape', url: @json(route('most-booked.show', 'bali-island-escape')) },
                            { text: 'Singapore Family Fun', url: @json(route('most-booked.show', 'singapore-family-fun')) }
                        ]
                    },
                    {
                        title: 'Premium Journeys',
                        items: [
                            { text: 'Europe Signature Circuits', url: @json(route('premium-journeys.show', 'europe-signature-circuits')) },
                            { text: 'Swiss Alpine Luxury', url: @json(route('premium-journeys.show', 'swiss-alpine-luxury')) },
                            { text: 'Japan Seasonal Trails', url: @json(route('premium-journeys.show', 'japan-seasonal-trails')) },
                            { text: 'Turkey and Greece', url: @json(route('premium-journeys.show', 'turkey-and-greece')) }
                        ]
                    },
                    {
                        title: 'Travel Help',
                        items: [
                            { text: 'Visa Assistance', url: @json(route('international-tours.visa-assistance')) },
                            { text: 'Group Departures', url: @json(route('international-tours.group-departures')) },
                            { text: 'Fixed Departure Dates', url: @json(route('international-tours.fixed-departure-dates')) },
                            { text: 'View All International Tours', url: @json(route('international-tours.index')) }
                        ]
                    }
                ]
            }
        };

        const updateFixedOffset = function () {
            if (!headerEl || !navShell) {
                return;
            }

            headerEl.style.setProperty('--st-nav-fixed-offset', `${navShell.offsetHeight}px`);
        };

        const setScrolledState = function () {
            const isScrolled = window.scrollY > 10;
            const shouldFixNavbar = isScrolled;
            navbar.classList.toggle('st-scrolled', isScrolled);

            if (navShell) {
                navShell.classList.toggle('st-shell-fixed', shouldFixNavbar);
            }

            if (headerEl) {
                headerEl.classList.toggle('st-header-nav-fixed', shouldFixNavbar);

                if (shouldFixNavbar) {
                    updateFixedOffset();
                } else {
                    headerEl.style.removeProperty('--st-nav-fixed-offset');
                }
            }
        };

        const open = function () {
            overlay.classList.add('show');
            drawer.classList.add('show');
            openBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        };

        const close = function () {
            overlay.classList.remove('show');
            drawer.classList.remove('show');
            openBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
            // Close any open submenu
            closeSubmenu();
        };

        const setSearchMessage = function (message) {
            if (searchStatus) {
                searchStatus.textContent = message;
            }
        };

        const clearSearchResults = function () {
            latestSearchResults = [];

            if (searchResults) {
                searchResults.innerHTML = '';
            }
        };

        const createSearchResult = function (item) {
            const link = document.createElement('a');
            link.className = 'st-search-result';
            link.href = item.url;
            link.setAttribute('role', 'listitem');

            const media = document.createElement('span');
            media.className = 'st-search-result-media';

            const image = document.createElement('img');
            image.src = item.image;
            image.alt = '';
            image.loading = 'lazy';
            media.appendChild(image);

            const content = document.createElement('span');
            content.className = 'st-search-result-content';

            const meta = document.createElement('span');
            meta.className = 'st-search-result-meta';
            meta.textContent = item.type + (item.subtitle ? ' • ' + item.subtitle : '');

            const title = document.createElement('span');
            title.className = 'st-search-result-title';
            title.textContent = item.title;

            const description = document.createElement('span');
            description.className = 'st-search-result-desc';
            description.textContent = item.price || item.description || 'View details';

            content.appendChild(meta);
            content.appendChild(title);
            content.appendChild(description);

            link.appendChild(media);
            link.appendChild(content);

            return link;
        };

        const renderSearchResults = function (items, query) {
            clearSearchResults();
            latestSearchResults = items;

            if (!searchResults) {
                return;
            }

            if (!items.length) {
                setSearchMessage(query ? `No results found for "${query}".` : 'Type at least 2 characters to search.');
                return;
            }

            setSearchMessage(`${items.length} result${items.length === 1 ? '' : 's'} found.`);
            items.forEach(item => searchResults.appendChild(createSearchResult(item)));
        };

        const runSearch = function () {
            const query = searchInput ? searchInput.value.trim() : '';

            if (searchAbortController) {
                searchAbortController.abort();
            }

            if (query.length < 2) {
                clearSearchResults();
                setSearchMessage('Type at least 2 characters to search.');
                return;
            }

            searchAbortController = new AbortController();
            setSearchMessage('Searching...');

            fetch(`${searchEndpoint}?q=${encodeURIComponent(query)}`, {
                signal: searchAbortController.signal,
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => response.ok ? response.json() : Promise.reject(response))
                .then(data => renderSearchResults(data.results || [], data.query || query))
                .catch(error => {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    clearSearchResults();
                    setSearchMessage('Search is unavailable right now. Please try again.');
                });
        };

        const openSearch = function () {
            if (!searchOverlay || !searchPanel || !searchInput) {
                return;
            }

            close();
            searchOverlay.classList.add('show');
            searchPanel.classList.add('show');
            searchOverlay.setAttribute('aria-hidden', 'false');
            searchPanel.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            window.setTimeout(() => searchInput.focus(), 80);
        };

        const closeSearch = function () {
            if (!searchOverlay || !searchPanel) {
                return;
            }

            searchOverlay.classList.remove('show');
            searchPanel.classList.remove('show');
            searchOverlay.setAttribute('aria-hidden', 'true');
            searchPanel.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        const showSubmenu = function (submenuId) {
            const submenuEl = document.getElementById('stMobileSubmenu');
            const mainLinksEl = document.getElementById('stMobileLinksMain');
            const data = submenuData[submenuId];

            if (!data) return;

            // Update title
            document.getElementById('stMobileSubmenuTitle').textContent = data.title;

            // Build content
            const contentEl = document.getElementById('stMobileSubmenuContent');
            contentEl.innerHTML = '';

            data.sections.forEach(section => {
                const sectionEl = document.createElement('div');
                sectionEl.className = 'st-mobile-submenu-section';

                const titleEl = document.createElement('p');
                titleEl.className = 'st-mobile-submenu-title';
                titleEl.textContent = section.title;
                sectionEl.appendChild(titleEl);

                section.items.forEach(item => {
                    const linkEl = document.createElement('a');
                    linkEl.href = item.url;
                    linkEl.className = 'st-mobile-submenu-link';
                    linkEl.textContent = item.text;
                    sectionEl.appendChild(linkEl);
                });

                contentEl.appendChild(sectionEl);
            });

            // Show submenu, hide main menu
            mainLinksEl.style.display = 'none';
            submenuEl.classList.add('show');
        };

        const closeSubmenu = function () {
            const submenuEl = document.getElementById('stMobileSubmenu');
            const mainLinksEl = document.getElementById('stMobileLinksMain');

            submenuEl.classList.remove('show');
            mainLinksEl.style.display = 'flex';
        };

        // Menu toggle buttons
        const menuToggles = drawer.querySelectorAll('.st-mobile-menu-toggle');
        menuToggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const submenuId = this.getAttribute('data-submenu');
                showSubmenu(submenuId);
            });
        });

        // Close submenu button
        const closeSubmenuBtn = document.getElementById('stMobileSubmenuClose');
        if (closeSubmenuBtn) {
            closeSubmenuBtn.addEventListener('click', closeSubmenu);
        }

        searchOpeners.forEach(button => {
            button.addEventListener('click', openSearch);
        });

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                window.clearTimeout(searchTimer);
                searchTimer = window.setTimeout(runSearch, 220);
            });
        }

        if (searchForm) {
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();

                if (latestSearchResults[0]) {
                    window.location.href = latestSearchResults[0].url;
                    return;
                }

                runSearch();
            });
        }

        if (searchClose) {
            searchClose.addEventListener('click', closeSearch);
        }

        if (searchOverlay) {
            searchOverlay.addEventListener('click', closeSearch);
        }

        if (searchDialog) {
            searchDialog.addEventListener('click', event => event.stopPropagation());
        }

        window.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSearch();
            }
        });

        setScrolledState();
        window.addEventListener('scroll', setScrolledState, { passive: true });
        window.addEventListener('resize', setScrolledState, { passive: true });

        if (desktopMq.addEventListener) {
            desktopMq.addEventListener('change', setScrolledState);
        } else if (desktopMq.addListener) {
            desktopMq.addListener(setScrolledState);
        }

        openBtn.addEventListener('click', open);
        closeBtn.addEventListener('click', close);
        overlay.addEventListener('click', close);
    })();
</script>
