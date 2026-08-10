@extends('layouts.app')

@section('meta')
    <title>Careers at SHABDD Travel | Open Roles</title>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/career.css') }}">
@endpush

@section('content')
<main class="career-page">
    <section class="career-hero">
        <div class="career-container">
            <p class="career-eyebrow"><span></span> Career Opportunities <span></span></p>
            <h1>Explore Our Open Roles</h1>
            <p>Join our talented team and help us create unforgettable travel experiences.</p>
        </div>
    </section>

    <section class="career-listing">
        <div class="career-container">
            <div class="career-grid">
                @forelse($careers as $career)
                    <article class="career-card">
                        <div class="career-card-top">
                            <span class="career-card-icon"><i class="bi bi-briefcase"></i></span>
                            <span class="career-type">{{ $career->job_type }}</span>
                        </div>
                        <p class="career-category">Join SHABDD Travel</p>
                        <h2>{{ $career->title }}</h2>
                        <dl class="career-facts">
                            <div><dt><i class="bi bi-people"></i> Open Roles</dt><dd>{{ $career->open_roles }}</dd></div>
                            <div><dt><i class="bi bi-bar-chart"></i> Experience</dt><dd>{{ $career->experience }}</dd></div>
                            <div><dt><i class="bi bi-geo-alt"></i> Job Location</dt><dd>{{ $career->job_location }}</dd></div>
                        </dl>
                        <a class="career-primary-btn" href="{{ route('careers.show', $career) }}">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                    </article>
                @empty
                    <div class="career-empty">
                        <i class="bi bi-briefcase"></i>
                        <h2>No open roles right now</h2>
                        <p>Please check back soon for new opportunities at SHABDD Travel.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
@endsection
