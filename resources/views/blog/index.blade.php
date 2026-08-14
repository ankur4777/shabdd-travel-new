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
.filter-section {
    margin-bottom: 20px;
}
.filter-section:last-child {
    margin-bottom: 0;
}
.filter-label {
    font-size: 0.85rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.filter-btn {
    padding: 10px 24px;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 24px;
    margin: 5px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
    font-size: 0.9rem;
}
.filter-btn:hover, .filter-btn.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
    transform: translateY(-2px);
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
    .blog-main-content {
        flex-direction: column;
    }
    .blog-sidebar-area {
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
                    <span class="blog-stat-num">{{ $destinations->count() }}</span>
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
            <div class="filter-label">
                <i class="bi bi-geo-alt-fill"></i> Filter by Destination
            </div>
            <div class="d-flex flex-wrap justify-content-center align-items-center">
                <button class="filter-btn {{ !request('destination') ? 'active' : '' }}" data-filter="all" data-type="destination">All Destinations</button>
                @foreach($destinations as $destination)
                    <button class="filter-btn {{ request('destination') == $destination ? 'active' : '' }}" data-filter="{{ $destination }}" data-type="destination">{{ $destination }}</button>
                @endforeach
            </div>
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
            @if($featured && !request('destination'))
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
                                    <span><i class="bi bi-clock"></i> {{ $featured['reading_time'] }} min read</span>
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
                @forelse($blogs as $blog)
                <div class="col-md-6 blog-item" data-destination="{{ $blog['destination_name'] }}" data-category="{{ $blog['category'] }}">
                    <article class="blog-card">
                        <div class="blog-card-img-wrap">
                            <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}" class="blog-card-img">
                        </div>
                        <div class="blog-card-body">
                            <span class="blog-category">{{ $blog['category'] }}</span>
                            <h3 class="blog-title">
                                <a href="{{ $blog['url'] }}">{{ $blog['title'] }}</a>
                            </h3>
                            <p class="blog-excerpt">{{ Str::limit($blog['excerpt'], 120) }}</p>
                            <div class="blog-meta">
                                <span><i class="bi bi-clock"></i> {{ $blog['reading_time'] }} min</span>
                                <span><i class="bi bi-geo-alt"></i> {{ $blog['destination_name'] }}</span>
                            </div>
                        </div>
                    </article>
                </div>
                @empty
                <div class="col-12">
                    <div class="no-results">
                        <div class="no-results-icon"><i class="bi bi-search"></i></div>
                        <h3>No articles found</h3>
                        <p>Try adjusting your filters to find more content</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <div class="blog-sidebar-area">
            @include('partials.blog-sidebar')
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/blog-filter.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const blogItems = document.querySelectorAll('.blog-item');
    const featuredPost = document.getElementById('featuredPost');
    const allBlogs = @json($blogs);

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            const type = this.dataset.type;
            
            // Update active state
            document.querySelectorAll(`.filter-btn[data-type="${type}"]`).forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Filter blog items
            let visibleCount = 0;
            blogItems.forEach(item => {
                const destination = item.dataset.destination;
                const category = item.dataset.category;
                let show = true;

                if (filter !== 'all') {
                    if (type === 'destination' && destination !== filter) {
                        show = false;
                    }
                }

                if (show) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Update featured post based on filter
            if (featuredPost) {
                if (filter === 'all') {
                    featuredPost.style.display = 'block';
                } else {
                    // Find featured post for selected destination
                    const filteredBlogs = allBlogs.filter(blog => blog.destination_name === filter);
                    if (filteredBlogs.length > 0) {
                        const newFeatured = filteredBlogs[0];
                        updateFeaturedPost(newFeatured);
                        featuredPost.style.display = 'block';
                    } else {
                        featuredPost.style.display = 'none';
                    }
                }
            }
        });
    });

    function updateFeaturedPost(blog) {
        if (!featuredPost) return;
        
        featuredPost.querySelector('.featured-img').src = blog.image;
        featuredPost.querySelector('.featured-img').alt = blog.title;
        featuredPost.querySelector('.featured-title').textContent = blog.title;
        featuredPost.querySelector('.featured-excerpt').textContent = blog.excerpt;
        featuredPost.querySelector('.blog-meta span:nth-child(1)').innerHTML = `<i class="bi bi-clock"></i> ${blog.reading_time} min read`;
        featuredPost.querySelector('.blog-meta span:nth-child(2)').innerHTML = `<i class="bi bi-calendar3"></i> ${blog.published_at_display || blog.published_at}`;
        featuredPost.querySelector('.blog-meta span:nth-child(3)').innerHTML = `<i class="bi bi-geo-alt"></i> ${blog.destination_name}`;
        featuredPost.querySelector('.btn').href = blog.url;
    }
});
</script>
@endpush
@endsection
