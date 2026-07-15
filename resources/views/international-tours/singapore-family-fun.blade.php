@extends('layouts.app')

@section('meta')
    <title>Singapore Family Fun | SHABDD Travel</title>
    <meta name="description"
        content="Discover a family-friendly Singapore holiday with easy transport, playful attractions, waterfront evenings and flexible pacing.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/most-booked.css') }}">
@endpush

@section('content')
    @include('international-tours.partials.most-booked-page')
@endsection

@include('international-tours.partials.most-booked-scripts')
