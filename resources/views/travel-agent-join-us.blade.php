@extends('layouts.app')

@section('meta')
    <title>Join as a Travel Agent | SHABDD Travel</title>
    <meta name="description"
        content="Partner with SHABDD Travel as a travel agent. Earn attractive commissions, access exclusive tour packages, and grow your travel business.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/travel-agent-join-us.css') }}">
@endpush

@php
    $benefits = [
        ['icon' => 'bi-cash-coin', 'title' => 'Attractive Commission Structure', 'text' => 'Earn competitive commissions on curated domestic and international holiday packages.'],
        ['icon' => 'bi-gem', 'title' => 'Exclusive Tour Packages', 'text' => 'Access handpicked packages designed for families, couples, groups, and premium travelers.'],
        ['icon' => 'bi-headset', 'title' => 'Dedicated Support Team', 'text' => 'Get quick assistance for quotes, itinerary changes, booking coordination, and travel queries.'],
        ['icon' => 'bi-calendar2-check', 'title' => 'Easy Booking Management', 'text' => 'Handle client requests faster with organized package details and support-led workflows.'],
        ['icon' => 'bi-megaphone', 'title' => 'Marketing Assistance', 'text' => 'Use destination insights, package positioning, and campaign support to sell with confidence.'],
        ['icon' => 'bi-diagram-3', 'title' => 'Nationwide Network', 'text' => 'Grow with a travel partner serving popular destinations across India and beyond.'],
    ];

    $steps = [
        ['title' => 'Submit Application', 'text' => 'Share your agency details, city, experience, and preferred travel categories.'],
        ['title' => 'Verification & Approval', 'text' => 'Our team reviews your application and validates the right partnership fit.'],
        ['title' => 'Agent Dashboard Access', 'text' => 'Receive partner access, package support, and selling resources after approval.'],
        ['title' => 'Start Earning', 'text' => 'Book trips for your clients and earn commissions on confirmed packages.'],
    ];

    $stats = [
        ['count' => 500, 'suffix' => '+', 'label' => 'Travel Agents'],
        ['count' => 1000, 'suffix' => '+', 'label' => 'Tour Packages'],
        ['count' => 50, 'suffix' => '+', 'label' => 'Destinations'],
        ['count' => 10000, 'suffix' => '+', 'label' => 'Happy Travelers'],
    ];

    $partnerBenefits = [
        ['title' => 'Higher Earnings', 'text' => 'Sell packages with strong value, transparent inclusions, and commission-friendly planning support.', 'image' => asset('images/dubai.jpg')],
        ['title' => 'Faster Bookings', 'text' => 'Reduce back-and-forth with ready package options, clear information, and responsive quote support.', 'image' => asset('images/kerala.avif')],
        ['title' => 'Custom Tour Creation', 'text' => 'Build tailored holidays for honeymooners, families, pilgrims, groups, and budget-focused clients.', 'image' => asset('images/himachal.jpg')],
        ['title' => 'Priority Customer Support', 'text' => 'Work with a team that helps agents respond quickly before, during, and after a trip.', 'image' => asset('images/contact-us-bg.jpg')],
    ];

    $testimonials = [
        ['name' => 'Rohit Sharma', 'agency' => 'SkyRoute Holidays, Jaipur', 'text' => 'SHABDD Travel helped us quote faster and close more family holiday bookings with better package clarity.'],
        ['name' => 'Neha Mehta', 'agency' => 'Mehta Tours, Ahmedabad', 'text' => 'The support team is responsive, and the package range makes it easy to serve different budgets.'],
        ['name' => 'Arjun Das', 'agency' => 'Eastern Trails, Bhubaneswar', 'text' => 'We started with domestic trips and quickly added international holidays because the backend support was dependable.'],
    ];

    $faqs = [
        ['q' => 'Who can become a travel agent partner?', 'a' => 'Travel agencies, independent travel consultants, tour operators, and professionals with a travel client base can apply.'],
        ['q' => 'Is there any registration fee?', 'a' => 'There is no fixed online registration fee shown on this page. Our team will confirm any commercial terms during onboarding.'],
        ['q' => 'How are commissions paid?', 'a' => 'Commission details are shared after approval and are usually linked to confirmed bookings and agreed package terms.'],
        ['q' => 'How long does approval take?', 'a' => 'Most applications are reviewed within a few working days after complete agency details are submitted.'],
    ];
@endphp

@section('content')
    <main class="agent-page">
        <section class="agent-hero"
            style="background-image: linear-gradient(90deg, rgb(10 31 58 / 78%), rgb(10 31 58 / 15%), rgb(10 31 58 / 0%)), url('{{ asset('images/contact-us-bg.jpg') }}');">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="agent-kicker">Travel agent partnership</span>
                        <h1>Partner With Us as a Travel Agent</h1>
                        <p>
                            Grow your travel business, earn attractive commissions, and access exclusive tour packages.
                        </p>
                        <div class="agent-hero-actions">
                            <a href="#joinForm" class="agent-btn agent-btn-gold">Join Now</a>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <aside class="agent-hero-panel" aria-label="Partnership highlights">
                            <div>
                                <strong>Premium partner program</strong>
                                <span>Built for modern travel sellers</span>
                            </div>
                            <ul>
                                <li><i class="bi bi-check2-circle"></i> Fast package quote support</li>
                                <li><i class="bi bi-check2-circle"></i> Domestic and international holidays</li>
                                <li><i class="bi bi-check2-circle"></i> Custom itinerary assistance</li>
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </section>

        <section class="agent-section agent-why">
            <div class="container">
                <div class="agent-section-heading text-center">
                    <span>Why join us</span>
                    <h2>Partner Benefits That Help You Sell Better</h2>
                </div>

                <div class="row g-4">
                    @foreach($benefits as $benefit)
                        <div class="col-md-6 col-xl-4">
                            <article class="agent-benefit-card h-100">
                                <i class="bi {{ $benefit['icon'] }}"></i>
                                <h3>{{ $benefit['title'] }}</h3>
                                <p>{{ $benefit['text'] }}</p>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="agent-section agent-steps-section">
            <div class="container">
                <div class="agent-section-heading text-center">
                    <span>How it works</span>
                    <h2>From Application To First Booking</h2>
                </div>

                <div class="agent-timeline">
                    @foreach($steps as $index => $step)
                        <article class="agent-step-card">
                            <div class="agent-step-number">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div>
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="agent-stats" aria-label="SHABDD Travel partner statistics">
            <div class="container">
                <div class="row g-3">
                    @foreach($stats as $stat)
                        <div class="col-6 col-lg-3">
                            <div class="agent-stat-card">
                                <strong>
                                    <span class="agent-counter" data-target="{{ $stat['count'] }}">0</span>{{ $stat['suffix'] }}
                                </strong>
                                <span>{{ $stat['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="agent-section agent-partner-benefits">
            <div class="container">
                <div class="agent-section-heading text-center">
                    <span>Partner benefits</span>
                    <h2>Designed For Practical Business Growth</h2>
                </div>

                <div class="agent-benefit-stack">
                    @foreach($partnerBenefits as $index => $item)
                        <article
                            class="row g-0 align-items-center agent-image-row {{ $index % 2 ? 'agent-image-row-reverse' : '' }}">
                            <div class="col-lg-6">
                                <div class="agent-image-wrap">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="lazy">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="agent-image-copy">
                                    <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    <h3>{{ $item['title'] }}</h3>
                                    <p>{{ $item['text'] }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="agent-section agent-testimonials">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-lg-4">
                        <div class="agent-section-heading agent-section-heading-left">
                            <span>Agent stories</span>
                            <h2>Success Stories From Our Network</h2>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div id="agentTestimonials" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($testimonials as $index => $testimonial)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <article class="agent-testimonial-card">
                                            <i class="bi bi-quote"></i>
                                            <p>{{ $testimonial['text'] }}</p>
                                            <div>
                                                <strong>{{ $testimonial['name'] }}</strong>
                                                <span>{{ $testimonial['agency'] }}</span>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>

                            <div class="agent-carousel-controls">
                                <button type="button" data-bs-target="#agentTestimonials" data-bs-slide="prev"
                                    aria-label="Previous testimonial">
                                    <i class="bi bi-arrow-left"></i>
                                </button>
                                <button type="button" data-bs-target="#agentTestimonials" data-bs-slide="next"
                                    aria-label="Next testimonial">
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="agent-section agent-form-section" id="joinForm">
            <div class="container">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-5">
                        <div class="agent-form-copy">
                            <span>Apply now</span>
                            <h2>Join Us Form</h2>
                            <p>
                                Fill in your details and our partnership team will connect with you to discuss the next
                                steps, commercial terms, and package support.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <form class="agent-form" id="agentJoinForm" action="#" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="agentName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="agentName" name="full_name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="agencyName" class="form-label">Agency Name</label>
                                    <input type="text" class="form-control" id="agencyName" name="agency_name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="agentEmail" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="agentEmail" name="email" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="agentMobile" class="form-label">Mobile Number</label>
                                    <input type="tel" class="form-control" id="agentMobile" name="mobile" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="agentCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="agentCity" name="city" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="agentState" class="form-label">State</label>
                                    <input type="text" class="form-control" id="agentState" name="state" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="agentExperience" class="form-label">Years of Experience</label>
                                    <input type="number" class="form-control" id="agentExperience" name="experience" min="0"
                                        max="60" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="agentWebsite" class="form-label">Website <span>(Optional)</span></label>
                                    <input type="url" class="form-control" id="agentWebsite" name="website"
                                        placeholder="https://">
                                </div>

                                <div class="col-12">
                                    <label for="agentMessage" class="form-label">Message</label>
                                    <textarea class="form-control" id="agentMessage" name="message" rows="4"></textarea>
                                </div>

                                <div class="col-12">
                                    <div class="form-check agent-terms">
                                        <input class="form-check-input" type="checkbox" value="1" id="agentTerms" required>
                                        <label class="form-check-label" for="agentTerms">
                                            I agree to the Terms & Conditions
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="agent-btn agent-btn-gold agent-submit">
                                        Become a Travel Partner
                                    </button>
                                    <p class="agent-form-note" id="agentFormNote" aria-live="polite"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="agent-section agent-faq">
            <div class="container">
                <div class="agent-section-heading text-center">
                    <span>FAQ</span>
                    <h2>Frequently Asked Questions</h2>
                </div>

                <div class="accordion agent-accordion" id="agentFaqAccordion">
                    @foreach($faqs as $index => $faq)
                        <div class="accordion-item">
                            <h3 class="accordion-header" id="agentFaqHeading{{ $index }}">
                                <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#agentFaqCollapse{{ $index }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="agentFaqCollapse{{ $index }}">
                                    {{ $faq['q'] }}
                                </button>
                            </h3>
                            <div id="agentFaqCollapse{{ $index }}"
                                class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                aria-labelledby="agentFaqHeading{{ $index }}" data-bs-parent="#agentFaqAccordion">
                                <div class="accordion-body">
                                    {{ $faq['a'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="agent-cta"
            style="background-image: linear-gradient(90deg, rgb(10 31 58 / 78%), rgb(10 31 58 / 15%), rgb(10 31 58 / 0%)), url('{{ asset('images/contact-us-bg.jpg') }}');">
            <div class="container">
                <div class="agent-cta-inner">
                    <div>
                        <span>Partner program</span>
                        <h2>Ready to Grow Your Travel Business?</h2>
                    </div>

                    <div class="agent-cta-actions">
                        <a href="#joinForm" class="agent-btn agent-btn-gold">Apply Now</a>
                        <a href="{{ route('contact', [], false) }}" class="agent-btn agent-btn-light">Contact Our Team</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const counters = document.querySelectorAll('.agent-counter');
            const counterObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const counter = entry.target;
                    const target = Number(counter.dataset.target || 0);
                    const duration = 1400;
                    const startTime = performance.now();

                    const tick = function (now) {
                        const progress = Math.min((now - startTime) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 3);
                        counter.textContent = Math.floor(target * eased).toLocaleString('en-IN');

                        if (progress < 1) {
                            requestAnimationFrame(tick);
                        }
                    };

                    requestAnimationFrame(tick);
                    observer.unobserve(counter);
                });
            }, { threshold: 0.35 });

            counters.forEach(function (counter) {
                counterObserver.observe(counter);
            });

            const form = document.getElementById('agentJoinForm');
            const note = document.getElementById('agentFormNote');

            if (form && note) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }

                    note.textContent = 'Thank you. Our partnership team will contact you shortly.';
                    form.reset();
                });
            }
        });
    </script>
@endpush
