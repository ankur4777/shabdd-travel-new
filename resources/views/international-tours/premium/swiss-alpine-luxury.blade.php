@extends('layouts.app')
@section('meta')
    <title>Swiss Alpine Luxury | SHABDD Travel</title>
    <meta name="description" content="A refined Swiss rail journey through Lucerne, the Bernese Oberland and Zermatt with lake and mountain stays.">
@endsection
@push('styles')<link rel="stylesheet" href="{{ asset('css/premium-journeys.css') }}">@endpush
@section('content')@include('international-tours.premium.partials.page')@endsection
@include('international-tours.premium.partials.scripts')
