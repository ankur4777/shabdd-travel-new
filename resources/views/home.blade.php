@extends('layouts.app')

@section('content')
    <section class="st-hero" data-hero-media="image" style="--hero-image:none;">
        <!-- Switch to video background by setting data-hero-media="video" -->
        <!-- Add your image URL in --hero-image and add your video source below -->
        <video class="st-hero-video" autoplay muted loop playsinline>
            <!-- <source src="{{ asset('videos/your-hero.mp4') }}" type="video/mp4"> -->
        </video>

        <div class="st-hero-overlay" aria-hidden="true"></div>

        <div class="container st-hero-inner">
            <div class="st-hero-copy">
                <h1 class="st-hero-title">
                    Explore The World<br>With SHABDD
                </h1>

                <p class="st-hero-text">
                    Customized travel experiences for unforgettable journeys. Discover hidden gems,
                    meet local experts, and create memories that last a lifetime.
                </p>

                <div class="st-hero-actions">
                    <a href="#" class="btn st-hero-btn st-hero-btn-primary">Explore Tours</a>
                    <a href="#" class="btn st-hero-btn st-hero-btn-outline">Customize Trip</a>
                </div>
            </div>

            <div class="st-hero-card">
                <h2 class="st-hero-card-title">Plan Your Journey</h2>

                <form action="#" method="get" class="st-hero-form">
                    <div class="st-field-group">
                        <label class="st-field-label" for="hero-destination">Destination</label>
                        <input id="hero-destination" type="text" class="form-control st-field-control"
                            placeholder="Where do you want to go?">
                    </div>

                    <div class="st-hero-form-row">
                        <div class="st-field-group">
                            <label class="st-field-label" for="hero-budget">Budget</label>
                            <select id="hero-budget" class="form-select st-field-control">
                                <option>Any Budget</option>
                                <option>Under 25,000</option>
                                <option>25,000 - 50,000</option>
                                <option>50,000 - 1,00,000</option>
                                <option>Luxury 1,00,000+</option>
                            </select>
                        </div>

                        <div class="st-field-group">
                            <label class="st-field-label" for="hero-duration">Duration</label>
                            <select id="hero-duration" class="form-select st-field-control">
                                <option>Any Duration</option>
                                <option>2 - 4 Days</option>
                                <option>5 - 7 Days</option>
                                <option>8 - 12 Days</option>
                                <option>12+ Days</option>
                            </select>
                        </div>
                    </div>

                    <div class="st-field-group">
                        <label class="st-field-label" for="hero-date">Travel Date</label>
                        <div class="st-date-field">
                            <input id="hero-date" type="date" class="form-control st-field-control">
                            <span class="st-date-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <rect x="3.75" y="4.75" width="16.5" height="15.5" rx="2.5" stroke="currentColor"
                                        stroke-width="1.7" />
                                    <path d="M3.75 9.25h16.5M8 3.75v3M16 3.75v3" stroke="currentColor" stroke-width="1.7"
                                        stroke-linecap="round" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn st-hero-search-btn">Search Tours</button>
                </form>
            </div>
        </div>
    </section>

    <section class="st-offers-slider-section">
        <div class="container">
            <div class="st-offers-slider-head">
                <h2 class="st-offers-slider-title">Tourist Offers</h2>
                <p class="st-offers-slider-subtitle">Limited-time deals curated for unforgettable holidays.</p>
            </div>

            <div id="offersCarousel" class="carousel slide st-offers-carousel" data-bs-ride="carousel"
                data-bs-interval="4000">
                <div class="carousel-inner">

                    <div class="carousel-item active st-offers-slide"
                        style="background-image:url('{{ asset('images/himachal.jpg') }}');">
                        <div class="st-offers-slide-overlay" aria-hidden="true"></div>
                        <div class="st-offers-slide-content">
                            <span class="st-offers-pill">Domestic Special</span>
                            <h3 class="st-offers-slide-title">Himachal Monsoon Getaway</h3>
                            <p class="st-offers-slide-text">3 nights • Scenic hill routes • Local stays</p>
                            <a class="st-offers-slide-cta" href="#">Book Now</a>
                        </div>
                    </div>

                    <div class="carousel-item st-offers-slide"
                        style="background-image:url('{{ asset('images/dubai.jpg') }}');">
                        <div class="st-offers-slide-overlay" aria-hidden="true"></div>
                        <div class="st-offers-slide-content">
                            <span class="st-offers-pill">International Escape</span>
                            <h3 class="st-offers-slide-title">Dubai Luxe Weekend</h3>
                            <p class="st-offers-slide-text">2 nights • Desert safari • Premium hotels</p>
                            <a class="st-offers-slide-cta" href="#">Book Now</a>
                        </div>
                    </div>

                    <div class="carousel-item st-offers-slide"
                        style="background-image:url('{{ asset('images/kerala.avif') }}');">
                        <div class="st-offers-slide-overlay" aria-hidden="true"></div>
                        <div class="st-offers-slide-content">
                            <span class="st-offers-pill">Family & Friends</span>
                            <h3 class="st-offers-slide-title">Kerala Backwaters Recharged</h3>
                            <p class="st-offers-slide-text">4 nights • Houseboat cruise • Ayurveda stops</p>
                            <a class="st-offers-slide-cta" href="#">Book Now</a>
                        </div>
                    </div>

                </div>

                <button class="carousel-control-prev st-offers-carousel-control" type="button"
                    data-bs-target="#offersCarousel" data-bs-slide="prev" aria-label="Previous slide">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next st-offers-carousel-control" type="button"
                    data-bs-target="#offersCarousel" data-bs-slide="next" aria-label="Next slide">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>

                <div class="carousel-indicators st-offers-indicators">
                    <button type="button" data-bs-target="#offersCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#offersCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#offersCarousel" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
            </div>
        </div>
    </section>

    {{--
    ============================================================
    SECTION: Explore Destinations by Theme
    FILE: resources/views/partials/explore-themes.blade.php
    INCLUDE: @include('partials.explore-themes') in your page
    ============================================================
    --}}

    <section class="st-themes-section">
        <div class="st-themes-wrapper">

            {{-- ── Section Header ── --}}
            <div class="st-themes-header">
                <div class="st-themes-header-left">
                    <h2 class="st-themes-title">Pick Your Perfect Escape</h2>
                </div>
                <div class="st-themes-header-right">
                    <span class="bi bi-star-fill text-warning"></span>Trusted by 10,000+
                    <a class="st-themes-phone-number">Travelers Worldwide</a>
                </div>
            </div>

            {{-- ── Slider Track Container ── --}}
            <div class="st-themes-slider-outer" id="themesSliderOuter">

                {{-- Left Arrow (hidden on first load) --}}
                <button class="st-themes-arrow st-themes-arrow-left" id="themesArrowLeft" aria-label="Scroll left"
                    style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                {{-- Card Track --}}
                <div class="st-themes-track" id="themesTrack">

                    {{-- Card 1: Honeymoon --}}
                    <div class="st-theme-card" data-theme="honeymoon">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#f472b6 0%,#ec4899 40%,#be185d 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Eiffel Tower silhouette -->
                                <rect x="88" y="60" width="4" height="140" fill="rgba(255,255,255,0.25)" rx="2" />
                                <polygon points="90,60 82,120 98,120" fill="rgba(255,255,255,0.35)" />
                                <rect x="80" y="120" width="20" height="4" fill="rgba(255,255,255,0.3)" rx="1" />
                                <rect x="76" y="140" width="28" height="4" fill="rgba(255,255,255,0.3)" rx="1" />
                                <!-- Couple silhouette -->
                                <ellipse cx="65" cy="195" rx="14" ry="30" fill="rgba(255,255,255,0.18)" />
                                <ellipse cx="115" cy="195" rx="12" ry="28" fill="rgba(255,255,255,0.15)" />
                                <circle cx="63" cy="160" r="10" fill="rgba(255,255,255,0.22)" />
                                <circle cx="115" cy="162" r="9" fill="rgba(255,255,255,0.18)" />
                                <!-- Hearts -->
                                <text x="130" y="80" font-size="18" fill="rgba(255,255,255,0.55)">♥</text>
                                <text x="48" y="70" font-size="12" fill="rgba(255,255,255,0.4)">♥</text>
                                <!-- City buildings -->
                                <rect x="10" y="170" width="30" height="60" fill="rgba(180,0,80,0.35)" rx="3" />
                                <rect x="150" y="160" width="40" height="70" fill="rgba(180,0,80,0.3)" rx="3" />
                                <rect x="140" y="180" width="20" height="50" fill="rgba(180,0,80,0.25)" rx="2" />
                                <!-- Ground -->
                                <rect x="0" y="220" width="200" height="20" fill="rgba(150,0,60,0.3)" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Honeymoon / Romantic</span>
                            <span class="st-theme-count">60+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 2: Family --}}
                    <div class="st-theme-card" data-theme="family">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#fde68a 0%,#f59e0b 45%,#d97706 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Beach / sky -->
                                <ellipse cx="160" cy="50" rx="28" ry="28" fill="rgba(255,255,255,0.2)" />
                                <!-- Family figures -->
                                <circle cx="70" cy="120" r="14" fill="rgba(255,255,255,0.28)" />
                                <rect x="58" y="134" width="24" height="52" fill="rgba(255,255,255,0.22)" rx="8" />
                                <circle cx="120" cy="125" r="12" fill="rgba(255,255,255,0.24)" />
                                <rect x="109" y="137" width="22" height="48" fill="rgba(255,255,255,0.18)" rx="7" />
                                <!-- Kid -->
                                <circle cx="155" cy="145" r="9" fill="rgba(255,255,255,0.22)" />
                                <rect x="147" y="154" width="16" height="36" fill="rgba(255,255,255,0.18)" rx="5" />
                                <!-- Ground wave -->
                                <path d="M0 200 Q50 185 100 200 Q150 215 200 200 L200 240 L0 240Z"
                                    fill="rgba(180,120,0,0.35)" />
                                <!-- Bag -->
                                <rect x="108" y="155" width="12" height="18" fill="rgba(255,200,0,0.4)" rx="3" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Family</span>
                            <span class="st-theme-count">70+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 3: Friends / Group --}}
                    <div class="st-theme-card" data-theme="friends">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#6ee7b7 0%,#34d399 40%,#059669 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Trees -->
                                <ellipse cx="40" cy="80" rx="28" ry="45" fill="rgba(255,255,255,0.15)" />
                                <rect x="36" y="120" width="8" height="40" fill="rgba(0,100,60,0.3)" rx="3" />
                                <ellipse cx="160" cy="70" rx="24" ry="40" fill="rgba(255,255,255,0.12)" />
                                <rect x="156" y="105" width="8" height="40" fill="rgba(0,100,60,0.25)" rx="3" />
                                <!-- Ground -->
                                <ellipse cx="100" cy="210" rx="90" ry="20" fill="rgba(0,120,70,0.3)" />
                                <!-- 3 sitting figures -->
                                <circle cx="65" cy="170" r="11" fill="rgba(255,255,255,0.3)" />
                                <ellipse cx="65" cy="192" rx="14" ry="18" fill="rgba(255,255,255,0.2)" />
                                <circle cx="100" cy="165" r="11" fill="rgba(255,255,255,0.28)" />
                                <ellipse cx="100" cy="187" rx="14" ry="18" fill="rgba(255,255,255,0.18)" />
                                <circle cx="135" cy="170" r="11" fill="rgba(255,255,255,0.3)" />
                                <ellipse cx="135" cy="192" rx="14" ry="18" fill="rgba(255,255,255,0.2)" />
                                <!-- Campfire -->
                                <ellipse cx="100" cy="200" rx="10" ry="4" fill="rgba(255,150,0,0.5)" />
                                <path d="M97 198 Q100 185 103 198" stroke="rgba(255,100,0,0.8)" stroke-width="3"
                                    stroke-linecap="round" />
                                <path d="M99 196 Q100 187 101 196" stroke="rgba(255,200,0,0.7)" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Friends / Group</span>
                            <span class="st-theme-count">10+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 4: Solo --}}
                    <div class="st-theme-card" data-theme="solo">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#fcd34d 0%,#f97316 45%,#b45309 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Sun / sky glow -->
                                <circle cx="130" cy="55" r="32" fill="rgba(255,230,100,0.3)" />
                                <circle cx="130" cy="55" r="20" fill="rgba(255,220,50,0.45)" />
                                <!-- Mountains / trees -->
                                <polygon points="0,180 60,80 120,180" fill="rgba(180,80,0,0.35)" />
                                <polygon points="80,180 140,90 200,180" fill="rgba(150,60,0,0.3)" />
                                <!-- Solo hiker figure -->
                                <circle cx="80" cy="148" r="12" fill="rgba(255,255,255,0.35)" />
                                <rect x="70" y="160" width="20" height="38" fill="rgba(255,255,255,0.28)" rx="6" />
                                <!-- Backpack -->
                                <rect x="83" y="162" width="12" height="22" fill="rgba(255,200,100,0.45)" rx="4" />
                                <!-- Walking stick -->
                                <line x1="65" y1="160" x2="55" y2="200" stroke="rgba(255,255,255,0.5)" stroke-width="3"
                                    stroke-linecap="round" />
                                <!-- Birds -->
                                <path d="M140 40 Q144 36 148 40" stroke="rgba(255,255,255,0.55)" stroke-width="1.5"
                                    stroke-linecap="round" fill="none" />
                                <path d="M155 32 Q159 28 163 32" stroke="rgba(255,255,255,0.45)" stroke-width="1.5"
                                    stroke-linecap="round" fill="none" />
                                <path d="M165 48 Q168 44 172 48" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"
                                    stroke-linecap="round" fill="none" />
                                <!-- Ground -->
                                <rect x="0" y="198" width="200" height="42" fill="rgba(120,50,0,0.3)" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Solo</span>
                            <span class="st-theme-count">130+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 5: Adventure --}}
                    <div class="st-theme-card" data-theme="adventure">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#7dd3fc 0%,#0284c7 45%,#075985 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Underwater bg -->
                                <ellipse cx="100" cy="130" rx="90" ry="70" fill="rgba(255,255,255,0.06)" />
                                <!-- Diver figure - skydiving pose -->
                                <circle cx="110" cy="70" r="14" fill="rgba(255,255,255,0.35)" />
                                <!-- Body spread arms -->
                                <rect x="90" y="82" width="40" height="14" fill="rgba(255,255,255,0.28)" rx="7" />
                                <!-- Left arm -->
                                <rect x="55" y="80" width="38" height="10" fill="rgba(255,255,255,0.22)" rx="5"
                                    transform="rotate(-20 55 80)" />
                                <!-- Right arm -->
                                <rect x="128" y="78" width="38" height="10" fill="rgba(255,255,255,0.22)" rx="5"
                                    transform="rotate(20 128 78)" />
                                <!-- Legs -->
                                <rect x="95" y="94" width="10" height="34" fill="rgba(255,255,255,0.2)" rx="5"
                                    transform="rotate(-15 95 94)" />
                                <rect x="112" y="94" width="10" height="34" fill="rgba(255,255,255,0.2)" rx="5"
                                    transform="rotate(15 112 94)" />
                                <!-- Fish bubbles -->
                                <circle cx="40" cy="150" r="6" fill="rgba(255,255,255,0.18)" />
                                <circle cx="55" cy="165" r="4" fill="rgba(255,255,255,0.14)" />
                                <circle cx="160" cy="145" r="5" fill="rgba(255,255,255,0.16)" />
                                <!-- Fish shapes -->
                                <ellipse cx="50" cy="180" rx="18" ry="8" fill="rgba(255,255,255,0.18)" />
                                <polygon points="68,180 78,172 78,188" fill="rgba(255,255,255,0.14)" />
                                <ellipse cx="130" cy="195" rx="15" ry="7" fill="rgba(255,255,255,0.15)" />
                                <polygon points="145,195 154,189 154,201" fill="rgba(255,255,255,0.12)" />
                                <!-- Clouds top -->
                                <ellipse cx="30" cy="30" rx="30" ry="14" fill="rgba(255,255,255,0.18)" />
                                <ellipse cx="170" cy="22" rx="24" ry="12" fill="rgba(255,255,255,0.14)" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Adventure</span>
                            <span class="st-theme-count">30+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 6: Nature --}}
                    <div class="st-theme-card" data-theme="nature">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#a7f3d0 0%,#10b981 45%,#065f46 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Snow mountain -->
                                <polygon points="100,20 30,160 170,160" fill="rgba(255,255,255,0.25)" />
                                <polygon points="100,20 80,70 120,70" fill="rgba(255,255,255,0.45)" />
                                <!-- Second peak -->
                                <polygon points="160,60 110,160 200,160" fill="rgba(255,255,255,0.15)" />
                                <!-- Forest -->
                                <ellipse cx="30" cy="185" rx="22" ry="35" fill="rgba(0,100,50,0.4)" />
                                <ellipse cx="60" cy="175" rx="20" ry="32" fill="rgba(0,120,60,0.35)" />
                                <ellipse cx="155" cy="180" rx="20" ry="32" fill="rgba(0,100,50,0.38)" />
                                <ellipse cx="178" cy="190" rx="18" ry="28" fill="rgba(0,120,60,0.32)" />
                                <!-- Houses / village -->
                                <rect x="85" y="175" width="18" height="18" fill="rgba(255,255,255,0.3)" rx="2" />
                                <polygon points="85,175 94,163 103,175" fill="rgba(255,255,255,0.4)" />
                                <rect x="108" y="180" width="14" height="14" fill="rgba(255,255,255,0.25)" rx="2" />
                                <polygon points="108,180 115,170 122,180" fill="rgba(255,255,255,0.35)" />
                                <!-- Ground -->
                                <rect x="0" y="210" width="200" height="30" fill="rgba(0,80,40,0.4)" />
                                <!-- Birds -->
                                <path d="M145 40 Q149 36 153 40" stroke="rgba(255,255,255,0.5)" stroke-width="1.5"
                                    fill="none" stroke-linecap="round" />
                                <path d="M158 32 Q162 28 166 32" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"
                                    fill="none" stroke-linecap="round" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Nature</span>
                            <span class="st-theme-count">100+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 7: Religious --}}
                    <div class="st-theme-card" data-theme="religious">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#fbbf24 0%,#d97706 45%,#92400e 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Sun halo -->
                                <circle cx="100" cy="60" r="38" fill="rgba(255,240,180,0.22)" />
                                <circle cx="100" cy="60" r="24" fill="rgba(255,230,100,0.35)" />
                                <!-- Temple / church dome -->
                                <ellipse cx="100" cy="95" rx="28" ry="20" fill="rgba(255,255,255,0.25)" />
                                <!-- Flag / cross on top -->
                                <rect x="98" y="45" width="4" height="50" fill="rgba(255,255,255,0.4)" rx="2" />
                                <rect x="86" y="55" width="28" height="5" fill="rgba(255,255,255,0.35)" rx="2" />
                                <!-- Main temple body -->
                                <rect x="72" y="115" width="56" height="80" fill="rgba(255,255,255,0.2)" rx="4" />
                                <!-- Arch entrance -->
                                <path d="M88 195 Q100 175 112 195" fill="rgba(150,80,0,0.4)" />
                                <rect x="88" y="185" width="24" height="15" fill="rgba(150,80,0,0.35)" />
                                <!-- Side minarets -->
                                <rect x="55" y="135" width="18" height="60" fill="rgba(255,255,255,0.15)" rx="3" />
                                <ellipse cx="64" cy="135" rx="9" ry="7" fill="rgba(255,255,255,0.2)" />
                                <rect x="127" y="135" width="18" height="60" fill="rgba(255,255,255,0.15)" rx="3" />
                                <ellipse cx="136" cy="135" rx="9" ry="7" fill="rgba(255,255,255,0.2)" />
                                <!-- Silhouette city line -->
                                <rect x="0" y="195" width="55" height="45" fill="rgba(100,50,0,0.3)" rx="2" />
                                <rect x="145" y="190" width="55" height="50" fill="rgba(100,50,0,0.28)" rx="2" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Religious</span>
                            <span class="st-theme-count">60+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 8: Wildlife --}}
                    <div class="st-theme-card" data-theme="wildlife">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#fef3c7 0%,#b45309 50%,#78350f 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Savanna sky -->
                                <circle cx="155" cy="45" r="30" fill="rgba(255,200,50,0.28)" />
                                <circle cx="155" cy="45" r="18" fill="rgba(255,180,30,0.4)" />
                                <!-- Acacia tree -->
                                <rect x="96" y="110" width="8" height="70" fill="rgba(120,60,0,0.5)" rx="3" />
                                <ellipse cx="100" cy="105" rx="35" ry="18" fill="rgba(80,120,20,0.45)" />
                                <ellipse cx="76" cy="115" rx="22" ry="12" fill="rgba(60,100,10,0.4)" />
                                <ellipse cx="122" cy="112" rx="22" ry="12" fill="rgba(60,100,10,0.4)" />
                                <!-- Jeep silhouette -->
                                <rect x="130" y="175" width="52" height="24" fill="rgba(80,50,10,0.45)" rx="5" />
                                <rect x="136" y="163" width="34" height="16" fill="rgba(80,50,10,0.4)" rx="4" />
                                <circle cx="143" cy="200" r="8" fill="rgba(40,20,5,0.6)" />
                                <circle cx="173" cy="200" r="8" fill="rgba(40,20,5,0.6)" />
                                <!-- Deer silhouettes -->
                                <ellipse cx="45" cy="185" rx="14" ry="10" fill="rgba(120,60,0,0.5)" />
                                <rect x="38" y="190" width="4" height="18" fill="rgba(120,60,0,0.45)" rx="2" />
                                <rect x="48" y="192" width="4" height="16" fill="rgba(120,60,0,0.45)" rx="2" />
                                <circle cx="50" cy="177" r="7" fill="rgba(120,60,0,0.5)" />
                                <rect x="49" y="170" width="2" height="8" fill="rgba(120,60,0,0.5)" rx="1" />
                                <!-- Second deer -->
                                <ellipse cx="78" cy="192" rx="12" ry="9" fill="rgba(100,50,0,0.4)" />
                                <rect x="72" y="197" width="3.5" height="15" fill="rgba(100,50,0,0.38)" rx="2" />
                                <rect x="80" y="199" width="3.5" height="13" fill="rgba(100,50,0,0.38)" rx="2" />
                                <circle cx="84" cy="185" r="6" fill="rgba(100,50,0,0.4)" />
                                <!-- Birds in sky -->
                                <path d="M40 60 Q44 55 48 60" stroke="rgba(80,40,0,0.5)" stroke-width="1.5" fill="none"
                                    stroke-linecap="round" />
                                <path d="M55 50 Q59 45 63 50" stroke="rgba(80,40,0,0.45)" stroke-width="1.5" fill="none"
                                    stroke-linecap="round" />
                                <path d="M28 75 Q32 70 36 75" stroke="rgba(80,40,0,0.4)" stroke-width="1.5" fill="none"
                                    stroke-linecap="round" />
                                <!-- Ground -->
                                <rect x="0" y="208" width="200" height="32" fill="rgba(100,50,0,0.35)" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Wildlife</span>
                            <span class="st-theme-count">20+ destinations</span>
                        </div>
                    </div>

                    {{-- Card 9: Water Activities --}}
                    <div class="st-theme-card" data-theme="water">
                        <div class="st-theme-card-img"
                            style="background: linear-gradient(160deg,#67e8f9 0%,#0891b2 45%,#164e63 100%);">
                            <svg viewBox="0 0 200 240" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <!-- Palm trees left -->
                                <rect x="18" y="80" width="6" height="90" fill="rgba(0,80,40,0.4)" rx="3" />
                                <ellipse cx="18" cy="78" rx="22" ry="12" fill="rgba(0,120,50,0.4)"
                                    transform="rotate(-20 18 78)" />
                                <ellipse cx="22" cy="72" rx="22" ry="10" fill="rgba(0,120,50,0.35)"
                                    transform="rotate(15 22 72)" />
                                <!-- Palm right -->
                                <rect x="175" y="100" width="6" height="80" fill="rgba(0,80,40,0.35)" rx="3" />
                                <ellipse cx="176" cy="98" rx="20" ry="10" fill="rgba(0,120,50,0.38)"
                                    transform="rotate(20 176 98)" />
                                <!-- Water waves -->
                                <path
                                    d="M0 170 Q25 158 50 170 Q75 182 100 170 Q125 158 150 170 Q175 182 200 170 L200 240 L0 240Z"
                                    fill="rgba(0,150,200,0.4)" />
                                <path
                                    d="M0 185 Q30 175 60 185 Q90 195 120 185 Q150 175 180 185 Q190 190 200 185 L200 240 L0 240Z"
                                    fill="rgba(0,120,180,0.45)" />
                                <!-- Jet ski -->
                                <ellipse cx="110" cy="165" rx="42" ry="14" fill="rgba(255,200,0,0.7)" />
                                <path d="M75 160 Q110 148 145 160" fill="rgba(255,220,50,0.6)" />
                                <!-- Two riders -->
                                <circle cx="105" cy="148" r="11" fill="rgba(255,255,255,0.4)" />
                                <rect x="96" y="158" width="18" height="16" fill="rgba(255,100,0,0.55)" rx="5" />
                                <circle cx="125" cy="151" r="10" fill="rgba(255,255,255,0.38)" />
                                <rect x="116" y="160" width="18" height="14" fill="rgba(255,100,0,0.5)" rx="5" />
                                <!-- Life jackets (orange) -->
                                <rect x="97" y="159" width="18" height="14" fill="rgba(255,100,0,0.6)" rx="4" />
                                <rect x="117" y="161" width="18" height="12" fill="rgba(255,100,0,0.55)" rx="4" />
                                <!-- Spray -->
                                <path d="M148 162 Q158 155 165 162" stroke="rgba(255,255,255,0.55)" stroke-width="3"
                                    stroke-linecap="round" fill="none" />
                                <path d="M150 168 Q162 160 170 166" stroke="rgba(255,255,255,0.4)" stroke-width="2"
                                    stroke-linecap="round" fill="none" />
                            </svg>
                        </div>
                        <div class="st-theme-card-body">
                            <span class="st-theme-name">Water Activities</span>
                            <span class="st-theme-count">20+ destinations</span>
                        </div>
                    </div>

                    {{-- "View All" end card --}}
                    <div class="st-theme-card st-theme-viewall" id="themeViewAllCard">
                        <div class="st-theme-card-img st-theme-viewall-inner">
                            <div class="st-viewall-plus">
                                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                    <path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                            <p class="st-viewall-text">Explore 130+<br>destinations<br>worldwide</p>
                        </div>
                        <div class="st-theme-card-body">
                            <a href="#" class="st-viewall-btn">View All</a>
                        </div>
                    </div>

                </div>{{-- /st-themes-track --}}

                {{-- Right Arrow --}}
                <button class="st-themes-arrow st-themes-arrow-right" id="themesArrowRight" aria-label="Scroll right">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

            </div>{{-- /st-themes-slider-outer --}}
        </div>
    </section>


    {{--
============================================================
SECTION: Recommended Destinations Card Slider
FILE: resources/views/partials/recommended-destinations.blade.php
INCLUDE: @include('partials.recommended-destinations') in your page
CSS: paste recommended-destinations.css into your main stylesheet
============================================================
--}}
 
<section class="rd-section">
    <div class="rd-container rd-container--trending">
 
        {{-- ── Section Header ── --}}
        <div class="rd-header">
            <div class="rd-header-left">
                <p class="rd-eyebrow">Trending Now</p>
                <h2 class="rd-title">Trending Destinations</h2>
<p class="rd-subtitle">Fast-moving getaways that are topping the charts this week.</p>
            </div>
            <div class="rd-header-right">
                <div class="rd-nav-btns">
                    <button class="rd-nav-btn" id="rdPrev" aria-label="Previous">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="rd-nav-btn" id="rdNext" aria-label="Next">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <a href="{{ route('destinations.index') }}" class="rd-view-all-link">View all <span aria-hidden="true">→</span></a>
            </div>
        </div>
 
        {{-- ── Slider Track ── --}}
        <div class="rd-slider-outer">
            <div class="rd-track" id="rdTrack">
                @forelse ($destinations as $destination)
                    <article class="rd-card"
                        style="--rd-card-bg: url('{{ $destination->image_url }}');">
                        <div class="rd-card-img"></div>
                        <div class="rd-card-overlay"></div>
                        <div class="rd-card-badge {{ $destination->badge_class }}">{{ $destination->badge_label ?: '🔥 Trending' }}</div>
                        <button class="rd-wishlist" aria-label="Save {{ $destination->name }}" data-saved="false">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <div class="rd-card-body">
                            <div class="rd-card-rating">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="13" height="13"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                {{ number_format((float) $destination->rating, 1) }}
                            </div>
                            <div class="rd-card-info">
                                <div class="rd-card-location">
                                    <svg viewBox="0 0 24 24" fill="none" width="13" height="13"><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.6"/><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="currentColor" stroke-width="1.6"/></svg>
                                    {{ $destination->country }}
                                </div>
                                <h3 class="rd-card-name">{{ $destination->name }}</h3>
                                @if (!empty($destination->tags))
                                    <div class="rd-card-tags">
                                        @foreach (array_slice($destination->tags, 0, 3) as $tag)
                                            <span class="rd-tag">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="rd-card-footer">
                                    <div class="rd-price-block">
                                        <span class="rd-price-from">From</span>
                                        <span class="rd-price">{{ $destination->formatted_price }}</span>
                                        <span class="rd-price-per">{{ $destination->price_unit }}</span>
                                    </div>
                                    <a href="{{ route('destinations.show', $destination) }}" class="rd-card-btn">Explore <span>→</span></a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="rd-card" style="--rd-card-bg: linear-gradient(160deg,#64748b,#1e293b);">
                        <div class="rd-card-img"></div>
                        <div class="rd-card-overlay"></div>
                        <div class="rd-card-body">
                            <div class="rd-card-info">
                                <h3 class="rd-card-name">No destinations yet</h3>
                                <div class="rd-card-footer">
                                    <a href="{{ route('destinations.index') }}" class="rd-card-btn">View all <span>→</span></a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforelse
 
            </div>{{-- /rd-track --}}
        </div>{{-- /rd-slider-outer --}}
 
        {{-- ── Dots ── --}}
        <div class="rd-dots" id="rdDots" aria-hidden="true"></div>
 
    </div>{{-- /rd-container --}}
</section>

    {{-- ── Styles ── --}}
    <style>
        /* ═══════════════════════════════════════════════
                                   SECTION WRAPPER
                                ════════════════════════════════════════════════*/
        .st-themes-section {
            width: min(100% - 24px, 1320px);
            margin: 0 auto 48px;
            font-family: "Manrope", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ═══════════════════════════════════════════════
                                   HEADER ROW
                                ════════════════════════════════════════════════*/
        .st-themes-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .st-themes-title {
            margin: 0;
            font-size: clamp(1.25rem, 2.2vw, 1.65rem);
            font-weight: 800;
            color: #0f1115;
            letter-spacing: -.01em;
        }

        .st-themes-header-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .st-themes-phone-icon {
            width: 20px;
            height: 20px;
            color: #0f9d88;
            flex-shrink: 0;
        }

        .st-themes-phone-text {
            font-size: 13.5px;
            font-weight: 700;
            color: #444;
        }

        .st-themes-phone-number {
            font-size: 14.5px;
            font-weight: 900;
            color: #ff3b30;
            text-decoration: none;
            letter-spacing: .01em;
            transition: color .2s;
        }

        .st-themes-phone-number:hover {
            color: #0a7a68;
        }

        /* ═══════════════════════════════════════════════
                                   SLIDER OUTER  (the visible window + arrows)
                                ════════════════════════════════════════════════*/
        .st-themes-slider-outer {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0;
        }

        /* ═══════════════════════════════════════════════
                                   ARROW BUTTONS
                                ════════════════════════════════════════════════*/
        .st-themes-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-60%);
            /* slightly above center (label below image) */
            z-index: 10;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1.5px solid rgba(17, 17, 17, .12);
            background: #fff;
            box-shadow: 0 6px 20px rgba(17, 17, 17, .12);
            color: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s;
            flex-shrink: 0;
        }

        .st-themes-arrow:hover {
            border-color: rgba(255, 59, 48, .3);
            box-shadow: 0 10px 28px rgba(17, 17, 17, .16);
            transform: translateY(-60%) scale(1.06);
        }

        .st-themes-arrow svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .st-themes-arrow-left {
            left: -20px;
        }

        .st-themes-arrow-right {
            right: -20px;
        }

        /* ═══════════════════════════════════════════════
                                   TRACK  (the scrolling row of cards)
                                ════════════════════════════════════════════════*/
        .st-themes-track {
            display: flex;
            gap: 14px;
            overflow: hidden;
            /* JS controls visibility via transform */
            width: 100%;
            /* We use CSS transform on the inner to slide, not scroll */
        }

        /* Inner wrapper created by JS to hold all cards and translate */
        .st-themes-track-inner {
            display: flex;
            gap: 14px;
            transition: transform .42s cubic-bezier(.4, 0, .2, 1);
            will-change: transform;
        }

        /* ═══════════════════════════════════════════════
                                   INDIVIDUAL THEME CARD
                                ════════════════════════════════════════════════*/
        .st-theme-card {
            flex: 0 0 auto;
            width: 176px;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            transition: transform .25s ease;
        }

        .st-theme-card:hover {
            transform: translateY(-4px);
        }

        .st-theme-card-img {
            width: 100%;
            aspect-ratio: 3 / 4;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .st-theme-card-img svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        .st-theme-card-body {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            padding: 0 2px;
        }

        .st-theme-name {
            font-size: 14.5px;
            font-weight: 800;
            color: #0f1115;
            line-height: 1.25;
        }

        .st-theme-count {
            font-size: 12px;
            font-weight: 600;
            color: rgba(42, 42, 42, .55);
        }

        /* ═══════════════════════════════════════════════
                                   VIEW ALL CARD
                                ════════════════════════════════════════════════*/
        .st-theme-viewall .st-theme-card-img {
            background: #fff !important;
            border: 1.5px dashed rgba(17, 17, 17, .16);
            border-radius: 16px;
            flex-direction: column;
            gap: 12px;
        }

        .st-theme-viewall-inner {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px;
        }

        .st-viewall-plus {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1.5px solid rgba(17, 17, 17, .18);
            color: rgba(17, 17, 17, .35);
        }

        .st-viewall-plus svg {
            width: 26px;
            height: 26px;
        }

        .st-viewall-text {
            margin: 0;
            font-size: 13px;
            font-weight: 700;
            color: rgba(42, 42, 42, .55);
            text-align: center;
            line-height: 1.5;
        }

        .st-viewall-btn {
            display: inline-block;
            padding: 10px 26px;
            border-radius: 10px;
            background: var(--brand-primary, #ff3b30);
            color: #fff;
            font-size: 13.5px;
            font-weight: 800;
            text-decoration: none;
            text-align: center;
            letter-spacing: .02em;
            transition: filter .2s, transform .2s;
            box-shadow: 0 10px 24px rgba(255, 59, 48, .25);
        }

        .st-viewall-btn:hover {
            filter: brightness(1.08);
            transform: translateY(-2px);
            color: #fff;
        }

        /* ═══════════════════════════════════════════════
                                   RESPONSIVE
                                ════════════════════════════════════════════════*/
        @media (max-width: 767.98px) {
            .st-themes-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .st-theme-card {
                width: 148px;
            }

            .st-themes-arrow {
                width: 36px;
                height: 36px;
            }

            .st-themes-arrow-left {
                left: -16px;
            }

            .st-themes-arrow-right {
                right: -16px;
            }
        }

        @media (max-width: 479.98px) {
            .st-theme-card {
                width: 132px;
            }

            .st-themes-phone-text {
                display: none;
            }
        }
    </style>

    {{-- ── JavaScript ── --}}
    <script>
        (function () {
            /* ─── Config ──────────────────────────── */
            const CARD_WIDTH_REM_APPROX = 176; // matches CSS width in px (approx)
            const GAP = 14;                    // matches CSS gap in px
            const VISIBLE_COUNT_DEFAULT = 6;   // cards visible at once on large screens

            /* ─── DOM refs ───────────────────────── */
            const track = document.getElementById('themesTrack');
            const arrowLeft = document.getElementById('themesArrowLeft');
            const arrowRight = document.getElementById('themesArrowRight');
            const viewAllCard = document.getElementById('themeViewAllCard');

            if (!track || !arrowLeft || !arrowRight) return;

            /* ─── Wrap cards in a translatable inner div ─────── */
            const inner = document.createElement('div');
            inner.className = 'st-themes-track-inner';
            while (track.firstChild) inner.appendChild(track.firstChild);
            track.appendChild(inner);

            /* ─── State ──────────────────────────── */
            const allCards = Array.from(inner.children); // includes view-all card
            const totalCards = allCards.length;           // e.g. 10 (9 theme + 1 viewall)
            let currentIndex = 0;                         // leftmost visible card index

            /* ─── Helpers ────────────────────────── */
            function getCardStep() {
                // Actual rendered width of one card + gap
                const cardEl = allCards[0];
                if (!cardEl) return CARD_WIDTH_REM_APPROX + GAP;
                const style = window.getComputedStyle(cardEl);
                return cardEl.offsetWidth + parseInt(style.marginRight || 0) + GAP;
            }

            function getVisibleCount() {
                const trackW = track.offsetWidth;
                const step = getCardStep();
                return Math.max(1, Math.floor(trackW / step));
            }

            function maxIndex() {
                // The view-all card is at the last position; we stop when it is fully visible
                return Math.max(0, totalCards - getVisibleCount());
            }

            function applyTransform() {
                const step = getCardStep();
                inner.style.transform = `translateX(-${currentIndex * step}px)`;
            }

            function updateArrows() {
                const mi = maxIndex();
                // Left arrow: hidden when at start
                arrowLeft.style.display = currentIndex <= 0 ? 'none' : 'flex';
                // Right arrow: hidden when view-all card is fully visible (last position)
                arrowRight.style.display = currentIndex >= mi ? 'none' : 'flex';
            }

            function slideRight() {
                if (currentIndex < maxIndex()) {
                    currentIndex++;
                    applyTransform();
                    updateArrows();
                }
            }

            function slideLeft() {
                if (currentIndex > 0) {
                    currentIndex--;
                    applyTransform();
                    updateArrows();
                }
            }

            /* ─── Event listeners ────────────────── */
            arrowRight.addEventListener('click', slideRight);
            arrowLeft.addEventListener('click', slideLeft);

            // Keyboard support
            arrowRight.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); slideRight(); } });
            arrowLeft.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); slideLeft(); } });

            // Touch / swipe support
            let touchStartX = 0;
            inner.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].clientX; }, { passive: true });
            inner.addEventListener('touchend', e => {
                const delta = touchStartX - e.changedTouches[0].clientX;
                if (Math.abs(delta) > 40) { delta > 0 ? slideRight() : slideLeft(); }
            }, { passive: true });

            // Recalculate on resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    // Clamp index in case visible count changed
                    currentIndex = Math.min(currentIndex, maxIndex());
                    applyTransform();
                    updateArrows();
                }, 120);
            });

            /* ─── Init ───────────────────────────── */
            applyTransform();
            updateArrows();

        })();
    </script>

    {{--
    ============================================================
    SECTION: Seasonal Journeys
    FILE: resources/views/partials/seasonal-journeys.blade.php
    INCLUDE: @include('partials.seasonal-journeys') in your page
    CSS FILE: seasonal-journeys.css (add to your layout or assets)
    ============================================================
    --}}

    <section class="sj-section">
        <div class="container-fluid px-0">

            {{-- ── Section Header ── --}}
            <div class="sj-header">
                <h2 class="sj-title">Seasonal Journeys</h2>
                <p class="sj-subtitle">Best places to visit this season for unforgettable escapes!</p>
            </div>

            {{-- ── Bento Grid ── --}}
            <div class="sj-grid">

                {{-- ANDAMAN – wide left --}}
                <a href="#" class="sj-card sj-card--wide-left">
                    <img src="{{ asset('images/dubai.jpg') }}" alt="Andaman" class="sj-card__img" loading="lazy">
                    <div class="sj-card__overlay"></div>
                    <div class="sj-card__content">
                        <h3 class="sj-card__name">ANDAMAN</h3>
                        <p class="sj-card__price">Start From ₹ 14,999</p>
                    </div>
                </a>

                {{-- EUROPE – tall center (spans both rows) --}}
                <a href="#" class="sj-card sj-card--tall-center">
                    <img src="{{ asset('images/himachal.jpg') }}" alt="Europe" class="sj-card__img" loading="lazy">
                    <div class="sj-card__overlay"></div>
                    <div class="sj-card__content">
                        <h3 class="sj-card__name">EUROPE</h3>
                        <p class="sj-card__price">Start From ₹ 69,089</p>
                    </div>
                </a>

                {{-- MAURITIUS – wide right --}}
                <a href="#" class="sj-card sj-card--wide-right">
                    <img src="{{ asset('images/himachal.jpg') }}" alt="Mauritius" class="sj-card__img" loading="lazy">
                    <div class="sj-card__overlay"></div>
                    <div class="sj-card__content">
                        <h3 class="sj-card__name">MAURITIUS</h3>
                        <p class="sj-card__price">Start From ₹ 26,999</p>
                    </div>
                </a>

                {{-- HIMACHAL – bottom left --}}
                <a href="#" class="sj-card sj-card--bottom-sm">
                    <img src="{{ asset('images/himachal.jpg') }}" alt="Himachal Pradesh" class="sj-card__img"
                        loading="lazy">
                    <div class="sj-card__overlay"></div>
                    <div class="sj-card__content">
                        <h3 class="sj-card__name">HIMACHAL PRADESH</h3>
                        <p class="sj-card__price">Start From ₹ 9,999</p>
                    </div>
                </a>

                {{-- KERALA – bottom second --}}
                <a href="#" class="sj-card sj-card--bottom-sm">
                    <img src="{{ asset('images/kerala.avif') }}" alt="Kerala" class="sj-card__img" loading="lazy">
                    <div class="sj-card__overlay"></div>
                    <div class="sj-card__content">
                        <h3 class="sj-card__name">KERALA</h3>
                        <p class="sj-card__price">Start From ₹ 9,999</p>
                    </div>
                </a>

                {{-- MALAYSIA – bottom right --}}
                <a href="#" class="sj-card sj-card--bottom-right">
                    <img src="{{ asset('images/himachal.jpg') }}" alt="Malaysia" class="sj-card__img" loading="lazy">
                    <div class="sj-card__overlay"></div>
                    <div class="sj-card__content">
                        <h3 class="sj-card__name">MALAYSIA</h3>
                        <p class="sj-card__price">Start From ₹ 21,999</p>
                    </div>
                </a>

            </div>{{-- /sj-grid --}}

        </div>
    </section>




    {{--
    ============================================================
    SECTION: Popular Destinations Cards
    FILE: resources/views/partials/popular-destinations.blade.php
    INCLUDE: @include('partials.popular-destinations') in your page
    CSS: paste popular-destinations.css into your main stylesheet
    ============================================================
    --}}

    <section class="pd-section">
        <div class="pd-container">

            {{-- ── Section Header ── --}}
            <div class="pd-header">
                <div class="pd-header-left">
                    <p class="pd-eyebrow">Where To Next?</p>
                    <h2 class="pd-title">Popular Destinations</h2>
                </div>
                <div class="pd-header-right">
                    <span class="pd-count" id="pdCount">1 of 6</span>
                    <div class="pd-nav-btns">
                        <button class="pd-nav-btn" id="pdPrev" aria-label="Previous">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="pd-nav-btn" id="pdNext" aria-label="Next">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Cards Track ── --}}
            <div class="pd-track-outer">
                <div class="pd-track" id="pdTrack">

                    {{-- CARD 1: Dubai --}}
                    <article class="pd-card">
                        <div class="pd-card-img-wrap">
                            <img src="{{ asset('images/dubai.jpg') }}" alt="Dubai" class="pd-card-img" loading="lazy">
                            <div class="pd-card-img-overlay"></div>
                            <span class="pd-rating">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                4.7
                            </span>
                            <span class="pd-badge pd-badge--hot">Hot Deal</span>
                        </div>
                        <div class="pd-card-body">
                            <div class="pd-card-top">
                                <div>
                                    <h3 class="pd-card-name">Dubai</h3>
                                    <p class="pd-card-region">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.6" />
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                                stroke="currentColor" stroke-width="1.6" />
                                        </svg>
                                        UAE
                                    </p>
                                </div>
                                <div class="pd-card-price-wrap">
                                    <div class="pd-price-top">
                                        <span class="pd-price-original">INR 4,21,913</span>
                                        <span class="pd-price-save">SAVE INR 1,04,610</span>
                                    </div>
                                    <div class="pd-price-bottom">
                                        <span class="pd-price-final">INR 3,17,303</span>
                                        <span class="pd-price-per">/Adult</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pd-amenities">
                                <span class="pd-amenity">4 nights</span>
                                <span class="pd-amenity">Desert</span>
                                <span class="pd-amenity">Shopping</span>
                            </div>
                            <a href="#" class="pd-btn">View packages <span aria-hidden="true">→</span></a>
                        </div>
                    </article>

                    {{-- CARD 2: Switzerland --}}
                    <article class="pd-card">
                        <div class="pd-card-img-wrap">
                            <img src="{{ asset('images/switzerland.jpg') }}" alt="Switzerland" class="pd-card-img"
                                loading="lazy">
                            <div class="pd-card-img-overlay"></div>
                            <span class="pd-rating">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                4.9
                            </span>
                            <span class="pd-badge pd-badge--new">New</span>
                        </div>
                        <div class="pd-card-body">
                            <div class="pd-card-top">
                                <div>
                                    <h3 class="pd-card-name">Switzerland</h3>
                                    <p class="pd-card-region">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.6" />
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                                stroke="currentColor" stroke-width="1.6" />
                                        </svg>
                                        Europe
                                    </p>
                                </div>
                                <div class="pd-card-price-wrap">
                                    <div class="pd-price-top">
                                        <span class="pd-price-original">INR 4,21,913</span>
                                        <span class="pd-price-save">SAVE INR 1,04,610</span>
                                    </div>
                                    <div class="pd-price-bottom">
                                        <span class="pd-price-final">INR 3,17,303</span>
                                        <span class="pd-price-per">/Adult</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pd-amenities">
                                <span class="pd-amenity">8 nights</span>
                                <span class="pd-amenity">Mountains</span>
                                <span class="pd-amenity">Snow</span>
                            </div>
                            <a href="#" class="pd-btn">View packages <span aria-hidden="true">→</span></a>
                        </div>
                    </article>

                    {{-- CARD 3: Japan --}}
                    <article class="pd-card">
                        <div class="pd-card-img-wrap">
                            <img src="{{ asset('images/japan.jpg') }}" alt="Japan" class="pd-card-img" loading="lazy">
                            <div class="pd-card-img-overlay"></div>
                            <span class="pd-rating">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                4.8
                            </span>
                            <span class="pd-badge pd-badge--seasonal">Seasonal</span>
                        </div>
                        <div class="pd-card-body">
                            <div class="pd-card-top">
                                <div>
                                    <h3 class="pd-card-name">Japan</h3>
                                    <p class="pd-card-region">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.6" />
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                                stroke="currentColor" stroke-width="1.6" />
                                        </svg>
                                        East Asia
                                    </p>
                                </div>
                                <div class="pd-card-price-wrap">
                                    <div class="pd-price-top">
                                        <span class="pd-price-original">INR 4,21,913</span>
                                        <span class="pd-price-save">SAVE INR 1,04,610</span>
                                    </div>
                                    <div class="pd-price-bottom">
                                        <span class="pd-price-final">INR 3,17,303</span>
                                        <span class="pd-price-per">/Adult</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pd-amenities">
                                <span class="pd-amenity">10 nights</span>
                                <span class="pd-amenity">Culture</span>
                                <span class="pd-amenity">Cherry</span>
                            </div>
                            <a href="#" class="pd-btn">View packages <span aria-hidden="true">→</span></a>
                        </div>
                    </article>

                    {{-- CARD 4: Bali --}}
                    <article class="pd-card">
                        <div class="pd-card-img-wrap">
                            <img src="{{ asset('images/bali.jpg') }}" alt="Bali" class="pd-card-img" loading="lazy">
                            <div class="pd-card-img-overlay"></div>
                            <span class="pd-rating">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                4.6
                            </span>
                            <span class="pd-badge pd-badge--hot">Hot Deal</span>
                        </div>
                        <div class="pd-card-body">
                            <div class="pd-card-top">
                                <div>
                                    <h3 class="pd-card-name">Bali</h3>
                                    <p class="pd-card-region">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.6" />
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                                stroke="currentColor" stroke-width="1.6" />
                                        </svg>
                                        Indonesia
                                    </p>
                                </div>
                                <div class="pd-card-price-wrap">
                                    <div class="pd-price-top">
                                        <span class="pd-price-original">INR 4,21,913</span>
                                        <span class="pd-price-save">SAVE INR 1,04,610</span>
                                    </div>
                                    <div class="pd-price-bottom">
                                        <span class="pd-price-final">INR 3,17,303</span>
                                        <span class="pd-price-per">/Adult</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pd-amenities">
                                <span class="pd-amenity">6 nights</span>
                                <span class="pd-amenity">Beach</span>
                                <span class="pd-amenity">Temples</span>
                            </div>
                            <a href="#" class="pd-btn">View packages <span aria-hidden="true">→</span></a>
                        </div>
                    </article>

                    {{-- CARD 5: Maldives --}}
                    <article class="pd-card">
                        <div class="pd-card-img-wrap">
                            <img src="{{ asset('images/maldives.jpg') }}" alt="Maldives" class="pd-card-img" loading="lazy">
                            <div class="pd-card-img-overlay"></div>
                            <span class="pd-rating">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                5.0
                            </span>
                            <span class="pd-badge pd-badge--new">New</span>
                        </div>
                        <div class="pd-card-body">
                            <div class="pd-card-top">
                                <div>
                                    <h3 class="pd-card-name">Maldives</h3>
                                    <p class="pd-card-region">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.6" />
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                                stroke="currentColor" stroke-width="1.6" />
                                        </svg>
                                        South Asia
                                    </p>
                                </div>
                                <div class="pd-card-price-wrap">
                                    <div class="pd-price-top">
                                        <span class="pd-price-original">INR 4,21,913</span>
                                        <span class="pd-price-save">SAVE INR 1,04,610</span>
                                    </div>
                                    <div class="pd-price-bottom">
                                        <span class="pd-price-final">INR 3,17,303</span>
                                        <span class="pd-price-per">/Adult</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pd-amenities">
                                <span class="pd-amenity">5 nights</span>
                                <span class="pd-amenity">Luxury</span>
                                <span class="pd-amenity">Overwater</span>
                            </div>
                            <a href="#" class="pd-btn">View packages <span aria-hidden="true">→</span></a>
                        </div>
                    </article>

                    {{-- CARD 6: Thailand --}}
                    <article class="pd-card">
                        <div class="pd-card-img-wrap">
                            <img src="{{ asset('images/thailand.jpg') }}" alt="Thailand" class="pd-card-img" loading="lazy">
                            <div class="pd-card-img-overlay"></div>
                            <span class="pd-rating">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                4.5
                            </span>
                            <span class="pd-badge pd-badge--seasonal">Seasonal</span>
                        </div>
                        <div class="pd-card-body">
                            <div class="pd-card-top">
                                <div>
                                    <h3 class="pd-card-name">Thailand</h3>
                                    <p class="pd-card-region">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.6" />
                                            <path
                                                d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                                stroke="currentColor" stroke-width="1.6" />
                                        </svg>
                                        Southeast Asia
                                    </p>
                                </div>
                                <div class="pd-card-price-wrap">
                                    <div class="pd-price-top">
                                        <span class="pd-price-original">INR 4,21,913</span>
                                        <span class="pd-price-save">SAVE INR 1,04,610</span>
                                    </div>
                                    <div class="pd-price-bottom">
                                        <span class="pd-price-final">INR 3,17,303</span>
                                        <span class="pd-price-per">/Adult</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pd-amenities">
                                <span class="pd-amenity">7 nights</span>
                                <span class="pd-amenity">Islands</span>
                                <span class="pd-amenity">Street Food</span>
                            </div>
                            <a href="#" class="pd-btn">View packages <span aria-hidden="true">→</span></a>
                        </div>
                    </article>

                </div>{{-- /pd-track --}}
            </div>

            {{-- ── Dot Indicators ── --}}
            <div class="pd-dots" id="pdDots" aria-hidden="true"></div>

            {{-- ── View All ── --}}
            <div class="pd-footer">
                <a href="#" class="pd-view-all">View all destinations <span aria-hidden="true">→</span></a>
            </div>

        </div>
    </section>

    {{-- ── JS ── --}}
    <script>
        (function () {
            const track = document.getElementById('pdTrack');
            const prevBtn = document.getElementById('pdPrev');
            const nextBtn = document.getElementById('pdNext');
            const countEl = document.getElementById('pdCount');
            const dotsEl = document.getElementById('pdDots');

            if (!track) return;

            const cards = Array.from(track.children);
            const total = cards.length;
            let current = 0;

            /* ── How many cards visible? ── */
            function visibleCount() {
                const w = track.parentElement.offsetWidth;
                if (w >= 1024) return 3;
                if (w >= 640) return 2;
                return 1;
            }

            /* ── Card width including gap ── */
            function cardStep() {
                const card = cards[0];
                if (!card) return 0;
                const gap = parseInt(getComputedStyle(track).gap) || 24;
                return card.offsetWidth + gap;
            }

            function maxIndex() {
                return Math.max(0, total - visibleCount());
            }

            function goTo(idx) {
                current = Math.max(0, Math.min(idx, maxIndex()));
                track.style.transform = `translateX(-${current * cardStep()}px)`;
                countEl.textContent = `${current + 1} of ${total}`;
                prevBtn.disabled = current === 0;
                nextBtn.disabled = current >= maxIndex();
                updateDots();
            }

            /* ── Dots ── */
            function buildDots() {
                dotsEl.innerHTML = '';
                for (let i = 0; i <= maxIndex(); i++) {
                    const d = document.createElement('button');
                    d.className = 'pd-dot';
                    d.setAttribute('aria-label', `Go to slide ${i + 1}`);
                    d.addEventListener('click', () => goTo(i));
                    dotsEl.appendChild(d);
                }
            }

            function updateDots() {
                Array.from(dotsEl.children).forEach((d, i) => {
                    d.classList.toggle('pd-dot--active', i === current);
                });
            }

            /* ── Touch / swipe ── */
            let tx = 0;
            track.addEventListener('touchstart', e => { tx = e.changedTouches[0].clientX; }, { passive: true });
            track.addEventListener('touchend', e => {
                const delta = tx - e.changedTouches[0].clientX;
                if (Math.abs(delta) > 40) delta > 0 ? goTo(current + 1) : goTo(current - 1);
            }, { passive: true });

            prevBtn.addEventListener('click', () => goTo(current - 1));
            nextBtn.addEventListener('click', () => goTo(current + 1));

            /* ── Resize ── */
            let rt;
            window.addEventListener('resize', () => {
                clearTimeout(rt);
                rt = setTimeout(() => { buildDots(); goTo(Math.min(current, maxIndex())); }, 120);
            });

            buildDots();
            goTo(0);
        })();
    </script>





{{--
============================================================
SECTION: Destination Filtering & Discovery
FILE: resources/views/partials/destination-filter.blade.php
INCLUDE: @include('partials.destination-filter') in your page
CSS:  <link rel="stylesheet" href="{{ asset('assets/css/destination-filter.css') }}">
JS:   <script src="{{ asset('assets/js/destination-filter.js') }}" defer></script>
============================================================
--}}

{{-- ── Mobile Filter Trigger (sticky) ── --}}
<div class="df-mobile-filter-bar d-lg-none">
    <button class="df-mobile-filter-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#dfFilterOffcanvas" aria-controls="dfFilterOffcanvas">
        <i class="bi bi-sliders2"></i>
        <span>Filters</span>
        <span class="df-filter-badge" id="dfMobileFilterBadge" style="display:none;">0</span>
    </button>
    <div class="df-mobile-sort-wrap">
        <select class="df-mobile-sort-select" id="dfMobileSortSelect" aria-label="Sort by">
            <option value="popular">Most Popular</option>
            <option value="budget">Budget Friendly</option>
            <option value="luxury">Luxury</option>
            <option value="trending">Trending</option>
            <option value="duration">Duration</option>
        </select>
        <i class="bi bi-chevron-down df-mobile-sort-chevron"></i>
    </div>
</div>

{{-- ── Mobile Offcanvas Sidebar ── --}}
<div class="offcanvas offcanvas-start df-offcanvas" tabindex="-1" id="dfFilterOffcanvas" aria-labelledby="dfFilterOffcanvasLabel">
    <div class="offcanvas-header df-offcanvas-header">
        <div>
            <h5 class="offcanvas-title df-sidebar-title" id="dfFilterOffcanvasLabel">Find Your Perfect Journey</h5>
            <p class="df-sidebar-subtitle">Filter curated travel experiences.</p>
        </div>
        <button type="button" class="df-offcanvas-close" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <div class="offcanvas-body df-offcanvas-body">
        {{-- Mobile sidebar content inserted by JS --}}
        <div id="dfOffcanvasContent"></div>
    </div>
</div>

{{-- ── Main Section ── --}}
<section class="df-section" id="dfSection">
    <div class="df-wrapper">

        {{-- ════ LEFT SIDEBAR ════ --}}
        <aside class="df-sidebar d-none d-lg-flex" id="dfSidebar" aria-label="Filter destinations">

            <div class="df-sidebar-inner">
                {{-- Header --}}
                <div class="df-sidebar-head">
                    <div class="df-sidebar-head-icon">
                        <i class="bi bi-compass"></i>
                    </div>
                    <div>
                        <h2 class="df-sidebar-title">Find Your Perfect Journey</h2>
                        <p class="df-sidebar-subtitle">Filter curated travel experiences based on your travel style.</p>
                    </div>
                </div>

                {{-- ── 1. Destination Dropdown ── --}}
                <div class="df-filter-group" id="dfDesktopDestGroup">
                    <label class="df-filter-label" for="dfDestination">
                        <i class="bi bi-geo-alt"></i> Destination
                    </label>
                    <div class="df-select-wrap">
                        <select class="df-select" id="dfDestination" aria-label="Select destination">
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

                {{-- ── 2. Budget Filter (Dynamic) ── --}}
                <div class="df-filter-group" id="dfDesktopBudgetGroup">
                    <label class="df-filter-label">
                        <i class="bi bi-currency-rupee"></i> Budget
                    </label>
                    <div class="df-budget-options" id="dfBudgetOptions" role="radiogroup" aria-label="Budget range">
                        {{-- Populated by JS --}}
                    </div>
                </div>

                {{-- ── 3. Duration ── --}}
                <div class="df-filter-group">
                    <label class="df-filter-label">
                        <i class="bi bi-clock"></i> Duration
                    </label>
                    <div class="df-chip-group" id="dfDurationGroup" role="group" aria-label="Duration">
                        <button class="df-chip" data-filter="duration" data-value="weekend">Weekend</button>
                        <button class="df-chip" data-filter="duration" data-value="3-5">3–5 Days</button>
                        <button class="df-chip" data-filter="duration" data-value="5-7">5–7 Days</button>
                        <button class="df-chip" data-filter="duration" data-value="7+">7+ Days</button>
                    </div>
                </div>

                {{-- ── 4. Travel Style ── --}}
                <div class="df-filter-group">
                    <label class="df-filter-label">
                        <i class="bi bi-heart"></i> Travel Style
                    </label>
                    <div class="df-chip-group df-chip-group--wrap" id="dfStyleGroup" role="group" aria-label="Travel style">
                        <button class="df-chip" data-filter="style" data-value="honeymoon">💑 Honeymoon</button>
                        <button class="df-chip" data-filter="style" data-value="adventure">🧗 Adventure</button>
                        <button class="df-chip" data-filter="style" data-value="family">👨‍👩‍👧 Family</button>
                        <button class="df-chip" data-filter="style" data-value="solo">🎒 Solo</button>
                        <button class="df-chip" data-filter="style" data-value="friends">🎉 Friends</button>
                        <button class="df-chip" data-filter="style" data-value="luxury">✨ Luxury</button>
                    </div>
                </div>

                {{-- ── 5. Domestic / International ── --}}
                <div class="df-filter-group">
                    <label class="df-filter-label">
                        <i class="bi bi-globe2"></i> Trip Type
                    </label>
                    <div class="df-toggle-pill" id="dfTripToggle" role="radiogroup" aria-label="Trip type">
                        <button class="df-toggle-btn df-toggle-btn--active" data-value="all" aria-pressed="true">All</button>
                        <button class="df-toggle-btn" data-value="domestic" aria-pressed="false">Domestic</button>
                        <button class="df-toggle-btn" data-value="international" aria-pressed="false">International</button>
                    </div>
                </div>

                {{-- ── 6. Season ── --}}
                <div class="df-filter-group">
                    <label class="df-filter-label">
                        <i class="bi bi-sun"></i> Season
                    </label>
                    <div class="df-chip-group df-chip-group--wrap" id="dfSeasonGroup" role="group" aria-label="Season">
                        <button class="df-chip" data-filter="season" data-value="summer">☀️ Summer</button>
                        <button class="df-chip" data-filter="season" data-value="winter">❄️ Winter</button>
                        <button class="df-chip" data-filter="season" data-value="monsoon">🌧️ Monsoon</button>
                        <button class="df-chip" data-filter="season" data-value="december">🎄 December</button>
                    </div>
                </div>

                {{-- ── 7. Ratings ── --}}
                <div class="df-filter-group">
                    <label class="df-filter-label">
                        <i class="bi bi-star"></i> Minimum Rating
                    </label>
                    <div class="df-chip-group" id="dfRatingGroup" role="radiogroup" aria-label="Minimum rating">
                        <button class="df-chip" data-filter="rating" data-value="4">4★ & above</button>
                        <button class="df-chip" data-filter="rating" data-value="4.5">4.5★ & above</button>
                    </div>
                </div>

                {{-- ── 8. Sort By ── --}}
                <div class="df-filter-group">
                    <label class="df-filter-label" for="dfSort">
                        <i class="bi bi-sort-down"></i> Sort By
                    </label>
                    <div class="df-select-wrap">
                        <select class="df-select" id="dfSort" aria-label="Sort results">
                            <option value="popular">Most Popular</option>
                            <option value="budget">Budget Friendly</option>
                            <option value="luxury">Luxury</option>
                            <option value="trending">Trending</option>
                            <option value="duration">Duration</option>
                        </select>
                        <i class="bi bi-chevron-down df-select-chevron"></i>
                    </div>
                </div>

                {{-- ── Actions ── --}}
                <div class="df-sidebar-actions">
                    <button class="df-btn-clear" id="dfClearFilters" type="button" aria-label="Clear all filters">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </button>
                    <button class="df-btn-search" id="dfExploreBtn" type="button">
                        <i class="bi bi-search"></i> Explore Packages
                    </button>
                </div>

            </div>{{-- /df-sidebar-inner --}}
        </aside>

        {{-- ════ RIGHT CONTENT ════ --}}
        <div class="df-results" id="dfResults">

            {{-- Results Top Bar --}}
            <div class="df-results-topbar">
                <div class="df-results-meta">
                    <h2 class="df-results-title">Discover Your Next Journey</h2>
                    <p class="df-results-subtitle">Handpicked journeys curated based on your travel preferences.</p>
                </div>
                <div class="df-results-controls">
                    <span class="df-results-count" id="dfResultsCount">8 packages found</span>
                    <div class="df-active-filters" id="dfActiveFilters" aria-live="polite"></div>
                    <div class="df-view-toggle d-none d-md-flex" role="group" aria-label="View mode">
                        <button class="df-view-btn df-view-btn--active" id="dfViewGrid" aria-label="Grid view" title="Grid view">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button class="df-view-btn" id="dfViewList" aria-label="List view" title="List view">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Carousel Wrapper --}}
            <div class="df-carousel-wrapper">
                {{-- Cards Carousel --}}
                <div class="df-carousel-outer" id="dfCarouselOuter">
                {{-- Left Arrow (hidden on first load) --}}
                <button class="df-carousel-arrow df-carousel-arrow-left" id="dfCarouselArrowLeft" aria-label="Scroll left"
                    style="display:none;">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                {{-- Cards Track --}}
                <div class="df-cards-grid" id="dfCardsGrid" aria-live="polite" aria-label="Destination results">

                {{-- CARD: Bali --}}
                <article class="df-card"
                    data-destination="bali"
                    data-type="international"
                    data-style="honeymoon,adventure,friends"
                    data-season="summer,monsoon"
                    data-duration="5-7"
                    data-rating="4.7"
                    data-price="50000"
                    data-tag="trending">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80" alt="Bali, Indonesia" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--trending">Trending</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Bali to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.7
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Bali</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> Indonesia</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹50,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> 5–7 Days</span>
                            <span><i class="bi bi-water"></i> Beach & Temples</span>
                            <span><i class="bi bi-camera"></i> Rice Terraces</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Honeymoon</span>
                            <span class="df-tag">Adventure</span>
                            <span class="df-tag">Friends</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

                {{-- CARD: Goa --}}
                <article class="df-card"
                    data-destination="goa"
                    data-type="domestic"
                    data-style="friends,adventure,solo"
                    data-season="winter,december"
                    data-duration="weekend"
                    data-rating="4.3"
                    data-price="10000"
                    data-tag="bestseller">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800&q=80" alt="Goa, India" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--bestseller">Bestseller</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Goa to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.3
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Goa</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> India</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹10,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> Weekend Trip</span>
                            <span><i class="bi bi-water"></i> Beaches</span>
                            <span><i class="bi bi-music-note"></i> Nightlife</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Friends</span>
                            <span class="df-tag">Adventure</span>
                            <span class="df-tag">Solo</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

                {{-- CARD: Dubai --}}
                <article class="df-card"
                    data-destination="dubai"
                    data-type="international"
                    data-style="luxury,family,honeymoon"
                    data-season="winter,december"
                    data-duration="3-5"
                    data-rating="4.8"
                    data-price="120000"
                    data-tag="luxury">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800&q=80" alt="Dubai, UAE" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--luxury">Luxury</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Dubai to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.8
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Dubai</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> UAE</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹1,20,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> 3–5 Days</span>
                            <span><i class="bi bi-buildings"></i> Skyline</span>
                            <span><i class="bi bi-sun"></i> Desert Safari</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Luxury</span>
                            <span class="df-tag">Family</span>
                            <span class="df-tag">Honeymoon</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

                {{-- CARD: Maldives --}}
                <article class="df-card"
                    data-destination="maldives"
                    data-type="international"
                    data-style="honeymoon,luxury"
                    data-season="summer,winter"
                    data-duration="5-7"
                    data-rating="4.9"
                    data-price="150000"
                    data-tag="luxury">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=800&q=80" alt="Maldives" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--luxury">Luxury</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Maldives to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.9
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Maldives</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> South Asia</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹1,50,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> 5–7 Days</span>
                            <span><i class="bi bi-houses"></i> Overwater Villa</span>
                            <span><i class="bi bi-water"></i> Coral Reefs</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Honeymoon</span>
                            <span class="df-tag">Luxury</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

                {{-- CARD: Kashmir --}}
                <article class="df-card"
                    data-destination="kashmir"
                    data-type="domestic"
                    data-style="honeymoon,family,adventure"
                    data-season="summer,winter"
                    data-duration="5-7"
                    data-rating="4.6"
                    data-price="35000"
                    data-tag="trending">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1548013146-72479768bada?w=800&q=80" alt="Kashmir, India" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--trending">Trending</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Kashmir to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.6
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Kashmir</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> India</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹35,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> 5–7 Days</span>
                            <span><i class="bi bi-snow"></i> Snow Peaks</span>
                            <span><i class="bi bi-water"></i> Dal Lake</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Honeymoon</span>
                            <span class="df-tag">Family</span>
                            <span class="df-tag">Adventure</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

                {{-- CARD: Thailand --}}
                <article class="df-card"
                    data-destination="thailand"
                    data-type="international"
                    data-style="friends,adventure,solo"
                    data-season="summer,winter"
                    data-duration="7+"
                    data-rating="4.5"
                    data-price="60000"
                    data-tag="bestseller">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1506665531195-3566af2b4dfa?w=800&q=80" alt="Thailand" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--bestseller">Bestseller</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Thailand to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.5
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Thailand</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> Southeast Asia</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹60,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> 7+ Days</span>
                            <span><i class="bi bi-tropical-storm"></i> Islands</span>
                            <span><i class="bi bi-cup-hot"></i> Street Food</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Friends</span>
                            <span class="df-tag">Adventure</span>
                            <span class="df-tag">Solo</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

                {{-- CARD: Switzerland --}}
                <article class="df-card"
                    data-destination="switzerland"
                    data-type="international"
                    data-style="honeymoon,family,luxury"
                    data-season="winter,summer"
                    data-duration="7+"
                    data-rating="4.9"
                    data-price="200000"
                    data-tag="luxury">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80" alt="Switzerland" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--luxury">Luxury</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Switzerland to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.9
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Switzerland</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> Europe</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹2,00,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> 7+ Days</span>
                            <span><i class="bi bi-snow2"></i> Alps</span>
                            <span><i class="bi bi-train-front"></i> Scenic Rail</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Honeymoon</span>
                            <span class="df-tag">Luxury</span>
                            <span class="df-tag">Family</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

                {{-- CARD: Kerala --}}
                <article class="df-card"
                    data-destination="kerala"
                    data-type="domestic"
                    data-style="honeymoon,family,solo"
                    data-season="monsoon,winter"
                    data-duration="5-7"
                    data-rating="4.6"
                    data-price="25000"
                    data-tag="bestseller">
                    <div class="df-card-img-wrap">
                        <img src="https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800&q=80" alt="Kerala, India" class="df-card-img" loading="lazy">
                        <div class="df-card-overlay"></div>
                        <div class="df-card-badges">
                            <span class="df-badge df-badge--bestseller">Bestseller</span>
                        </div>
                        <button class="df-wishlist-btn" aria-label="Add Kerala to wishlist" data-wishlisted="false">
                            <i class="bi bi-heart"></i>
                        </button>
                        <div class="df-card-rating">
                            <i class="bi bi-star-fill"></i> 4.6
                        </div>
                    </div>
                    <div class="df-card-body">
                        <div class="df-card-header">
                            <div>
                                <h3 class="df-card-name">Kerala</h3>
                                <p class="df-card-location"><i class="bi bi-geo-alt-fill"></i> India</p>
                            </div>
                            <div class="df-card-price-block">
                                <span class="df-price-from">From</span>
                                <span class="df-price">₹25,000</span>
                            </div>
                        </div>
                        <div class="df-card-highlights">
                            <span><i class="bi bi-clock"></i> 5–7 Days</span>
                            <span><i class="bi bi-water"></i> Backwaters</span>
                            <span><i class="bi bi-tree"></i> Spice Gardens</span>
                        </div>
                        <div class="df-card-tags">
                            <span class="df-tag">Honeymoon</span>
                            <span class="df-tag">Family</span>
                            <span class="df-tag">Solo</span>
                        </div>
                        <a href="#" class="df-card-btn">View Details <i class="bi bi-arrow-right"></i></a>
                    </div>
                </article>

            </div>{{-- /df-cards-grid --}}

            {{-- Right Arrow --}}
            <button class="df-carousel-arrow df-carousel-arrow-right" id="dfCarouselArrowRight" aria-label="Scroll right">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            </div>{{-- /df-carousel-outer --}}

            </div>{{-- /df-carousel-wrapper --}}

            {{-- No Results State --}}
            <div class="df-no-results" id="dfNoResults" style="display:none;" aria-live="assertive">
                <div class="df-no-results-inner">
                    <div class="df-no-results-icon"><i class="bi bi-search-heart"></i></div>
                    <h3>No packages found</h3>
                    <p>Try adjusting your filters or clearing them to discover more destinations.</p>
                    <button class="df-btn-search" id="dfClearFiltersAlt" type="button">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset Filters
                    </button>
                </div>
            </div>
            

        </div>{{-- /df-results --}}
    </div>{{-- /df-wrapper --}}
    <div class="df-footer">
                <a href="#" class="df-view-all">View all destinations <span aria-hidden="true">→</span></a>
            </div>
    </section>



    {{-- ============================================================
SECTION: Honeymoon Romantic Luxury Banner
Add your image: style="--hb-bg: url('{{ asset('images/your-honeymoon-bg.jpg') }}')"
============================================================ --}}

<section class="hb-section" style="--hb-bg: url('{{ asset('images/himachal.jpg') }}');">

    {{-- 3D floating card / content layer --}}
    <div class="hb-inner">

        {{-- Decorative floating orbs --}}
        <div class="hb-orb hb-orb--1" aria-hidden="true"></div>
        <div class="hb-orb hb-orb--2" aria-hidden="true"></div>
        <div class="hb-orb hb-orb--3" aria-hidden="true"></div>

        {{-- Floating hearts --}}
        <div class="hb-hearts" aria-hidden="true">
            <span class="hb-heart hb-heart--1">♥</span>
            <span class="hb-heart hb-heart--2">♥</span>
            <span class="hb-heart hb-heart--3">♥</span>
            <span class="hb-heart hb-heart--4">♥</span>
            <span class="hb-heart hb-heart--5">♥</span>
            <span class="hb-heart hb-heart--6">♥</span>
            <span class="hb-heart hb-heart--7">♥</span>
            <span class="hb-heart hb-heart--8">♥</span>
            <span class="hb-heart hb-heart--9">♥</span>
            <span class="hb-heart hb-heart--10">♥</span>
            <span class="hb-heart hb-heart--11">♥</span>
            <span class="hb-heart hb-heart--12">♥</span>
            <span class="hb-heart hb-heart--13">♥</span>
            <span class="hb-heart hb-heart--14">♥</span>
            <span class="hb-heart hb-heart--15">♥</span>
            <span class="hb-heart hb-heart--16">♥</span>


        </div>

        {{-- 3D Content Card --}}
        <div class="hb-card">

            <div class="hb-card-glow" aria-hidden="true"></div>

            <div class="hb-card-body">

                {{-- Pill --}}
                <div class="hb-pill">
                    <span class="hb-pill-dot"></span>
                    Exclusive Honeymoon Packages
                </div>

                {{-- Headline --}}
                <h2 class="hb-title">
                    Where Every Moment<br>
                    Becomes <em>Forever</em>
                </h2>

                {{-- Sub text --}}
                <p class="hb-text">
                    Drift away on curated romantic escapes — overwater villas, candlelit sunsets,
                    and memories crafted just for two.
                </p>

                {{-- Stats row --}}
                <div class="hb-stats">
                    <div class="hb-stat">
                        <span class="hb-stat-num">60+</span>
                        <span class="hb-stat-label">Destinations</span>
                    </div>
                    <div class="hb-stat-divider" aria-hidden="true"></div>
                    <div class="hb-stat">
                        <span class="hb-stat-num">5,000+</span>
                        <span class="hb-stat-label">Couples</span>
                    </div>
                    <div class="hb-stat-divider" aria-hidden="true"></div>
                    <div class="hb-stat">
                        <span class="hb-stat-num">4.9 ★</span>
                        <span class="hb-stat-label">Rating</span>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="hb-actions">
                    <a href="#" class="hb-btn hb-btn--primary">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 21C12 21 4 13.5 4 8.5a8 8 0 0 1 16 0C20 13.5 12 21 12 21z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="8.5" r="2.5" stroke="currentColor" stroke-width="1.8"/></svg>
                        Explore Packages
                    </a>
                    <a href="#" class="hb-btn hb-btn--ghost">
                        Customize My Trip
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

            </div>{{-- /hb-card-body --}}

            {{-- Right decorative visual panel --}}
            <div class="hb-card-visual" aria-hidden="true">
                <div class="hb-visual-ring hb-visual-ring--1"></div>
                <div class="hb-visual-ring hb-visual-ring--2"></div>
                <div class="hb-visual-ring hb-visual-ring--3"></div>

                <div class="hb-visual-badge hb-visual-badge--top">
                    <span class="hb-badge-icon">🌙</span>
                    <div>
                        <p class="hb-badge-title">Honeymoon Suite</p>
                        <p class="hb-badge-sub">Maldives Overwater Villa</p>
                    </div>
                </div>

                <div class="hb-visual-center">
                    <div class="hb-heart-3d">♥</div>
                </div>

                <div class="hb-visual-badge hb-visual-badge--bottom">
                    <span class="hb-badge-icon">✈️</span>
                    <div>
                        <p class="hb-badge-title">Starting ₹49,999</p>
                        <p class="hb-badge-sub">Flights + Stay Included</p>
                    </div>
                </div>
            </div>

        </div>{{-- /hb-card --}}

    </div>{{-- /hb-inner --}}
</section>

{{--
============================================================
SECTION: Travel Blog / Insights
FILE: resources/views/partials/blog-section.blade.php
INCLUDE: @include('partials.blog-section') in your page
CSS: <link rel="stylesheet" href="{{ asset('assets/css/blog-section.css') }}">
============================================================
--}}
 



    {{-- Pilgrimage Tours Section --}}
    @include('partials.pilgrimage-section')

    {{-- Dynamic Blog Section --}}
    @include('partials.home-blog-section')

    {{-- Premium Testimonials & Reviews --}}
    @include('partials.testimonials-section')

@endsection
