@extends('layouts.app')

@section('meta')
    <title>Copyright Policy | SHABDD Travel</title>
    <meta name="description" content="Read the SHABDD Travel copyright policy and understand how our website content may be used.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/copyright-policy.css') }}">
@endpush

@section('content')
    <main class="copyright-page">
        <section class="copyright-hero">
            <img src="{{ asset('images/copyright-banner-page.png') }}" alt="Copyright symbol with travel photography equipment at sunset">
            <div class="copyright-hero-overlay"></div>

            <div class="copyright-container copyright-hero-content">
                <nav class="copyright-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                    <span>Copyright Policy</span>
                </nav>
                <h1>Copyright Policy</h1>
                <p>Please read how the content available on the SHABDD Travel website may be viewed, shared, and used.</p>
            </div>
        </section>

        <section class="copyright-content">
            <div class="copyright-container copyright-policy-wrap">
                <header class="copyright-intro">
                    <span class="copyright-intro-icon" aria-hidden="true"><i class="bi bi-c-circle"></i></span>
                    <div>
                        <p class="copyright-label">SHABDD Travel</p>
                        <h2>Our Copyright Policy</h2>
                        <p>All original text, images, videos, logos, graphics, package details, and other content on this website are protected by copyright law.</p>
                    </div>
                </header>

                @php
                    $copyrightSections = [
                        [
                            'icon' => 'bi-shield-check',
                            'title' => 'Content Ownership',
                            'text' => 'Content created and published by SHABDD Travel belongs to us unless another owner or source is clearly mentioned.',
                        ],
                        [
                            'icon' => 'bi-check2-circle',
                            'title' => 'What You Can Do',
                            'text' => 'You may browse our content, share links to our website, and use booking documents for your personal trip.',
                        ],
                        [
                            'icon' => 'bi-slash-circle',
                            'title' => 'What You Cannot Do',
                            'text' => 'You may not copy, sell, republish, modify, or use our content for commercial purposes without written permission.',
                        ],
                        [
                            'icon' => 'bi-image',
                            'title' => 'Images and Brand Logo',
                            'text' => 'Our photographs, graphics, and SHABDD logo cannot be downloaded or used for advertising, business, or promotional purposes without approval.',
                        ],
                        [
                            'icon' => 'bi-people',
                            'title' => 'Third-Party Content',
                            'text' => 'Some photographs, maps, reviews, or partner materials may belong to their original owners and are covered by their own copyright terms.',
                        ],
                        [
                            'icon' => 'bi-flag',
                            'title' => 'Report a Copyright Issue',
                            'text' => 'If you believe any content on our website violates your copyright, contact us with the page link, details of the content, and proof of ownership.',
                        ],
                    ];
                @endphp

                <div class="copyright-list">
                    @foreach($copyrightSections as $index => $section)
                        <article class="copyright-item">
                            <span class="copyright-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="copyright-item-icon" aria-hidden="true"><i class="bi {{ $section['icon'] }}"></i></span>
                            <div>
                                <h3>{{ $section['title'] }}</h3>
                                <p>{{ $section['text'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="copyright-contact">
                    <div>
                        <p class="copyright-label">Need our permission?</p>
                        <h2>Contact the SHABDD Travel team</h2>
                        <p>For content-use permission or copyright questions, please send us the details of your request.</p>
                    </div>
                    <a href="{{ route('contact') }}">Contact Us <i class="bi bi-arrow-right"></i></a>
                </aside>
            </div>
        </section>
    </main>
@endsection
