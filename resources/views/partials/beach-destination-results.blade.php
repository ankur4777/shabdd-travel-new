@if($beachDestinations->isEmpty())
    <div class="beach-empty">
        <h3>No beach destinations match your filters</h3>
        <p>Try a different destination, budget, duration, or travel style to see more beach options.</p>
    </div>
@else
    <div class="beach-destination-grid">
        @foreach($beachDestinations as $destination)
            @php
                $destinationTripType = \Illuminate\Support\Str::lower(trim((string) ($destination['country'] ?? ''))) !== 'india'
                    ? 'International'
                    : 'Domestic';
                $destinationStyles = collect($destination['travel_styles'] ?? [])->take(3)->values();
            @endphp
            <article class="beach-destination-card beach-destination-card--grid">
                <div class="beach-destination-card__media" style="background-image: url('{{ $destination['image'] }}');">
                </div>
                <div class="beach-destination-card__body">
                    <div class="beach-destination-card__top">
                        <div>
                            <p>{{ $destination['country'] ?? 'India' }}</p>
                            <h3>{{ $destination['name'] }}</h3>
                        </div>

                    </div>
                    <p>{{ $destination['description'] }}</p>
                    <div class="beach-destination-card__meta">
                        <span><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $destination['duration'] }}</span>
                        <span><i class="bi bi-star-fill" aria-hidden="true"></i>
                            {{ $destination['rating'] ? number_format((float) $destination['rating'], 1) : 'New' }}</span>
                    </div>
                    @if($destinationStyles->isNotEmpty())
                        <div class="beach-destination-card__styles">
                            @foreach($destinationStyles as $style)
                                <span>{{ $style }}</span>
                            @endforeach
                        </div>
                        <div class="price">
                            <strong>{{ $destination['price_from'] ? 'Starts From ₹' . number_format((int) $destination['price_from']) : '' }}</strong>
                        </div>
                    @endif

                    <a href="{{ $destination['url'] }}" class="beach-destination-card__cta">
                        View details <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>
        @endforeach
    </div>
@endif