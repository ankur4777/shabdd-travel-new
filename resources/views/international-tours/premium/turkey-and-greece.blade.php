@extends('layouts.app')
@section('meta')
    <title>Turkey and Greece | SHABDD Travel</title>
    <meta name="description" content="A premium Mediterranean journey through Istanbul, Cappadocia, Athens and Santorini with a relaxed island finish.">
@endsection
@push('styles')<link rel="stylesheet" href="{{ asset('css/premium-journeys.css') }}">@endpush
@section('content')@include('international-tours.premium.partials.page')@endsection
@include('international-tours.premium.partials.scripts')
