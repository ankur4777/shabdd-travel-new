@extends('layouts.app')

@section('meta')
    <title>Terms & Conditions | SHABDD Travel</title>
    <meta name="description"
        content="Read the terms and conditions for using SHABDD Travel website, services, bookings, payments, cancellations, and support.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/terms.css') }}">
@endpush

@section('content')
    @php
        $terms = [
            [
                'icon' => 'bi-shield-check',
                'title' => 'Acceptance of Terms',
                'summary' => 'By using our website and services, you agree to these terms and our Privacy Policy.',
                'details' => 'Please review these terms before making a booking or submitting any enquiry. If you do not agree with any part of these terms, you should not use our services.',
            ],
            [
                'icon' => 'bi-briefcase',
                'title' => 'Our Services',
                'summary' => 'We provide travel planning, tour packages, hotel bookings, transport arrangements, and related services.',
                'details' => 'Service availability may vary by destination, season, supplier, and selected package. Final inclusions are confirmed at the time of quotation or booking.',
            ],
            [
                'icon' => 'bi-credit-card',
                'title' => 'Bookings & Payments',
                'summary' => 'All bookings are subject to availability and confirmation. Prices may change without prior notice.',
                'details' => 'A booking is confirmed only after required payment and written confirmation from our team. Taxes, fees, and supplier charges may apply as per the selected service.',
            ],
            [
                'icon' => 'bi-arrow-clockwise',
                'title' => 'Cancellations & Refunds',
                'summary' => 'Cancellation policies vary for each package and service. Refunds are processed as per the policy.',
                'details' => 'Refund timelines depend on hotels, airlines, transport partners, payment providers, and package terms shared before confirmation.',
            ],
            [
                'icon' => 'bi-person-check',
                'title' => 'Traveler Responsibilities',
                'summary' => 'Travelers must ensure that all information provided is accurate and must follow destination rules.',
                'details' => 'You are responsible for valid identification, travel documents, timely reporting, and compliance with local rules, hotel policies, and transport guidelines.',
            ],
            [
                'icon' => 'bi-exclamation-triangle',
                'title' => 'Limitation of Liability',
                'summary' => 'SHABDD Travel is not liable for delays, cancellations, injuries, losses, or damages during the trip.',
                'details' => 'We are not responsible for events outside our reasonable control, including weather, strikes, government restrictions, supplier failures, or force majeure events.',
            ],
            [
                'icon' => 'bi-c-circle',
                'title' => 'Intellectual Property',
                'summary' => 'All content on this website is the property of SHABDD Travel and may not be used without permission.',
                'details' => 'Website text, images, branding, package descriptions, and design elements may not be copied, reproduced, or redistributed without written approval.',
            ],
            [
                'icon' => 'bi-pencil-square',
                'title' => 'Changes to Terms',
                'summary' => 'We reserve the right to modify these terms at any time. Changes will be posted on this page.',
                'details' => 'Continued use of the website after updates means you accept the revised terms. Please check this page periodically for changes.',
            ],
            [
                'icon' => 'bi-envelope',
                'title' => 'Contact Us',
                'summary' => 'For questions, please contact us at support@shabddtravel.com or +91 98765 43210.',
                'details' => 'Our support team can help with booking terms, payment questions, cancellation rules, and package-specific conditions.',
            ],
        ];
    @endphp

    <main class="terms-page">
        <section class="terms-hero">
            <img class="terms-hero-img" src="{{ asset('about-image/about-banner.png') }}" alt="Mountain valley traveller">
            <div class="terms-hero-shade"></div>
            <div class="terms-hero-content">
                <nav class="terms-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span aria-hidden="true">/</span>
                    <span>Terms &amp; Conditions</span>
                </nav>
                <h1>Terms &amp; Conditions</h1>
                <p>Please read these terms and conditions carefully before using our website and services.</p>
            </div>
        </section>

        <section class="terms-content" aria-labelledby="terms-heading">
            <div class="terms-intro">
                <span class="terms-intro-icon" aria-hidden="true"><i class="bi bi-file-earmark-text"></i></span>
                <div>
                    <h2 id="terms-heading">Terms &amp; Conditions</h2>
                    <p>By accessing or using the SHABDD Travel website and services, you agree to be bound by the following terms and conditions.</p>
                </div>
            </div>

            <div class="terms-list">
                @foreach($terms as $index => $term)
                    <details class="terms-item">
                        <summary>
                            <span class="terms-item-icon" aria-hidden="true"><i class="bi {{ $term['icon'] }}"></i></span>
                            <span class="terms-item-copy">
                                <strong>{{ $index + 1 }}. {{ $term['title'] }}</strong>
                                <span>{{ $term['summary'] }}</span>
                            </span>
                            <span class="terms-chevron" aria-hidden="true"><i class="bi bi-chevron-down"></i></span>
                        </summary>
                        <p>{{ $term['details'] }}</p>
                    </details>
                @endforeach
            </div>

            <aside class="terms-help">
                <span class="terms-help-icon" aria-hidden="true"><i class="bi bi-headset"></i></span>
                <div>
                    <h2>Need Help?</h2>
                    <p>If you have any questions about our terms and conditions, feel free to contact our support team.</p>
                </div>
                <a href="{{ route('contact') }}">Contact Support <i class="bi bi-arrow-right"></i></a>
            </aside>
        </section>
    </main>
@endsection
