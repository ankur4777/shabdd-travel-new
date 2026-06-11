@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/budget-friendly.css') }}">
@endpush

@section('content')
    <section class="budget-hero"
        style="background-image: linear-gradient(90deg, rgba(8, 43, 38, 89%), rgba(8, 43, 38, 33%), rgba(8, 43, 38, 0%)), url('{{ asset('images/kerala.avif') }}');">
        <div class="container">
            <div class="budget-hero-grid">
                <div class="budget-hero-copy">
                    <span class="budget-eyebrow">Smart value holidays</span>
                    <h1>Budget Friendly Trips Without Cutting The Experience</h1>
                    <p>
                        Handpicked packages with practical stays, efficient routes, and the right inclusions so you can
                        travel comfortably while keeping the spend sensible.
                    </p>

                    <div class="budget-actions">
                        <a href="#budgetPackages" class="budget-btn budget-btn-primary">View Deals</a>
                        <a href="{{ route('contact', [], false) }}" class="budget-btn budget-btn-outline">Customize Trip</a>
                    </div>
                </div>

                <div class="budget-value-card">
                    <span>Why travelers choose this</span>
                    <ul>
                        <li>Clear package pricing</li>
                        <li>Popular routes and stays</li>
                        <li>Flexible upgrades available</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="budget-promise">
        <div class="container">
            <div class="budget-section-head">
                <span>Spend smarter</span>
                <h2>More Trip, Less Guesswork</h2>
            </div>

            <div class="budget-feature-grid">
                <article class="budget-feature">
                    <i class="bi bi-wallet2"></i>
                    <h3>Value-Led Packages</h3>
                    <p>Curated options that balance location, comfort, sightseeing, and transfers at practical prices.</p>
                </article>

                <article class="budget-feature">
                    <i class="bi bi-map"></i>
                    <h3>Efficient Itineraries</h3>
                    <p>Routes planned to reduce unnecessary travel time and make each day feel useful without becoming
                        rushed.</p>
                </article>

                <article class="budget-feature">
                    <i class="bi bi-arrow-up-circle"></i>
                    <h3>Easy Upgrades</h3>
                    <p>Add better rooms, private cabs, activities, or meals where they matter most to your group.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="budget-strip">
        <div class="container">
            <div class="budget-strip-inner">
                <div>
                    <span>Popular for</span>
                    <strong>Families, students, couples, and first-time travelers</strong>
                </div>
                <a href="{{ route('packages.index') }}" class="budget-strip-link">Browse All Packages</a>
            </div>
        </div>
    </section>

    <div id="budgetPackages">
        @include('partials.package-listing', [
            'listingKey' => 'budget',
            'listingRoute' => route('budget-friendly'),
            'sectionKicker' => 'Budget Friendly',
            'sectionTitle' => 'Popular Budget Friendly Packages',
            'defaultTag' => 'Budget Friendly',
        ])
        </div>
@endsection
