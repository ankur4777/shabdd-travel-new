@php
    $currentSort = request('sort', 'newest');
    $currentRating = request('rating');
    $currentDuration = request('duration');
    $currentTravelStyle = request('travel_style');
    $priceMin = (int) ($priceBounds['min'] ?? 0);
    $priceMax = (int) ($priceBounds['max'] ?? 0);
@endphp

<div class="pkg-filter-panel-head">
    <span>Smart Filters</span>
    <h3>Find destinations</h3>
    <p>Filter package-backed destination cards by place, budget, rating, and duration.</p>
</div>

<div class="pkg-filter-group">
    <label for="{{ $fieldPrefix }}Destination">All Destinations</label>
    <select id="{{ $fieldPrefix }}Destination" name="destination" class="form-select" data-package-auto-submit>
        <option value="">All Destinations</option>
        @foreach($destinationOptions as $destination)
            <option value="{{ $destination['slug'] }}" {{ request('destination') === $destination['slug'] ? 'selected' : '' }}>
                {{ $destination['name'] }}{{ $destination['country'] ? ' - ' . $destination['country'] : '' }}
            </option>
        @endforeach
    </select>
</div>

<div class="pkg-filter-group">
    <label for="{{ $fieldPrefix }}TravelStyle">Travel Style</label>
    <select id="{{ $fieldPrefix }}TravelStyle" name="travel_style" class="form-select" data-package-auto-submit>
        <option value="">All Travel Styles</option>
        @foreach($travelStyleOptions as $value => $label)
            <option value="{{ $value }}" {{ $currentTravelStyle === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>

<div class="pkg-filter-group">
    <div class="pkg-filter-label-row">
        <label>Price Range</label>
        <strong>
            <span data-package-price-min-label>{{ '₹' . number_format($selectedMinPrice) }}</span>
            -
            <span data-package-price-max-label>{{ '₹' . number_format($selectedMaxPrice) }}</span>
        </strong>
    </div>

    <div class="pkg-range-slider" data-package-range data-min="{{ $priceMin }}" data-max="{{ $priceMax }}">
        <div class="pkg-range-track">
            <span data-package-range-progress></span>
        </div>
        <input
            type="range"
            name="min_price"
            min="{{ $priceMin }}"
            max="{{ $priceMax }}"
            step="1000"
            value="{{ $selectedMinPrice }}"
            aria-label="Minimum price"
            data-package-range-min
        >
        <input
            type="range"
            name="max_price"
            min="{{ $priceMin }}"
            max="{{ $priceMax }}"
            step="1000"
            value="{{ $selectedMaxPrice }}"
            aria-label="Maximum price"
            data-package-range-max
        >
    </div>

    <div class="pkg-price-boundaries">
        <span>{{ '₹' . number_format($priceMin) }}</span>
        <span>{{ '₹' . number_format($priceMax) }}</span>
    </div>
</div>

<div class="pkg-filter-group">
    <label>Rating</label>
    <div class="pkg-segment-list">
        <label class="pkg-segment-option">
            <input type="radio" name="rating" value="" {{ blank($currentRating) ? 'checked' : '' }} data-package-auto-submit>
            <span>Any Rating</span>
        </label>
        <label class="pkg-segment-option">
            <input type="radio" name="rating" value="5" {{ $currentRating === '5' ? 'checked' : '' }} data-package-auto-submit>
            <span>5 Star</span>
        </label>
        <label class="pkg-segment-option">
            <input type="radio" name="rating" value="4" {{ $currentRating === '4' ? 'checked' : '' }} data-package-auto-submit>
            <span>4+ Rating</span>
        </label>
        <label class="pkg-segment-option">
            <input type="radio" name="rating" value="3" {{ $currentRating === '3' ? 'checked' : '' }} data-package-auto-submit>
            <span>3+ Rating</span>
        </label>
    </div>
</div>

<div class="pkg-filter-group">
    <label>Duration</label>
    <div class="pkg-segment-list">
        <label class="pkg-segment-option">
            <input type="radio" name="duration" value="" {{ blank($currentDuration) ? 'checked' : '' }} data-package-auto-submit>
            <span>Any Duration</span>
        </label>
        <label class="pkg-segment-option">
            <input type="radio" name="duration" value="1-3" {{ $currentDuration === '1-3' ? 'checked' : '' }} data-package-auto-submit>
            <span>1-3 Days</span>
        </label>
        <label class="pkg-segment-option">
            <input type="radio" name="duration" value="4-6" {{ $currentDuration === '4-6' ? 'checked' : '' }} data-package-auto-submit>
            <span>4-6 Days</span>
        </label>
        <label class="pkg-segment-option">
            <input type="radio" name="duration" value="7-plus" {{ $currentDuration === '7-plus' ? 'checked' : '' }} data-package-auto-submit>
            <span>7+ Days</span>
        </label>
    </div>
</div>

<div class="pkg-filter-group">
    <label for="{{ $fieldPrefix }}Sort">Sort By</label>
    <select id="{{ $fieldPrefix }}Sort" name="sort" class="form-select" data-package-auto-submit>
        <option value="newest" {{ $currentSort === 'newest' ? 'selected' : '' }}>Newest First</option>
        <option value="low_to_high" {{ $currentSort === 'low_to_high' ? 'selected' : '' }}>Price Low to High</option>
        <option value="high_to_low" {{ $currentSort === 'high_to_low' ? 'selected' : '' }}>Price High to Low</option>
        <option value="highest_rated" {{ $currentSort === 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
        <option value="most_popular" {{ $currentSort === 'most_popular' ? 'selected' : '' }}>Most Popular</option>
    </select>
</div>

<div class="pkg-filter-actions">
    <button type="submit" class="pkg-apply-btn">
        Apply Filters
    </button>
    <a href="{{ route('destinations.index') }}" class="pkg-clear-btn">
        Clear Filters
    </a>
</div>
