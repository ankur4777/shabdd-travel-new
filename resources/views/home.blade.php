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

@endsection
