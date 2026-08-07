@extends('layouts.app')

@section('meta')
    <title>Privacy Policy | SHABDD Travel</title>
    <meta name="description" content="Learn how SHABDD Travel collects, uses, protects, and shares your personal information.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/privacy-policy.css') }}">
@endpush

@section('content')
    <main class="privacy-page">
        <section class="privacy-hero">
            <img src="{{ asset('images/privacy banner.png') }}" alt="A privacy shield overlooking a mountain lake">
            <div class="privacy-hero-overlay"></div>
            <div class="privacy-container privacy-hero-copy">
                <nav class="privacy-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a><i class="bi bi-chevron-right" aria-hidden="true"></i><span>Privacy Policy</span>
                </nav>
                <span class="privacy-kicker"><i class="bi bi-shield-lock"></i> Your privacy matters</span>
                <h1>Privacy Policy</h1>
                <p>We are committed to protecting your personal information and being transparent about how we use it.</p>
            </div>
        </section>

        <section class="privacy-content">
            <div class="privacy-container privacy-layout">
                <article class="privacy-main">
                    <header class="privacy-intro">
                        <span class="privacy-section-icon"><i class="bi bi-database-lock"></i></span>
                        <div>
                            <p class="privacy-eyebrow">Our commitment to you</p>
                            <h2>Information We Collect</h2>
                            <p>We collect only the information needed to plan your journey, manage your bookings, and improve your experience with SHABDD Travel.</p>
                        </div>
                    </header>

                    <div class="privacy-card privacy-collection-card">
                        <div class="privacy-card-heading">
                            <span class="privacy-card-icon"><i class="bi bi-person-vcard"></i></span>
                            <div><h3>Personal Information</h3><p>Information you provide when you enquire, book, or contact us.</p></div>
                        </div>
                        <div class="privacy-detail-list">
                            <div><i class="bi bi-check-circle-fill"></i><span><strong>Contact details</strong>Your name, email address, phone number, and residential address.</span></div>
                            <div><i class="bi bi-check-circle-fill"></i><span><strong>Travel details</strong>Destination, dates, preferences, traveller details, and special requests.</span></div>
                            <div><i class="bi bi-check-circle-fill"></i><span><strong>Booking information</strong>Payment status, invoices, booking references, and communication history.</span></div>
                        </div>
                    </div>

                    <section class="privacy-use">
                        <span class="privacy-section-icon"><i class="bi bi-stars"></i></span>
                        <div>
                            <p class="privacy-eyebrow">Purpose and transparency</p>
                            <h2>How We Use Your Information</h2>
                            <p>Your information helps us deliver a smooth, person
                                
                            
                            alised travel experience from your first enquiry until you return home.</p>
                            <ul>
                                <li><strong>Plan and manage bookings</strong><span>Prepare itineraries, confirm reservations, process payments, and provide trip updates.</span></li>
                                <li><strong>Improve our services</strong><span>Understand traveller needs and improve our website, packages, and customer support.</span></li>
                                <li><strong>Keep you informed</strong><span>Send relevant service messages, offers, and travel inspiration when you choose to receive them.</span></li>
                            </ul>
                        </div>
                    </section>
                </article>

                <aside class="privacy-sidebar" aria-label="Privacy policy summary">
                    <div class="privacy-card privacy-summary">
                        <div class="privacy-summary-item"><span><i class="bi bi-activity"></i></span><div><h3>Usage Information</h3><p>We may collect device, browser, IP address, and website interaction data to keep our services reliable.</p></div></div>
                        <div class="privacy-summary-item"><span><i class="bi bi-share"></i></span><div><h3>Sharing Your Information</h3><p>We share necessary details only with trusted travel partners and service providers who help fulfil your booking.</p></div></div>
                        <div class="privacy-summary-item"><span><i class="bi bi-toggles"></i></span><div><h3>Your Rights &amp; Choices</h3><p>You may ask to access, correct, or delete your personal data, subject to legal and booking requirements.</p></div></div>
                    </div>

                    <div class="privacy-card privacy-cookie">
                        <span class="privacy-card-icon"><i class="bi bi-cookie"></i></span>
                        <div><h3>Cookies &amp; Tracking</h3><p>Cookies help us remember preferences, understand site performance, and provide a better browsing experience.</p></div>
                    </div>

                    <div class="privacy-help">
                        <i class="bi bi-chat-heart"></i>
                        <h2>Have Questions?</h2>
                        <p>We’re here to help with any questions about this Privacy Policy or your data.</p>
                        <a href="{{ route('contact') }}">Contact Us <i class="bi bi-arrow-right"></i></a>
                    </div>
                </aside>
            </div>
        </section>
    </main>
@endsection
