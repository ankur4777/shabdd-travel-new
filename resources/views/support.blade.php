@extends('layouts.app')

@section('meta')
    <title>Support Center | SHABDD Travel</title>
    <meta name="description" content="Get help with SHABDD Travel bookings, payments, cancellations and travel planning.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/support.css') }}">
@endpush

@section('content')
<main class="support-page">
    <section class="support-hero">
        <div class="support-shell">
            <div class="support-hero-content">
                <div class="support-kicker"><i class="bi bi-headset"></i> Support Center</div>
                <h1>We're Here<br>To <span class="support-accent">Help</span> You</h1>
                <p>Questions or assistance needed? Our travel team is ready to make your experience simple, smooth and memorable.</p>
                <!-- <form class="support-search" id="supportSearch">
                    <input type="search" id="supportSearchInput" placeholder="Search for help topics..." aria-label="Search help topics">
                    <button type="submit" aria-label="Search"><i class="bi bi-search"></i></button>
                </form> -->
            </div>
        </div>
    </section>

    <section class="support-main">
        <div class="support-shell">
            <div class="support-heading"><h2>How Can We Help You?</h2><span></span></div>
            @php
                $helpCards = [
                    ['bi-headset', '24/7 Support', 'Our team is available to assist you throughout your journey.', 'Live Chat', '#support-faq'],
                    ['bi-envelope', 'Email Support', 'Drop us an email and we will get back to you promptly.', 'Send Email', 'mailto:support@shabddtravel.com'],
                    ['bi-telephone', 'Call Us', 'Speak directly with one of our experienced travel experts.', '+91 99999 99999', 'tel:+919999999999'],
                    ['bi-ticket-perforated', 'Booking Support', 'Need help with your booking, itinerary or travel plan?', 'Get Help', route('contact')],
                    ['bi-credit-card', 'Payment Help', 'Questions about payments, refunds or confirmations?', 'Learn More', '#support-faq'],
                    ['bi-file-earmark-text', 'General Enquiries', 'For any other travel question, we are here for you.', 'Contact Us', route('contact')],
                ];
            @endphp
            <div class="support-options">
                @foreach ($helpCards as [$icon, $title, $text, $label, $url])
                    <article class="support-card" data-support-topic="{{ strtolower($title.' '.$text) }}">
                        <div class="support-card-icon"><i class="bi {{ $icon }}"></i></div>
                        <h3>{{ $title }}</h3><p>{{ $text }}</p>
                        <a href="{{ $url }}">{{ $label }} <i class="bi bi-arrow-right"></i></a>
                    </article>
                @endforeach
            </div>

            <div class="support-panels">
                <aside class="support-cta">
                    <div class="support-kicker">Need more assistance?</div>
                    <h2>Still Need Help?</h2>
                    <p>Our travel experts are just a message away. Reach out and we will get back to you as soon as possible.</p>
                    <a class="support-btn support-btn-light" href="{{ route('contact') }}">Contact Our Team <i class="bi bi-arrow-right"></i></a>
                    <a class="support-btn" href="mailto:support@shabddtravel.com">Send an Email <i class="bi bi-envelope"></i></a>
                </aside>

                <div class="support-faq" id="support-faq">
                    <h2>Popular Help Topics</h2>
                    <div class="accordion" id="supportAccordion">
                        @foreach ([
                            ['How do I book a tour package?', 'Browse our packages, choose your preferred trip and contact our team to customise and confirm it.'],
                            ['Can I modify or cancel my booking?', 'Yes. Changes depend on supplier availability and the cancellation terms attached to your booking.'],
                            ['What is your refund policy?', 'Refund eligibility and timelines vary by airline, hotel and package terms. Contact us with your booking details.'],
                            ['Do you offer group discounts?', 'Yes, special pricing may be available for families, corporate groups and group departures.'],
                            ['How can I make a payment?', 'Our team will provide secure payment instructions after your itinerary and booking details are confirmed.'],
                        ] as $index => [$question, $answer])
                            <div class="accordion-item" data-support-topic="{{ strtolower($question.' '.$answer) }}">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#supportAnswer{{ $index }}">
                                        <i class="bi bi-question-circle"></i>{{ $question }}
                                    </button>
                                </h3>
                                <div id="supportAnswer{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#supportAccordion">
                                    <div class="accordion-body">{{ $answer }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <section class="support-contact">
                <div class="support-contact-content">
                    <div class="support-kicker">Let's Talk</div>
                    <h2>We'd Love To Hear From <span class="support-accent">You!</span></h2>
                    <p>Whether you have a question, feedback or need travel advice, we are just a message away.</p>
                    <div class="support-details">
                        <a class="support-detail text-decoration-none text-dark" href="tel:+919999999999"><i class="bi bi-telephone"></i><span><strong>+91 99999 99999</strong><small>Call us anytime</small></span></a>
                        <a class="support-detail text-decoration-none text-dark" href="mailto:support@shabddtravel.com"><i class="bi bi-envelope"></i><span><strong>support@shabddtravel.com</strong><small>We reply within 24 hours</small></span></a>
                        <div class="support-detail"><i class="bi bi-clock"></i><span><strong>Mon - Sun: 24/7</strong><small>We are always open</small></span></div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    document.getElementById('supportSearch')?.addEventListener('submit', function (event) {
        event.preventDefault();
        const term = document.getElementById('supportSearchInput').value.trim().toLowerCase();
        const topics = document.querySelectorAll('[data-support-topic]');
        topics.forEach(topic => topic.style.display = !term || topic.dataset.supportTopic.includes(term) ? '' : 'none');
        document.querySelector('.support-options')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
</script>
@endpush
