@extends('layouts.app')

@section('meta')
    <title>Dubai Dream Holidays | SHABDD Travel</title>
    <meta name="description"
        content="Plan a well-paced Dubai holiday with city landmarks, old Dubai, a desert evening, waterfront stays and flexible package options.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/most-booked.css') }}">
@endpush

@section('content')
    @include('international-tours.partials.most-booked-page')
@endsection

@include('international-tours.partials.most-booked-scripts')
