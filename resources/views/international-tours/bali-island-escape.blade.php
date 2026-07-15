@extends('layouts.app')

@section('meta')
    <title>Bali Island Escape | SHABDD Travel</title>
    <meta name="description"
        content="Plan a Bali escape with temple mornings, rice-field landscapes, coastal evenings and enough time to slow down.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/most-booked.css') }}">
@endpush

@section('content')
    @include('international-tours.partials.most-booked-page')
@endsection

@include('international-tours.partials.most-booked-scripts')
