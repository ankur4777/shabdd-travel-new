{{-- Blog Sidebar Component --}}
<aside class="blog-sidebar">
    @php
        $latestStoriesCollection = collect($latestStories ?? $highlights ?? []);
        $latestStoriesCount = $latestStoriesCollection->count();
    @endphp

    {{-- Search Box --}}
    <div class="sidebar-widget search-widget">
        <h3 class="widget-title">Search Blog</h3>
        <form action="{{ route('blog.index') }}" method="GET" class="search-form">
            <div class="search-input-group">
                <input type="text" name="search" class="search-input" placeholder="Search articles..." value="{{ request('search') }}">
                <button type="submit" class="search-btn">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>


    {{-- Categories --}}
    <div class="sidebar-widget categories-widget">
        <h3 class="widget-title">
            <i class="bi bi-grid"></i> Categories
        </h3>
        <ul class="categories-list">
            <li><a href="{{ route('blog.index') }}" class="category-link {{ !request('category') ? 'active' : '' }}">
                <span>All Posts</span>
                <span class="count">{{ ($allBlogs ?? $blogs)->count() }}</span>
            </a></li>
            @php
                $categories = ($allBlogs ?? $blogs)->pluck('category')->filter()->unique()->sort();
                $activeCategory = trim((string) request('category'));
                $activeDestination = trim((string) request('destination'));
            @endphp
            @foreach($categories as $category)
            <li><a href="{{ route('blog.index', ['category' => $category]) }}" class="category-link {{ $activeCategory === trim((string) $category) ? 'active' : '' }}">
                <span>{{ $category }}</span>
                <span class="count">{{ ($allBlogs ?? $blogs)->where('category', $category)->count() }}</span>
            </a></li>
            @endforeach
        </ul>
    </div>

    {{-- Latest Posts --}}
    @if($latestStoriesCount > 0)
        <div class="sidebar-widget latest-posts-widget">
            <h3 class="widget-title">
                <i class="bi bi-fire"></i> Latest Stories
            </h3>
            <div class="latest-posts-list" data-latest-stories-list>
                @foreach($latestStoriesCollection as $post)
                    <article class="latest-post-item">
                        <a href="{{ $post['url'] }}" class="latest-post-link">
                            <div class="latest-post-img">
                                <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}">
                            </div>
                            <div class="latest-post-content">
                                <span class="latest-post-category">{{ $post['category'] }}</span>
                                <h4 class="latest-post-title">{{ Str::limit($post['title'], 60) }}</h4>
                                <div class="latest-post-meta">
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
    @endif

    <!-- {{-- Destinations --}}
    <div class="sidebar-widget destinations-widget">
        <h3 class="widget-title">
            <i class="bi bi-geo-alt"></i> Destinations
        </h3>
        <div class="destinations-tags">
            @foreach($destinations as $destination)
            <a href="{{ route('blog.index', ['destination' => $destination]) }}" 
               class="destination-tag {{ $activeDestination === trim((string) $destination) ? 'active' : '' }}">
                {{ $destination }}
            </a>
            @endforeach
        </div>
    </div> -->

    {{-- Newsletter --}}
    <div class="sidebar-widget newsletter-widget">
        <div class="newsletter-content">
            <div class="newsletter-icon">
                <i class="bi bi-envelope-heart"></i>
            </div>
            <h3 class="widget-title">Stay Updated</h3>
            <p>Get travel tips & destination guides in your inbox</p>
            <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Newsletter subscription coming soon!');">
                <input type="email" class="newsletter-input" placeholder="Your email" required>
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
        </div>
    </div>

    {{-- Popular Tags --}}
    <div class="sidebar-widget tags-widget">
        <!-- <h3 class="widget-title">
            <i class="bi bi-tags"></i> Popular Tags
        </h3>
        <div class="tags-cloud">
            <a href="#" class="tag-item">Honeymoon</a>
            <a href="#" class="tag-item">Budget Travel</a>
            <a href="#" class="tag-item">Adventure</a>
            <a href="#" class="tag-item">Beach</a>
            <a href="#" class="tag-item">Mountains</a>
            <a href="#" class="tag-item">Luxury</a>
            <a href="#" class="tag-item">Family</a>
            <a href="#" class="tag-item">Solo Travel</a>
            <a href="#" class="tag-item">Food</a>
            <a href="#" class="tag-item">Culture</a>
        </div> -->
    </div>
</aside>

@once
<style>
.blog-sidebar {
    position: sticky;
    top: 100px;
}

.blog-mobile-sidebar {
    display: none;
}

.blog-mobile-sidebar summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 14px 18px;
    list-style: none;
    cursor: pointer;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    color: #1f2937;
    font-weight: 800;
}

.blog-mobile-sidebar summary::-webkit-details-marker {
    display: none;
}

.blog-mobile-sidebar summary span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.blog-mobile-sidebar-body {
    margin-top: 16px;
}

.sidebar-widget {
    background: white;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}

.widget-title {
    font-size: 1.25rem;
    font-weight: 800;
    margin-bottom: 20px;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 8px;
}

.widget-title i {
    color: #667eea;
}

/* Search Widget */
.search-input-group {
    position: relative;
    display: flex;
}

.search-input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.95rem;
    transition: border-color 0.3s;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
}

.search-btn {
    position: absolute;
    right: 4px;
    top: 4px;
    bottom: 4px;
    padding: 0 16px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.search-btn:hover {
    background: #5568d3;
}

/* Latest Posts */
.latest-posts-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    max-height: 460px;
    overflow-y: auto;
    padding-right: 6px;
    scrollbar-width: thin;
    scrollbar-color: #c7d2fe transparent;
}

.latest-posts-list::-webkit-scrollbar {
    width: 6px;
}

.latest-posts-list::-webkit-scrollbar-track {
    background: transparent;
}

.latest-posts-list::-webkit-scrollbar-thumb {
    background: #c7d2fe;
    border-radius: 999px;
}

.latest-post-item {
    border-bottom: 1px solid #f3f4f6;
    padding-bottom: 16px;
}

.latest-post-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.latest-post-link {
    display: flex;
    gap: 12px;
    text-decoration: none;
    color: inherit;
}

.latest-post-img {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    flex-shrink: 0;
}

.latest-post-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.latest-post-link:hover .latest-post-img img {
    transform: scale(1.1);
}

.latest-post-content {
    flex: 1;
}

.latest-post-category {
    display: inline-block;
    font-size: 0.7rem;
    font-weight: 700;
    color: #667eea;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.latest-post-title {
    font-size: 0.9rem;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 6px;
    color: #1f2937;
}

.latest-post-link:hover .latest-post-title {
    color: #667eea;
}

.latest-post-meta {
    display: flex;
    gap: 12px;
    font-size: 0.75rem;
    color: #9ca3af;
}

.latest-post-meta i {
    font-size: 0.7rem;
}

/* Categories */
.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.categories-list li {
    margin-bottom: 8px;
}

.category-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 16px;
    background: #f9fafb;
    border-radius: 10px;
    text-decoration: none;
    color: #4b5563;
    font-weight: 400;
    transition: all 0.3s;
}

.category-link.active {
    background: #667eea;
    color: white;
}

.category-link .count {
    background: white;
    color: #667eea;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 700;
}

.category-link.active .count {
    background: rgba(255,255,255,0.2);
    color: white;
}

/* Destinations */
.destinations-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.destination-tag {
    padding: 8px 16px;
    background: #f3f4f6;
    color: #4b5563;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 400;
    transition: all 0.3s;
}

.destination-tag.active {
    background: #667eea;
    color: white;
}

/* Newsletter */
.newsletter-widget {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.newsletter-widget .widget-title {
    color: white;
    margin-bottom: 8px;
}

.newsletter-icon {
    font-size: 3rem;
    text-align: center;
    margin-bottom: 16px;
    opacity: 0.9;
}

.newsletter-content p {
    font-size: 0.9rem;
    opacity: 0.95;
    margin-bottom: 16px;
    color:white
}

.newsletter-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.newsletter-input {
    padding: 12px 16px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 10px;
    background: rgba(255,255,255,0.1);
    color: white;
    font-size: 0.9rem;
}

.newsletter-input::placeholder {
    color: rgba(255,255,255,0.7);
}

.newsletter-input:focus {
    outline: none;
    border-color: white;
    background: rgba(255,255,255,0.15);
}

.newsletter-btn {
    padding: 12px;
    background: white;
    color: #667eea;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.3s;
}

.newsletter-btn:hover {
    transform: translateY(-2px);
}

/* Tags Cloud */
.tags-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-item {
    padding: 6px 14px;
    background: #f3f4f6;
    color: #6b7280;
    border-radius: 16px;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.3s;
}

.tag-item:hover {
    background: #667eea;
    color: white;
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

.latest-post-mobile-view {
    display: none;
}

@media (max-width: 991px) {
    .blog-mobile-sidebar {
        display: block;
        margin-bottom: 28px;
    }

    .blog-mobile-sidebar .blog-sidebar {
        position: static;
        margin-top: 0;
    }

    .blog-mobile-sidebar .sidebar-widget {
        margin-bottom: 16px;
    }

    .blog-sidebar {
        position: static;
        margin-top: 40px;
    }

    .latest-post-mobile-view {
        display: block;
    }
}
</style>
@endonce
