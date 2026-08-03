@extends('layouts.app')

@section('meta')
    <title>About SHABDD Travel</title>
    <meta name="description"
        content="Learn about SHABDD Travel and our approach to creating curated holiday experiences.">
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush


@section('content')
    <main class="about-page">
        <div class="about-image-banner">
            <img src="/about-image/about-banner.png" alt="About SHABDD Travel">
            
        </div>
        

    </main>
@endsection
