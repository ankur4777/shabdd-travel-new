@extends('layouts.app')

@section('meta')
    <title>Contact SHABDD Travel</title>
    <meta name="description"
        content="Contact SHABDD Travel for curated holiday packages, destination planning, support, and partnership enquiries.">
@endsection

@push('styles')
    <style>
        .contact-page {
            background: #f7f7f7;
            color: #111;
        }

        .contact-hero {
            position: relative;
            overflow: hidden;
            align-items: center;
            min-height: min(560px, 55vh);
            display: flex;
            margin: 0 auto;
            isolation: isolate;
            color: #fff;
            background: linear-gradient(90deg, rgb(17 17 17 / 61%), rgb(17 17 17 / 0%)), url("/images/contact-banner .jpeg") center / cover no-repeat;
        }

        .contact-hero::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 44%;
            background: linear-gradient(180deg, rgba(17, 17, 17, 0), rgba(17, 17, 17, 0.68));
            z-index: -1;
            align-items: center;
        }

        .contact-hero-inner {
            width: min(100% - 32px, 1320px);
            margin:auto;
          
          
        }

        .contact-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 14px;
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .contact-kicker::before {
            content: "";
            width: 28px;
            height: 2px;
            border-radius: 99px;
            background: #ff3b30;
        }

        .contact-title {
            max-width: 760px;
            margin: 0;
            font-family: var(--font-display, inherit);
            font-size: clamp(2.25rem, 2vw, 5.75rem);
            font-weight: 900;
            line-height: 0.98;
            letter-spacing: 0;
            color: #ffecee;
        }

        .contact-copy {
            max-width: 650px;
            margin: 20px 0 0;
            color: rgba(255, 255, 255, 0.84);
            font-size: clamp(1rem, 1.8vw, 1.2rem);
            line-height: 1.7;
        }

        .contact-shell {
            width: min(100% - 32px, 1180px);
            margin: -34px auto 72px;
            position: relative;
            z-index: 2;
        }

        .contact-quick-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .contact-quick-card,
        .contact-form-panel,
        .contact-info-panel {
            border: 1px solid rgba(17, 17, 17, 0.08);
            background: #fff;
            box-shadow: 0 22px 70px rgba(17, 17, 17, 0.08);
        }

        .contact-quick-card {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 112px;
            padding: 18px;
            border-radius: 8px;
            text-decoration: none;
            color: #111;
        }

        .contact-quick-icon {
            width: 38px;
            height: 38px;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
            font-size: 1.05rem;
        }

        .contact-quick-label {
            display: block;
            color: rgba(17, 17, 17, 0.56);
            font-size: 0.56rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .contact-quick-value {
            display: block;
            margin-top: 4px;
            color: #111;
            font-size: 0.8rem;
            font-weight: 850;
            line-height: 1.35;
        }

        .contact-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.12fr) minmax(320px, 0.88fr);
            gap: 22px;
            align-items: start;
        }

        .contact-form-panel,
        .contact-info-panel {
            border-radius: 8px;
            padding: clamp(22px, 4vw, 34px);
        }

        .contact-section-kicker {
            margin: 0 0 10px;
            color: #ff3b30;
            font-size: 0.78rem;
            font-weight: 850;
            text-transform: uppercase;
        }

        .contact-section-title {
            margin: 0 0 10px;
            font-family: var(--font-display, inherit);
            font-size: clamp(1.45rem, 2.4vw, 2rem);
            font-weight: 900;
            letter-spacing: 0;
        }

        .contact-section-text {
            margin: 0 0 24px;
            color: rgba(17, 17, 17, 0.62);
            line-height: 1.7;
        }

        .contact-form {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .contact-field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .contact-field-full {
            grid-column: 1 / -1;
        }

        .contact-field label {
            color: rgba(17, 17, 17, 0.72);
            font-size: 0.78rem;
            font-weight: 850;
            text-transform: uppercase;
        }

        .contact-field input,
        .contact-field select,
        .contact-field textarea {
            width: 100%;
            border: 1px solid rgba(17, 17, 17, 0.12);
            border-radius: 8px;
            background: #fafafa;
            color: #111;
            font-size: 0.98rem;
            font-weight: 650;
            outline: none;
            padding: 13px 14px;
            transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }

        .contact-field textarea {
            min-height: 132px;
            resize: vertical;
        }

        .contact-field input:focus,
        .contact-field select:focus,
        .contact-field textarea:focus {
            border-color: rgba(255, 59, 48, 0.58);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 59, 48, 0.08);
        }

        .contact-submit {
            grid-column: 1 / -1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 50px;
            border: 0;
            border-radius: 8px;
            background: #ff3b30;
            color: #fff;
            font-weight: 900;
            text-transform: uppercase;
            box-shadow: 0 18px 42px rgba(255, 59, 48, 0.24);
        }

        .contact-info-list {
            display: grid;
            gap: 14px;
            margin: 0 0 24px;
        }

        .contact-info-item {
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr);
            gap: 12px;
            align-items: start;
            padding: 14px 0;
            border-bottom: 1px solid rgba(17, 17, 17, 0.07);
        }

        .contact-info-item:last-child {
            border-bottom: 0;
        }

        .contact-info-icon {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(31, 143, 95, 0.1);
            color: #ff3b30;
            font-size: 1.1rem;
        }

        .contact-info-title {
            margin: 0 0 4px;
            font-weight: 900;
        }

        .contact-info-copy,
        .contact-info-copy a {
            margin: 0;
            color: rgba(17, 17, 17, 0.64);
            line-height: 1.6;
            text-decoration: none;
        }

        .contact-map {
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid rgba(17, 17, 17, 0.08);
            background:
                linear-gradient(135deg, rgba(255, 59, 48, 0.1), rgba(31, 143, 95, 0.1)),
                url("{{ asset('images/indian-traveller.png') }}") right bottom/contain no-repeat,
                #f6f6f6;
            min-height: 210px;
            padding: 20px;
            display: flex;
            align-items: flex-start;
        }

        .contact-map-copy {
            max-width: 260px;
        }

        .contact-map-copy strong {
            display: block;
            margin-bottom: 6px;
            font-size: 1.05rem;
            font-weight: 900;
        }

        .contact-map-copy span {
            color: rgba(17, 17, 17, 0.62);
            line-height: 1.6;
        }

        @media (max-width: 991.98px) {

            .contact-quick-grid,
            .contact-main-grid {
                grid-template-columns: 1fr;
            }

            .contact-shell {
                margin-top: -22px;
            }
        }

        @media (max-width: 575.98px) {
            .contact-hero {
                min-height: 500px;
                align-items: center;
            }

            .contact-hero-inner {
                padding-bottom: 44px;
             
            }

            .contact-form {
                grid-template-columns: 1fr;
            }

            .contact-quick-card {
                min-height: 96px;
            }
        }
    </style>
@endpush

@section('content')
    <main class="contact-page">
        <section class="contact-hero">
            <div class="contact-hero-inner">
                <p class="contact-kicker">Contact SHABDD Travel</p>
                <h1 class="contact-title">Tell us where your next journey should begin.</h1>
                <p class="contact-copy">
                    Our travel specialists help with custom holidays, package questions, destination guidance, and
                    partnership enquiries across India and international routes.
                </p>
            </div>
        </section>

        <section class="contact-shell" aria-label="Contact options">
            <div class="contact-quick-grid">
                <a href="tel:+919999999999" class="contact-quick-card">
                    <span class="contact-quick-icon"><i class="bi bi-telephone"></i></span>
                    <span>
                        <span class="contact-quick-label">Call support</span>
                        <span class="contact-quick-value">+91 99999 99999</span>
                    </span>
                </a>
                <a href="mailto:support@shabddtravel.com" class="contact-quick-card">
                    <span class="contact-quick-icon"><i class="bi bi-envelope"></i></span>
                    <span>
                        <span class="contact-quick-label">Email us</span>
                        <span class="contact-quick-value">support@shabddtravel.com</span>
                    </span>
                </a>
                <a href="https://wa.me/919999999999" class="contact-quick-card">
                    <span class="contact-quick-icon"><i class="bi bi-whatsapp"></i></span>
                    <span>
                        <span class="contact-quick-label">WhatsApp</span>
                        <span class="contact-quick-value">Chat with a trip expert</span>
                    </span>
                </a>
            </div>

            <div class="contact-main-grid">
                <section class="contact-form-panel" aria-labelledby="contactFormTitle">
                    <p class="contact-section-kicker">Trip enquiry</p>
                    <h2 class="contact-section-title" id="contactFormTitle">Send your travel request</h2>
                    <p class="contact-section-text">
                        Share a few details and the team will get back with a suitable package plan.
                    </p>

                    <form class="contact-form" action="mailto:support@shabddtravel.com" method="POST" enctype="text/plain">
                        <div class="contact-field">
                            <label for="contactName">Full name</label>
                            <input id="contactName" name="name" type="text" placeholder="Your name" required>
                        </div>

                        <div class="contact-field">
                            <label for="contactPhone">Phone number</label>
                            <input id="contactPhone" name="phone" type="tel" placeholder="+91 99999 99999" required>
                        </div>

                        <div class="contact-field">
                            <label for="contactEmail">Email</label>
                            <input id="contactEmail" name="email" type="email" placeholder="you@example.com">
                        </div>

                        <div class="contact-field">
                            <label for="contactInterest">Travel interest</label>
                            <select id="contactInterest" name="interest" required>
                                <option value="">Select interest</option>
                                <option>Domestic tour</option>
                                <option>International tour</option>
                                <option>Honeymoon package</option>
                                <option>Family trip</option>
                                <option>Religious tour</option>
                                <option>Corporate tour</option>
                                <option>Agent or partnership enquiry</option>
                            </select>
                        </div>

                        <div class="contact-field contact-field-full">
                            <label for="contactMessage">Message</label>
                            <textarea id="contactMessage" name="message"
                                placeholder="Destination, dates, budget, travellers, and anything else we should know"></textarea>
                        </div>

                        <button class="contact-submit"  type="submit">
                            <i class="bi bi-send"></i>
                            Send enquiry
                        </button>
                    </form>
                </section>

                <aside class="contact-info-panel" aria-label="Contact details">
                    <p class="contact-section-kicker">Office details</p>
                    <h2 class="contact-section-title">Plan with a specialist</h2>
                    <p class="contact-section-text">
                        Reach the SHABDD Travel team for itinerary support, booking help, and custom package planning.
                    </p>

                    <div class="contact-info-list">
                        <div class="contact-info-item">
                            <span class="contact-info-icon"><i class="bi bi-clock"></i></span>
                            <div>
                                <p class="contact-info-title">Working hours</p>
                                <p class="contact-info-copy">Monday to Saturday, 10:00 AM - 7:00 PM</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon"><i class="bi bi-geo-alt"></i></span>
                            <div>
                                <p class="contact-info-title">Service area</p>
                                <p class="contact-info-copy">India tours, international holidays, group departures, and
                                    curated custom trips.</p>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <span class="contact-info-icon"><i class="bi bi-envelope-paper"></i></span>
                            <div>
                                <p class="contact-info-title">Support mailbox</p>
                                <p class="contact-info-copy"><a
                                        href="mailto:support@shabddtravel.com">support@shabddtravel.com</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="contact-map">
                        <p class="contact-map-copy">
                            <strong>Need a fast quote?</strong>
                            <span>Send the destination, travel month, number of travellers, and preferred budget.</span>
                        </p>
                    </div>
                </aside>
            </div>
        </section>
    </main>
@endsection
