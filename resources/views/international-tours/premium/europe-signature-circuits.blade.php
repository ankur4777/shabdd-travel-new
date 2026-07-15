@extends('layouts.app')
@section('meta')
    <title>Europe Signature Circuits | SHABDD Travel</title>
    <meta name="description" content="A thoughtfully paced premium Europe circuit through Paris, Switzerland, Venice, Florence and Rome.">
@endsection
@push('styles')<link rel="stylesheet" href="{{ asset('css/premium-journeys.css') }}">@endpush
@section('content')@include('international-tours.premium.partials.page')@endsection
@include('international-tours.premium.partials.scripts')
