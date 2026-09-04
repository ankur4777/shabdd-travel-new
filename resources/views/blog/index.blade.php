@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/blog-filter.css') }}">
<style>
.blog-hero {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 100px 0 80px;
    color: white;
    overflow: hidden;
}
.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>');
    opacity: 0.3;
}
.blog-hero-content {
    position: relative;
    z-index: 1;
}
.blog-hero h1 {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 1rem;
    text-shadow: 0 2px 20px rgba(0,0,0,0.2);
    color:white
}
.blog-hero p {
    font-size: 1.3rem;
    opacity: 0.95;
    max-width: 600px;
    margin: 0 auto;
    color:white
}
.blog-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 30px;
}
.blog-stat {
    text-align: center;
}
.blog-stat-num {
    display: block;
    font-size: 2rem;
    font-weight: 800;
}
.blog-stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}
.blog-filters {
    background: white;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin: -40px 0 40px;
    position: relative;
    z-index: 10;
}
.blog-mobile-toolbar {
    display: none;
    background: linear-gradient(180deg, rgba(255,255,255,0.96) 0%, rgba(248,250,252,0.98) 100%);
    border: 1px solid rgba(229,231,235,0.9);
    border-radius: 22px;
    padding: 16px;
    margin: -28px 0 24px;
    box-shadow: 0 14px 36px rgba(17,24,39,0.08);
    position: relative;
    z-index: 12;
    backdrop-filter: blur(10px);
}
.blog-mobile-toolbar__top {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 14px;
}
.blog-mobile-toolbar__top--split {
    justify-content: space-between;
}
.blog-mobile-toolbar__label {
    min-width: 160px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #475569;
    font-size: clamp(0.76rem, 0.75vw, 0.9rem);
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    white-space: nowrap;
}
.blog-mobile-search {
    flex: 1;
}
.blog-mobile-search .search-form {
    margin: 0;
}
.blog-mobile-search .search-input-group {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.5px solid #dbe3ff;
    border-radius: 16px;
    padding: 4px;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.08);
}
.blog-mobile-search .search-input {
    border: 0;
    background: transparent;
    padding: 12px 14px;
    min-width: 0;
    flex: 1;
    box-shadow: none;
}
.blog-mobile-search .search-input:focus {
    border: 0;
    outline: none;
}
.blog-mobile-search .search-btn {
    position: static;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    flex-shrink: 0;
}
.filter-section__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}
.clear-filters-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border: 1px solid #dbe3ff;
    background: #f8fbff;
    color: #667eea;
    padding: clamp(7px, 1vw, 10px) clamp(10px, 1.4vw, 14px);
    border-radius: 12px;
    font-size: clamp(0.74rem, 0.7vw, 0.86rem);
    font-weight: 800;
    white-space: nowrap;
    transition: all 0.25s ease;
}
.clear-filters-btn:hover {
    background: #667eea;
    color: #fff;
    transform: translateY(-1px);
}
.clear-filters-btn.is-hidden {
    display: none;
}
.blog-mobile-toolbar__chips {
    display: flex;
    flex-wrap: nowrap;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 4px;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.blog-mobile-toolbar__chips::-webkit-scrollbar {
    display: none;
}
.blog-mobile-toolbar .destination-tag {
    flex: 0 0 auto;
    white-space: nowrap;
    padding: 10px 16px;
    border: 1px solid #e5e7eb;
    background: #fff;
}
.filter-section {
    margin-bottom: 20px;
}
.filter-section:last-child {
    margin-bottom: 0;
}
.filter-label {
    font-size: clamp(0.78rem, 0.8vw, 0.9rem);
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    margin-bottom: clamp(10px, 1vw, 12px);
    display: flex;
    align-items: center;
    gap: 8px;
}
.filter-btn {
   
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 10px;
    margin: 5px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 400;
    

}
.filter-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}
.blog-main-content {
    display: flex;
    gap: 40px;
    margin-bottom: 60px;
}
.blog-posts-area {
    flex: 1;
}
.blog-sidebar-area {
    width: 350px;
    flex-shrink: 0;
}
.blog-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    height: 100%;
}
.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}
.blog-card-img-wrap {
    position: relative;
    overflow: hidden;
}
.blog-card-img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    transition: transform 0.5s;
}
.blog-card:hover .blog-card-img {
    transform: scale(1.1);
}
.blog-card-body {
    padding: 28px;
}
.blog-category {
    display: inline-block;
    padding: 6px 14px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 16px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-bottom: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.blog-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 14px;
    color: #1f2937;
    line-height: 1.4;
}
.blog-title a {
    color: inherit;
    text-decoration: none;
}
.blog-title a:hover {
    color: #667eea;
}
.blog-excerpt {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 18px;
}
.blog-meta {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 0.85rem;
    color: #9ca3af;
    padding-top: 18px;
    border-top: 1px solid #e5e7eb;
}
.blog-meta i {
    color: #667eea;
}
.featured-actions {
    display: flex;
    flex-direction:column;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-top: auto;
    padding-top: 18px;
    border-top: 1px solid #e5e7eb;
    flex-wrap: nowrap;
}
.featured-cta {
    flex: 0 0 auto;
    white-space: nowrap;
}
.featured-meta {
    margin-top: 0;
    padding-top: 0;
    border-top: 0;
    flex: 1 1 auto;
    justify-content: flex-end;
    flex-wrap: nowrap;
    min-width: 0;
    gap: 12px;
    overflow: hidden;
}
.featured-meta span {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}
.featured-post {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.12);
    margin-bottom: 60px;
    transition: transform 0.3s;
}
.featured-post:hover {
    transform: translateY(-4px);
}
.featured-img-wrap {
    position: relative;
    overflow: hidden;
}
.featured-img {
    width: 100%;
    height: 611px;
    object-fit: cover;
    transition: transform 0.5s;
}
.featured-post:hover .featured-img {
    transform: scale(1.05);
}
.featured-row {
    align-items: stretch;
}
.featured-row > [class*="col-"] {
    display: flex;
}
.featured-content {
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 42px 46px 36px;
}
.featured-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #78350f;
    border-radius: 24px;
    font-size: 0.85rem;
    font-weight: 800;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.featured-badge i {
    font-size: 1rem;
}
.featured-title {
    font-size: clamp(2.1rem, 3vw, 2.9rem);
    font-weight: 900;
    margin-bottom: 18px;
    color: #1f2937;
    line-height: 1.2;
}
.featured-excerpt {
    font-size: 1.02rem;
    color: #6b7280;
    line-height: 1.75;
    margin-bottom: 0;
}
.blog-grid-footer {
    margin-top: 18px;
    display: flex;
    justify-content: center;
}
.blog-load-more-btn {
    min-width: 180px;
    padding: 12px 22px;
    border: 1px solid #667eea;
    border-radius: 14px;
    background: #fff;
    color: #667eea;
    font-weight: 800;
    transition: all 0.3s ease;
}
.blog-load-more-btn:hover {
    background: #667eea;
    color: #fff;
    transform: translateY(-2px);
}
.blog-grid-footer.is-hidden {
    display: none;
}
.latest-posts-list.is-collapsed .latest-post-item:nth-child(n+5) {
    display: none;
}
.latest-posts-footer {
    margin-top: 10px;
    display: flex;
    justify-content: center;
}
.latest-posts-toggle-btn {
    width: 100%;
    padding: 10px 16px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #f9fafb;
    color: #667eea;
    font-weight: 800;
    transition: all 0.3s ease;
}
.latest-posts-toggle-btn:hover {
    background: #667eea;
    color: #fff;
    transform: translateY(-1px);
}
.latest-post-mobile-view{
    display:none;
}
.no-results {
    text-align: center;
    padding: 80px 20px;
}
.no-results-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 20px;
}
.no-results h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4b5563;
    margin-bottom: 12px;
}
.no-results p {
    color: #9ca3af;
}
@media (max-width: 991px) {
    .blog-filters {
        display: none;
    }
    .blog-mobile-toolbar {
        display: block;
    }
    .blog-main-content {
        flex-direction: column;
    }
    .blog-sidebar-area {
        display: none;
    }
    .blog-mobile-sidebar {
        display: none;
    }
    .blog-hero h1 {
        font-size: 2.5rem;
    }
    .featured-title {
        font-size: 2rem;
    }
    .featured-content {
        padding: 34px 34px 30px;
    }
    .featured-actions {
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .featured-cta,
    .featured-meta {
        width: 100%;
    }
    .featured-meta {
        justify-content: flex-start;
        overflow: visible;
        flex-wrap: wrap;
    }
    .featured-title {
        font-size: 2rem;
    }
    .blog-grid-footer {
        margin-top: 14px;
    }

    .latest-post-mobile-view{
        display: block;
    }
}
@media (max-width: 575px) {
    .blog-mobile-toolbar {
        margin-top: -18px;
        padding: 14px;
        border-radius: 18px;
    }
    .blog-mobile-toolbar__top {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    .blog-mobile-toolbar__top--split {
        flex-direction: row;
        align-items: center;
        gap: 10px;
    }
    .blog-mobile-toolbar__label {
        min-width: 0;
    }
    .clear-filters-btn {
       padding: clamp(0px, 1vw, 9px) clamp(3px, 1vw, 12px);
        font-size: clamp(0.72rem, 2.4vw, 0.8rem);
    }
    .filter-section__header {
        align-items: flex-start;
    }
    .blog-mobile-toolbar .filter-btn,
    .blog-mobile-toolbar .destination-tag {
        font-size: 0.76rem;
        line-height: 1.1;
        padding: 8px 12px;
        border-radius: 16px;
    }
    .blog-mobile-toolbar .filter-btn {
        white-space: nowrap;
    }
    .blog-mobile-toolbar .destination-tag {
        max-width: 92px;
    }
    .blog-mobile-search .search-input {
        font-size: 0.92rem;
    }
    .blog-load-more-btn {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
<div class="blog-hero">
    <div class="container text-center">
        <div class="blog-hero-content">
            <h1>Travel Stories & Guides</h1>
            <p>Discover inspiring travel stories, destination guides, and expert tips from around the world</p>
            <div class="blog-stats">
                <div class="blog-stat">
                    <span class="blog-stat-num">{{ $blogs->count() }}+</span>
                    <span class="blog-stat-label">Articles</span>
                </div>
                <div class="blog-stat">
                    <span class="blog-stat-num">{{ $blogDestinations->count() }}</span>
                    <span class="blog-stat-label">Destinations</span>
                </div>
                <div class="blog-stat">
                    <span class="blog-stat-num">10K+</span>
                    <span class="blog-stat-label">Readers</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="blog-filters">
        <div class="filter-section">
            <div class="filter-section__header">
                <div class="filter-label">
                    <i class="bi bi-geo-alt-fill"></i> Filter by Destination
                </div>
                <button type="button" class="clear-filters-btn" data-clear-filters>
                    <i class="bi bi-x-circle"></i> Clear All
                </button>
            </div>
            <div class="d-flex flex-wrap justify-content-center align-items-center">
                <button class="filter-btn {{ !trim((string) request('destination')) ? 'active' : '' }}" data-filter="all" data-type="destination">All Destinations</button>
                @foreach($blogDestinations as $destinationName)
                    <button class="filter-btn {{ trim((string) request('destination')) === trim((string) $destinationName) ? 'active' : '' }}" data-filter="{{ $destinationName }}" data-type="destination">{{ $destinationName }}</button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="blog-mobile-toolbar">
        <div class="blog-mobile-toolbar__top blog-mobile-toolbar__top--split">
            <div class="blog-mobile-toolbar__label">
                <i class="bi bi-geo-alt-fill"></i> Filter by Destination
            </div>
            <button type="button" class="clear-filters-btn" data-clear-filters>
                <i class="bi bi-x-circle"></i> Clear All
            </button>
        </div>
        <div class="blog-mobile-toolbar__top">
            <div class="blog-mobile-search">
                <form action="{{ route('blog.index') }}" method="GET" class="search-form">
                    @if(request('destination'))
                        <input type="hidden" name="destination" value="{{ request('destination') }}">
                    @endif
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="search-input-group">
                        <input type="text" name="search" class="search-input" placeholder="Search articles..." value="{{ request('search') }}">
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="blog-mobile-toolbar__chips" aria-label="Destination filters">
            <button class="filter-btn {{ !trim((string) request('destination')) ? 'active' : '' }}" data-filter="all" data-type="destination">All Destinations</button>
            @foreach($blogDestinations as $destinationName)
                <button class="filter-btn {{ trim((string) request('destination')) === trim((string) $destinationName) ? 'active' : '' }}" data-filter="{{ $destinationName }}" data-type="destination">{{ $destinationName }}</button>
            @endforeach
        </div>
    </div>

    <details class="blog-mobile-sidebar">
        <summary>
            <span><i class="bi bi-sliders"></i> Blog Filters</span>
            <i class="bi bi-chevron-down"></i>
        </summary>
        <div class="blog-mobile-sidebar-body">
            @include('partials.blog-sidebar')
        </div>
    </details>

    <div class="blog-main-content">
        <div class="blog-posts-area">
            @if($featured && !trim((string) request('destination')))
            <div class="featured-post" id="featuredPost">
                <div class="row g-0 featured-row">
                    <div class="col-lg-5">
                        <div class="featured-img-wrap">
                            <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}" class="featured-img">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="featured-content">
                            <span class="featured-badge">
                                <i class="bi bi-star-fill"></i> Featured Story
                            </span>
                            <h2 class="featured-title">{{ $featured['title'] }}</h2>
                            <p class="featured-excerpt">{{ $featured['excerpt'] }}</p>
                            <div class="featured-actions">
                                <a href="{{ $featured['url'] }}" class="btn btn-primary btn-lg featured-cta">Read Full Story <i class="bi bi-arrow-right"></i></a>
                                <div class="blog-meta featured-meta">
                                    <!-- <span><i class="bi bi-clock"></i> {{ $featured['reading_time'] }} min read</span> -->
                                    <span><i class="bi bi-calendar3"></i> {{ $featured['published_at_display'] ?? \Carbon\Carbon::parse($featured['published_at'])->format('M d, Y') }}</span>
                                    <span><i class="bi bi-geo-alt"></i> {{ $featured['destination_name'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row g-4" id="blogGrid">
                @foreach($blogs as $index => $blog)

                <div class="col-md-6 blog-item" data-destination="{{ $blog['destination_name'] }}" data-category="{{ $blog['category'] }}" @if($index >= 6) style="display:none;" @endif>
                    <article class="blog-card">
                        <div class="blog-card-img-wrap">
                            <img src="{{ $blog['image'] }}" alt="{{ $featured['image_alt_text'] }}" class="blog-card-img">
                        </div>
                        <div class="blog-card-body">
                            <span class="blog-category">{{ $blog['category'] }}</span>
                            <h3 class="blog-title">
                                <a href="{{ $blog['url'] }}">{{ $blog['title'] }}</a>
                            </h3>
                            <p class="blog-excerpt">{{ Str::limit($blog['excerpt'], 120) }}</p>
                            <div class="blog-meta">
                                <!-- <span><i class="bi bi-clock"></i> {{ $blog['reading_time'] }} min</span> -->
                                <span><i class="bi bi-geo-alt"></i> {{ $blog['destination_name'] }}</span>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
            @if($blogs->count() > 6)
                <div class="blog-grid-footer" data-blog-load-more-wrap>
                    <button type="button" class="blog-load-more-btn" data-blog-load-more>
                        See More
                    </button>
                </div>
            @endif

            
    {{-- Latest Posts --}}
    @php
        $latestStoriesCollection = collect($latestStories ?? $highlights ?? []);
        $latestStoriesCount = $latestStoriesCollection->count();
    @endphp
    <div class="sidebar-widget latest-posts-widget latest-post-mobile-view">
        <h3 class="widget-title">
            <i class="bi bi-fire"></i> Latest Stories
        </h3>
        <div class="latest-posts-list" data-latest-stories-list>
            @foreach($latestStoriesCollection as $post)
            <article class="latest-post-item">
                <a href="{{ $post['url'] }}" class="latest-post-link">
                    <div class="latest-post-img">
                        <img src="{{ $post['image'] }}" alt="{{ $featured['image_alt_text'] }}">
                    </div>
                    <div class="latest-post-content">
                        <span class="latest-post-category">{{ $post['category'] }}</span>
                        <h4 class="latest-post-title">{{ Str::limit($post['title'], 60) }}</h4>
                        <div class="latest-post-meta">
                            <!-- <span><i class="bi bi-clock"></i> {{ $post['reading_time'] }} min</span> -->
                            <span><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($post['published_at'])->format('M d') }}</span>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        
        @if($latestStoriesCount > 4)
            <div class="latest-posts-footer">
                <button type="button" class="latest-posts-toggle-btn" data-latest-stories-toggle>
                    Show more stories
                </button>
            </div>
        @endif
    </div>


        </div>
        

        
        <div class="blog-sidebar-area">
            @include('partials.blog-sidebar')
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/blog-filter.js') }}"></script>
@endpush
@endsection
