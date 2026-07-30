@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/blog-filter.css') }}">
    <style>
        .blog-detail-hero {
            position: relative;
            height: 560px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
        }

        .blog-detail-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.3) 50%, transparent 100%);
        }

        .blog-detail-hero-content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 70px 0 50px;
        }

        .blog-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .9rem;
            margin-bottom: 20px;
            opacity: .9;
        }

        .blog-breadcrumb a {
            color: white;
            text-decoration: none;
        }

        .blog-detail-category {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border-radius: 24px;
            font-size: .85rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .blog-detail-title {
            font-size: 3.2rem;
            font-weight: 900;
            margin-bottom: 20px;
            line-height: 1.2;
            text-shadow: 0 2px 20px rgba(0, 0, 0, .3);
        }

        .blog-detail-meta {
            display: flex;
            gap: 18px;
            font-size: .95rem;
            flex-wrap: wrap;
        }

        .blog-detail-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, .12);
            padding: 8px 14px;
            border-radius: 20px;
        }

        .blog-content-wrapper {
            display: flex;
            gap: 36px;
            margin-top: -30px;
            position: relative;
            z-index: 10;
        }

        .blog-content-main {
            flex: 1;
            background: #fff;
            border-radius: 20px;
            padding: 42px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, .1);
        }

        .blog-content-sidebar {
            width: 350px;
            flex-shrink: 0;
        }

        .blog-content p {
            font-size: 1.1rem;
            line-height: 1.85;
            color: #374151;
            margin-bottom: 20px;
        }

        .blog-content p:first-of-type::first-letter {
            font-size: 3.6rem;
            font-weight: 900;
            float: left;
            line-height: 1;
            margin: 0 10px 0 0;
            color: #667eea;
        }

        .blog-highlights {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            padding: 28px;
            border-radius: 16px;
            margin: 26px 0;
            border-left: 5px solid #667eea;
        }

        .blog-highlights h3 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 14px;
            color: #1f2937;
        }

        .blog-highlights ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .blog-highlights li {
            padding: 12px 0 12px 34px;
            position: relative;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
        }

        .blog-highlights li:last-child {
            border-bottom: 0;
        }

        .blog-highlights li::before {
            content: '✓';
            position: absolute;
            left: 0;
            top: 12px;
            width: 24px;
            height: 24px;
            background: #667eea;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blog-facts-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin: 24px 0;
        }

        .blog-fact-card {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px;
        }

        .blog-fact-label {
            display: block;
            font-size: .78rem;
            color: #6b7280;
            margin-bottom: 6px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .blog-fact-value {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
        }

        .blog-itinerary,
        .blog-faq,
        .destination-more {
            margin-top: 28px;
        }

        .blog-itinerary h3,
        .blog-faq h3,
        .destination-more h3 {
            font-size: 1.35rem;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .itinerary-list {
            display: grid;
            gap: 10px;
        }

        .itinerary-item {
            background: #f9fafb;
            border: 1px solid #eceff3;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .itinerary-item strong {
            color: #667eea;
        }

        .faq-item {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 10px;
            background: #fff;
        }

        .faq-item summary {
            list-style: none;
            cursor: pointer;
            padding: 12px 14px;
            font-weight: 700;
            color: #1f2937;
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
        }

        .faq-item p {
            padding: 0 14px 12px;
            margin: 0;
            font-size: 1rem;
        }

        .share-section {
            background: #f9fafb;
            padding: 24px;
            border-radius: 14px;
            margin: 24px 0;
            text-align: center;
        }

        .share-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .share-btn {
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: #fff;
        }

        .share-btn-facebook {
            background: #1877f2;
        }

        .share-btn-twitter {
            background: #1da1f2;
        }

        .share-btn-linkedin {
            background: #0a66c2;
        }

        .share-btn-whatsapp {
            background: #25d366;
        }

        .author-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 16px;
            padding: 26px;
            margin: 22px 0 10px;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .author-avatar {
            width: 84px;
            height: 84px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .2);
            border: 3px solid rgba(255, 255, 255, .3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 900;
        }

        .destination-more {
            padding: 18px;
            background: #f8fafc;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
        }

        .destination-more-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .destination-more-link {
            display: block;
            padding: 10px 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            text-decoration: none;
            color: #1f2937;
            font-weight: 600;
        }

        .destination-more-link:hover {
            color: #667eea;
            border-color: #667eea;
        }

        .related-posts {
            background: #f9fafb;
            padding: 60px 0;
            margin-top: 60px;
        }

        .related-card {
            height: 100%;
            overflow: hidden;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(15, 23, 42, .08);
        }

        .related-card-img-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background: #e5e7eb;
        }

        .related-card-img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .related-card-body {
            padding: 20px;
        }

        .related-card-category {
            display: inline-flex;
            margin-bottom: 12px;
            padding: 6px 12px;
            border-radius: 16px;
            background: #667eea;
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .related-card-title {
            margin-bottom: 14px;
            font-size: 1.1rem;
            font-weight: 800;
            line-height: 1.35;
        }

        .related-card-title a {
            color: #1f2937;
            text-decoration: none;
        }

        .related-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            color: #6b7280;
            font-size: .86rem;
        }

        @media (max-width: 991px) {
            .blog-content-wrapper {
                flex-direction: column;
                margin-top: 30px;
            }

            .blog-content-sidebar {
                display: none;
            }

            .blog-content-main {
                padding: 30px 22px;
            }

            .blog-detail-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 767px) {
            .blog-detail-title {
                font-size: 1.8rem;
            }

            .blog-facts-grid,
            .destination-more-grid {
                grid-template-columns: 1fr;
            }

            .author-box {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="blog-detail-hero" style="background-image: url('{{ $post['image'] }}')">
        <div class="container">
            <div class="blog-detail-hero-content">
                <div class="blog-breadcrumb">
                    <a href="{{ route('home') }}">Home</a><i class="bi bi-chevron-right"></i>
                    <a href="{{ route('blog.index') }}">Blog</a><i class="bi bi-chevron-right"></i>
                    <span>{{ $post['destination_name'] }}</span>
                </div>
                <span class="blog-detail-category"><i class="bi bi-bookmark-fill"></i>{{ $post['category'] }}</span>
                <h1 class="blog-detail-title">{{ $post['title'] }}</h1>
                <div class="blog-detail-meta">
                    <span><i class="bi bi-person-circle"></i> {{ $post['author'] }}</span>
                    <span><i class="bi bi-calendar3"></i>
                        {{ \Carbon\Carbon::parse($post['published_at'])->format('M d, Y') }}</span>
                    <span><i class="bi bi-clock"></i> {{ $post['reading_time'] }} min read</span>
                    <span><i class="bi bi-geo-alt-fill"></i> {{ $post['destination_name'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <details class="blog-mobile-sidebar">
            <summary>
                <span><i class="bi bi-sliders"></i> Blog Filters</span>
                <i class="bi bi-chevron-down"></i>
            </summary>
            <div class="blog-mobile-sidebar-body">
                @include('partials.blog-sidebar')
            </div>
        </details>
    </div>

    <div class="container">
        <div class="blog-content-wrapper">
            <div class="blog-content-main">
                <div class="blog-content">
                    @foreach($post['content_paragraphs'] as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach

                    <div class="blog-highlights">
                        <h3><i class="bi bi-stars"></i> Key Highlights</h3>
                        <ul>
                            @foreach($post['highlights'] as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="blog-facts-grid">
                        @foreach($post['quick_facts'] as $fact)
                            @php
                                // Handle both array of objects and key-value format
                                $factLabel = is_array($fact) ? ($fact['label'] ?? '') : '';
                                $factValue = is_array($fact) ? ($fact['value'] ?? '') : $fact;
                            @endphp
                            @if($factLabel || $factValue)
                                <div class="blog-fact-card"><span class="blog-fact-label">{{ $factLabel }}</span><span
                                        class="blog-fact-value">{{ $factValue }}</span></div>
                            @endif
                        @endforeach
                    </div>

                    <div class="blog-itinerary">
                        <h3>Suggested Itinerary</h3>
                        <div class="itinerary-list">
                            @foreach($post['itinerary'] as $item)
                                @php
                                    // Handle both array of objects and key-value format
                                    $day = is_array($item) ? ($item['day'] ?? '') : $item;
                                    $plan = is_array($item) ? ($item['plan'] ?? '') : '';
                                @endphp
                                @if($day || $plan)
                                    <div class="itinerary-item"><strong>{{ $day }}:</strong> {{ $plan }}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="share-section">
                        <h4>Love this article? Share it with your friends!</h4>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank" class="share-btn share-btn-facebook"><i class="bi bi-facebook"></i>
                                Facebook</a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post['title']) }}"
                                target="_blank" class="share-btn share-btn-twitter"><i class="bi bi-twitter"></i>
                                Twitter</a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post['title']) }}"
                                target="_blank" class="share-btn share-btn-linkedin"><i class="bi bi-linkedin"></i>
                                LinkedIn</a>
                            <a href="https://wa.me/?text={{ urlencode($post['title'] . ' ' . url()->current()) }}"
                                target="_blank" class="share-btn share-btn-whatsapp"><i class="bi bi-whatsapp"></i>
                                WhatsApp</a>
                        </div>
                    </div>

                    <div class="author-box">
                        <div class="author-avatar">{{ substr($post['author'], 0, 1) }}</div>
                        <div class="author-info" >
                            <h4 style="color:white">{{ $post['author'] }}</h4> 
                            <p style="color:white">{{ $post['role'] }}</p>
                        </div>
                    </div>

                    <div class="blog-faq">
                        <h3>Frequently Asked Questions</h3>
                        @foreach($post['faqs'] as $faq)
                            <details class="faq-item">
                                <summary>{{ $faq['question'] }}</summary>
                                <p>{{ $faq['answer'] }}</p>
                            </details>
                        @endforeach
                    </div>

                    @if($destinationBlogs->isNotEmpty())
                        <div class="destination-more">
                            <h3>More From {{ $post['destination_name'] }}</h3>
                            <div class="destination-more-grid">
                                @foreach($destinationBlogs as $destinationPost)
                                    @if($destinationPost['url'] !== $post['url'])
                                        <a href="{{ $destinationPost['url'] }}"
                                            class="destination-more-link">{{ $destinationPost['title'] }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="blog-content-sidebar">@include('partials.blog-sidebar')</div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/blog-filter.js') }}"></script>
    @endpush

    @if($relatedPosts->isNotEmpty())
        <div class="related-posts">
            <div class="container">
                <div class="related-posts-header text-center mb-5">
                    <h3>You Might Also Like</h3>
                    <p>More stories from {{ $post['destination_name'] }} and beyond</p>
                </div>
                <div class="row g-4">
                    @foreach($relatedPosts as $related)
                        <div class="col-md-4">
                            <article class="related-card">
                                <div class="related-card-img-wrap"><img src="{{ $related['image'] }}" alt="{{ $related['title'] }}"
                                        class="related-card-img"></div>
                                <div class="related-card-body">
                                    <span class="related-card-category">{{ $related['category'] }}</span>
                                    <h4 class="related-card-title"><a href="{{ $related['url'] }}">{{ $related['title'] }}</a></h4>
                                    <div class="related-card-meta"><span><i class="bi bi-clock"></i> {{ $related['reading_time'] }}
                                            min</span><span><i class="bi bi-geo-alt"></i> {{ $related['destination_name'] }}</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
