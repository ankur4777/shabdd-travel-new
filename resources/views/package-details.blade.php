@extends('layouts.app')

@section('content')

    <section class="package-details-page">

        <div class="container">

            <div class="row align-items-center">

                {{-- IMAGE --}}
                <div class="col-lg-6">

                    <img src="{{ asset('storage/' . $package->image) }}" class="img-fluid rounded"
                        alt="{{ $package->title }}">

                </div>

                {{-- CONTENT --}}
                <div class="col-lg-6">

                    <span class="badge bg-danger mb-3">
                        {{ $package->category }}
                    </span>

                    <h1>
                        {{ $package->title }}
                    </h1>

                    <div class="d-flex gap-3 mb-3">

                        <span>⭐ {{ $package->rating }}</span>

                        <span>{{ $package->duration_text }}</span>

                        <span>{{ ucfirst($package->travel_style) }}</span>

                    </div>

                    <div class="mb-4">

                        @if($package->old_price)
                            <del class="text-muted">
                                ₹{{ number_format($package->old_price) }}
                            </del>
                        @endif

                        <h2 class="text-danger">
                            ₹{{ number_format($package->price) }}
                        </h2>

                    </div>

                    <ul class="mb-4">

                        @if($package->feature_1)
                            <li>{{ $package->feature_1 }}</li>
                        @endif

                        @if($package->feature_2)
                            <li>{{ $package->feature_2 }}</li>
                        @endif

                        @if($package->feature_3)
                            <li>{{ $package->feature_3 }}</li>
                        @endif

                    </ul>

                    <div class="package-description">

                        {!! $package->description !!}

                    </div>

                </div>

            </div>

        </div>

    </section>
















@endsection