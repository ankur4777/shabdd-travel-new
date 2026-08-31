@extends('layouts.app')

@section('meta')
    <title>{{ $career->title }} | Careers at SHABDD Travel</title>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/career.css') }}">
    <link rel="stylesheet" href="{{ asset('css/career-contact.css') }}">
@endpush

@section('content')
<main class="career-page career-detail-page">
    <div class="career-container">
        <nav class="career-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a><i class="bi bi-chevron-right"></i>
            <a href="{{ route('careers.index') }}">Careers</a><i class="bi bi-chevron-right"></i>
            <span>Job Details</span>
        </nav>

        <div class="career-detail-grid">
            <article class="career-detail-card">
                <header class="career-detail-header">
                    <span class="career-type">{{ $career->job_type }}</span>
                    <h1>{{ $career->title }}</h1>
                    <p><i class="bi bi-building"></i> SHABDD Travel, {{ $career->job_location }}</p>
                    <div class="career-detail-meta">
                        <span><i class="bi bi-briefcase"></i><small>Experience</small><strong>{{ $career->experience }}</strong></span>
                        <span><i class="bi bi-geo-alt"></i><small>Job Location</small><strong>{{ $career->job_location }}</strong></span>
                    </div>
                </header>

                @foreach([
                    ['Job Roles & Responsibilities', 'bi-clipboard-check', $career->job_roles_responsibilities, 'number'],
                    ['Required Skills', 'bi-star', $career->required_skills, 'number'],
                    ['Good to Have', 'bi-hand-thumbs-up', $career->good_to_have, 'number'],
                    ['What You Get', 'bi-gift', $career->what_you_get, 'check'],
                ] as [$heading, $icon, $items, $type])
                    @if(!empty($items))
                        <section class="career-content-section">
                            <h2><i class="bi {{ $icon }}"></i>{{ $heading }}</h2>
                            <ol class="career-detail-list {{ $type === 'check' ? 'is-check-list' : '' }}">
                                @foreach($items as $item)
                                    <li>{{ is_array($item) ? ($item['item'] ?? '') : $item }}</li>
                                @endforeach
                            </ol>
                        </section>
                    @endif
                @endforeach
            </article>

            <aside class="career-sidebar">
                <div class="career-side-card">
                    <h2>About This Job</h2>
                    <dl>
                        <div><dt>Employment Type</dt><dd>{{ $career->job_type }}</dd></div>
                        <div><dt>Experience</dt><dd>{{ $career->experience }}</dd></div>
                        <div><dt>Job Location</dt><dd>{{ $career->job_location }}</dd></div>
                        <div><dt>Open Roles</dt><dd>{{ $career->open_roles }}</dd></div>
                        <div><dt>Posted On</dt><dd>{{ $career->created_at->format('d M Y') }}</dd></div>
                    </dl>
                    <a href="#apply-here" class="career-primary-btn"><i class="bi bi-send"></i> Apply Now</a>
                </div>
            </aside>
        </div>

        <section class="career-apply-card" id="apply-here">
            <span class="career-apply-icon"><i class="bi bi-envelope-paper-heart"></i></span>
            <div class="career-apply-copy">
                <p class="career-category">Apply for this role</p>
                <h2>Build your career with SHABDD Travel</h2>
                <p>Share your resume with us by email. For any query, you can call our team directly.</p>
            </div>
            <div class="career-contact-actions">
                <a class="career-contact-link" href="mailto:shabddtravel@gmail.com?subject={{ rawurlencode('Application for ' . $career->title) }}">
                    <i class="bi bi-envelope"></i>
                    <span><small>Send your resume</small><strong>shabddtravel@gmail.com</strong></span>
                </a>
                <div class="career-contact-link career-contact-link--phone">
                    <i class="bi bi-telephone"></i>
                    <div class="career-contact-phone-list">
                        <a href="tel:+919643305791">
                            <strong>+91 96433 05791</strong>
                        </a>
                        <a href="tel:+917347673924">
                            <strong>+91 73476 73924</strong>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
