{{-- Dynamic Blog Section for Homepage --}}
@if(isset($blogs) && $blogs->isNotEmpty())
<section class="home-blog-section">
    <div class="container">
        
        <div class="blog-section-header mb-5">
            <span class="blog-section-badge">Travel Insights</span>
            <h2 class="section-title">Stories from the <em>Road</em></h2>
            <p class="section-subtitle">Expert tips, destination guides, and travel inspiration to fuel your next adventure.</p>
        </div>

        <div class="row g-4 mb-4">
            @foreach($blogs->take(3) as $blog)
            <div class="col-md-4">
                <article class="home-blog-card">
                    <a href="{{ $blog['url'] }}" class="blog-card-link">
                        <div class="blog-card-image">
                            <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}">
                            <span class="blog-card-category">{{ $blog['category'] }}</span>
                        </div>
                        <div class="blog-card-content">
                            <h3 class="blog-card-title">{{ Str::limit($blog['title'], 60) }}</h3>
                            <p class="blog-card-excerpt">{{ Str::limit($blog['excerpt'], 100) }}</p>
                            <div class="blog-card-meta">
                                <span><i class="bi bi-clock"></i> {{ $blog['reading_time'] }} min</span>
                                <span><i class="bi bi-geo-alt"></i> {{ $blog['destination_name'] }}</span>
                            </div>
                        </div>
                    </a>
                </article>
            </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('blog.index') }}" class="btn btn-primary btn-lg">
                View All Articles <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<style>
.home-blog-section {
    padding: 80px 0;
    background: #f9fafb;
}

.section-header {
    max-width: 760px;
    margin: 0 auto 56px;
    text-align: left;
}

.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    color: #ff3b30;
    font-size: 1.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 14px;
}

.section-badge::before {
    content: '';
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #ff6a5f;
}

.section-title {
    font-size: clamp(1.4rem, 4.2vw, 3rem);
    font-weight: 900;
    color: #15151a;
    margin-bottom: 8px;
    line-height: 1.08;
}

.section-title em {
    color: #ff3b30;
    font-style: italic;
    font-weight: 800;
}

.section-subtitle {
    font-size: clamp(0.45rem, 1.5vw, 1rem);
    color: #8a8a8a;
    max-width: 760px;
    margin: 0;
    line-height: 1.4;
}

.home-blog-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s;
    height: 100%;
}

.home-blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
}

.blog-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.blog-card-image {
    position: relative;
    overflow: hidden;
    height: 240px;
}

.blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.home-blog-card:hover .blog-card-image img {
    transform: scale(1.1);
}

.blog-card-category {
    position: absolute;
    top: 16px;
    left: 16px;
    padding: 6px 14px;
    background: #ff6271;
    color: white;
    border-radius: 16px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.blog-card-content {
    padding: 24px;
}

.blog-card-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1f2937;
    margin-bottom: 12px;
    line-height: 1.4;
}

.blog-card-link:hover .blog-card-title {
    color: #667eea;
}

.blog-card-excerpt {
    color: #6b7280;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 16px;
}

.blog-card-meta {
    display: flex;
    gap: 16px;
    font-size: 0.85rem;
    color: #9ca3af;
    padding-top: 16px;
    border-top: 1px solid #e5e7eb;
}

.blog-card-meta i {
    color: #667eea;
}

@media (max-width: 767.98px) {
    .section-header {
        text-align: left;
        margin-bottom: 34px;
    }

    .section-badge {
        font-size: 0.82rem;
        margin-bottom: 10px;
    }

    .section-subtitle {
        font-size: 1rem;
    }
}
</style>
@endif
