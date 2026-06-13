@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/family-specials.css') }}">
@endsection

@section('content')
    <div class="family-specials-page">
        <section class="family-hero-slider">
            <div class="slider-content">
                <h1>Family Specials</h1>
                <p>Create unforgettable memories with your loved ones.</p>
            </div>
        </section>

        <section class="family-info-section">
            <h2>Perfect Getaways for the Whole Family</h2>
            <p>From kid-friendly activities to relaxing retreats for adults, our family packages offer something for
                everyone.</p>
        </section>

        <section class="packages-section">
            <h2>Our Top Family Packages</h2>
            <div class="package-grid">
                @forelse($packages as $package)
                    <div class="package-card">
                        <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" class="package-img">
                        <div class="package-details">
                            <h3>{{ $package->title }}</h3>
                            <p class="price">Starting from ₹{{ number_format($package->price, 2) }}</p>
                            <p class="duration">{{ $package->duration }} Days</p>
                            <br>
                            <a href="{{ url('package/' . $package->id) }}" class="btn-book">View Details</a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>No family packages currently available. Please check back later!</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection