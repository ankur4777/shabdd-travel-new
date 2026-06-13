@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/honeymoon-picks.css') }}">
@endsection

@section('content')
    <div class="honeymoon-page">
        <section class="honeymoon-hero-slider">
            <div class="slider-content">
                <h1>Honeymoon Picks</h1>
                <p>Romantic destinations for your perfect beginning.</p>
            </div>
        </section>

        <section class="honeymoon-info-section">
            <h2>Celebrate Love</h2>
            <p>Exclusive romantic experiences, luxury stays, and breathtaking views selected just for couples.</p>
        </section>

        <section class="packages-section">
            <h2>Curated Honeymoon Packages</h2>
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
                        <p>No honeymoon packages currently available. Please check back later!</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection