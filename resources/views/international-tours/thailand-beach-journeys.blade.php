@extends('layouts.app')

@section('meta')
    <title>Thailand Beach Journeys | SHABDD Travel</title>
    <meta name="description"
        content="Explore Thailand with a balanced journey through lively markets, island days, local food and relaxed beach time.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/most-booked.css') }}">
@endpush

@section('content')
    @include('international-tours.partials.most-booked-page')
@endsection

@include('international-tours.partials.most-booked-scripts')
