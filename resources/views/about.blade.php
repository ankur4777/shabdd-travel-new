@extends('layouts.app')

@section('meta')
    <title>About SHABDD Travel</title>
    <meta name="description"
        content="Learn about SHABDD Travel and our approach to creating curated holiday experiences.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush


@section('content')
    <main class="about-page">
        <section class="about-hero">
            <img class="about-hero-img" src="{{ asset('about-image/about-banner.png') }}" alt="Mountain valley traveller">
            <div class="about-hero-shade"></div>
            <div class="about-hero-content">
                <p class="about-script">About Us</p>
                <h1>We don't just plan trips,<br><span>we craft memories.</span></h1>
                <p class="about-hero-text">
                    At Shabdd Travels, we believe every journey has the power to transform. We're here to turn your
                    travel dreams into unforgettable experiences.
                </p>
                <div class="about-trust">
                    <div class="about-avatar-stack">
                        <img src="{{ asset('storage_backup_20260730121753/review-profiles/01KWE6QEMJQPE08WN3W5GZ9JM8.jpeg') }}"
                            alt="">
                        <img src="{{ asset('storage_backup_20260730121753/review-profiles/01KWE8R3NGPVKEY218XFH0XB9B.png') }}"
                            alt="">
                        <img src="{{ asset('storage_backup_20260730121753/review-profiles/01KWE96FYXW3WDSDS2DKB1JM7V.png') }}"
                            alt="">
                        <img src="{{ asset('storage_backup_20260730121753/review-profiles/01KWEEYA0GJ6NQ4CKCB47Y4XH5.png') }}"
                            alt="">
                    </div>
                    <p><strong>Trusted by 5,000+</strong><span>Happy Travelers</span></p>
                </div>
            </div>
        </section>

        <section class="about-section about-story">
            <div class="about-copy">
                <p class="about-kicker">Our Story</p>
                <h2>The journey that started with a dream.</h2>
                <p>
                    Founded with a passion for exploration and a promise of exceptional service, Shabdd Travels has grown
                    into a trusted travel partner for thousands of adventurers around the world.
                </p>
                <ul class="about-check-list">
                    <li><i class="bi bi-check-circle"></i> Handpicked destinations & experiences</li>
                    <li><i class="bi bi-check-circle"></i> Best price guarantee</li>
                    <li><i class="bi bi-check-circle"></i> 24/7 customer support</li>
                    <li><i class="bi bi-check-circle"></i> Safe & comfortable travel</li>
                </ul>
               
            </div>

            <div class="about-gallery" aria-label="Travel memories">
                <img class="about-gallery-main" src="{{ asset('images/kerala.avif') }}" alt="Boat on emerald water">
                <img src="{{ asset('images/dubai.jpg') }}" alt="Desert balloon landscape">
                <img src="{{ asset('images/himachal.jpg') }}" alt="Mountain trail traveller">
                <div class="about-years">
                    <i class="bi bi-award"></i>
                    <p><strong>8+ Years</strong><span>Of Creating Memorable Journeys</span></p>
                </div>
            </div>
        </section>

        <section class="about-stats" aria-label="Company highlights">
            <div class="about-stat"><i class="bi bi-people"></i><strong data-count="5000" data-suffix="+">0+</strong><span>Happy Travelers</span></div>
            <div class="about-stat"><i class="bi bi-globe2"></i><strong data-count="150" data-suffix="+">0+</strong><span>Destinations</span></div>
            <div class="about-stat"><i class="bi bi-suitcase"></i><strong data-count="500" data-suffix="+">0+</strong><span>Curated Packages</span></div>
            <div class="about-stat"><i class="bi bi-headset"></i><strong data-count="24" data-suffix="/7">0/7</strong><span>Customer Support</span></div>
        </section>

        <section class="about-section about-why">
            <div class="about-copy">
                <p class="about-kicker">Why Travel With Us</p>
                <h2>Designed around you,<br>built for perfection.</h2>
            </div>

            <div class="about-feature-grid">
                <article class="about-feature-card">
                    <i class="bi bi-map"></i>
                    <h3>Expert Local Knowledge</h3>
                    <p>Local experts who know the best experiences and hidden gems.</p>
                </article>
                <article class="about-feature-card">
                    <i class="bi bi-patch-check"></i>
                    <h3>Best Price Guarantees</h3>
                    <p>Get the best value without compromising quality.</p>
                </article>
                <article class="about-feature-card">
                    <i class="bi bi-airplane"></i>
                    <h3>Hassle-Free Travel</h3>
                    <p>From planning to return, we take care of every detail.</p>
                </article>
                <article class="about-feature-card">
                    <i class="bi bi-lock"></i>
                    <h3>Safe & Trusted</h3>
                    <p>Your safety is our priority. Travel with peace of mind.</p>
                </article>
            </div>
        </section>

        <section class="about-section about-team">
            <div class="about-section-head">
                <div class="about-copy">
                    <p class="about-kicker">Our Team</p>
                    <h2>The passionate people behind your journeys.</h2>
                </div>
                <a href="/contact">View All Team <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="about-team-grid">
                @foreach([
                    ['name' => 'Vikas Sharma', 'role' => 'Founder & CEO', 'img' => '01KWE8R3NGPVKEY218XFH0XB9B.png'],
                    ['name' => 'Anjali Mehta', 'role' => 'Travel Expert', 'img' => '01KWEEYA0GJ6NQ4CKCB47Y4XH5.png'],
                    ['name' => 'Rohit Verma', 'role' => 'Operations Head', 'img' => '01KWE6QEMJQPE08WN3W5GZ9JM8.jpeg'],
                    ['name' => 'Priya Nair', 'role' => 'Customer Relations', 'img' => '01KWEGQWKBQCQ49VPKTCHDEMAM.png'],
                ] as $member)
                    <article class="about-team-card">
                        <img src="{{ asset('storage_backup_20260730121753/review-profiles/' . $member['img']) }}"
                            alt="{{ $member['name'] }}">
                        <div>
                            <h3>{{ $member['name'] }}</h3>
                            <p>{{ $member['role'] }}</p>
                            <span><i class="bi bi-linkedin"></i><i class="bi bi-facebook"></i><i class="bi bi-instagram"></i></span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="about-section about-stories">
            <div class="about-copy">
                <p class="about-kicker">Traveler Stories</p>
                <h2>Real stories from<br>happy travelers.</h2>
            </div>

            <div class="about-testimonials">
                <article>
                    <i class="bi bi-quote"></i>
                    <p>Our trip to Bali was beyond amazing! Shabdd Travels planned everything perfectly.</p>
                    <div class="about-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <strong>Neha Kapoor</strong>
                    <span>Bali Trip</span>
                </article>
                <article>
                    <i class="bi bi-quote"></i>
                    <p>Amazing experience with Shabdd Travels. The itinerary was just perfect.</p>
                    <div class="about-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <strong>Arjun Mehta</strong>
                    <span>Kerala Trip</span>
                </article>
            </div>
        </section>

        <section class="about-cta">
            <img src="{{ asset('about-image/about-banner.png') }}" alt="">
            <div>
                <span>Ready to start your next adventure?</span>
                <h2>Let's plan your perfect trip!!</h2>
            </div>
            <a class="about-btn" href="/contact">Plan My Trip <i class="bi bi-arrow-right"></i></a>
        </section>

    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const counters = document.querySelectorAll('.about-stats strong[data-count]');
            const duration = 1800;

            const formatNumber = function (value) {
                return Math.floor(value).toLocaleString('en-IN');
            };

            const runCounters = function () {
                const startTime = performance.now();

                const tick = function (now) {
                    const progress = Math.min((now - startTime) / duration, 1);
                    const easedProgress = 1 - Math.pow(1 - progress, 3);

                    counters.forEach(function (counter) {
                        const target = Number(counter.dataset.count);
                        const suffix = counter.dataset.suffix || '';
                        counter.textContent = formatNumber(target * easedProgress) + suffix;
                    });

                    if (progress < 1) {
                        requestAnimationFrame(tick);
                    }
                };

                requestAnimationFrame(tick);
            };

            runCounters();
        });
    </script>
@endpush
