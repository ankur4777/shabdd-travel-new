@extends('layouts.app')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <p class="text-uppercase text-muted fw-semibold mb-2" style="letter-spacing: 0.08em;">All Destinations</p>
                    <h1 class="h2 mb-0">Explore Destinations</h1>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-dark">Back to Home</a>
            </div>

            <div class="row g-4">
                @forelse ($destinations as $destination)
                    <div class="col-12 col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm overflow-hidden">
                            <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}" class="card-img-top"
                                style="height: 220px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge text-bg-dark">{{ $destination->country }}</span>
                                    <span class="small text-muted">★ {{ number_format((float) $destination->rating, 1) }}</span>
                                </div>
                                <h2 class="h5">{{ $destination->name }}</h2>
                                <p class="text-muted mb-3">{{ $destination->short_description }}</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold">{{ $destination->formatted_price }}</span>
                                    <a href="{{ route('destinations.show', $destination) }}" class="btn btn-danger btn-sm">Explore</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-secondary mb-0">No destinations found yet.</div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $destinations->links() }}
            </div>
        </div>
    </section>
@endsection
