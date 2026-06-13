@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/all-domestic.css') }}">
@endsection

@section('content')
    <div class="all-domestic-page">
        <section class="domestic-hero-slider">
            <div class="slider-content">
                <h1>All Domestic Tours</h1>
                <p>Explore the incredible diversity and beauty of India.</p>
            </div>
        </section>

        <section class="domestic-info-section">
            <h2>Incredible India Awaits</h2>
            <p>From majestic mountains to serene beaches, find the perfect destination for your next holiday.</p>
        </section>

        <section class="packages-section">
            <h2>All Domestic Packages</h2>
            <div class="package-grid">
                @forelse($packages as $package)
                    <div class="package-card">
                        <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->title }}" class="package-img">
                        <div class="package-details">
                            <h3>{{ $package->title }}</h3>
                            <p class="category-badge">{{ ucfirst($package->category) }}</p>
                            <p class="price">Starting from ₹{{ number_format($package->price, 2) }}</p>
                            <p class="duration">{{ $package->duration }} Days</p>
                            <br>
                            <a href="{{ url('package/' . $package->id) }}" class="btn-book">View Details</a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>No domestic packages currently available. Please check back later!</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection