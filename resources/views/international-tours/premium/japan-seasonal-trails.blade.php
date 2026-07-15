@extends('layouts.app')
@section('meta')
    <title>Japan Seasonal Trails | SHABDD Travel</title>
    <meta name="description" content="A season-led premium Japan journey through Tokyo, Hakone, Kyoto and Osaka with a traditional ryokan stay.">
@endsection
@push('styles')<link rel="stylesheet" href="{{ asset('css/premium-journeys.css') }}">@endpush
@section('content')@include('international-tours.premium.partials.page')@endsection
@include('international-tours.premium.partials.scripts')
