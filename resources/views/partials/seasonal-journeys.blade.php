@php
    use App\Models\Destination;
    use App\Support\MediaUrl;

    $journeys = $seasonalJourneyDestinations ?? Destination::query()
        ->active()
        ->seasonalJourney()
        ->orderByDesc('is_trending')
        ->orderByDesc('rating')
        ->orderBy('name')
        ->get();

    $makeUrl = function ($item) {
        $slug = data_get($item, 'slug');

        return $slug && $slug !== '#'
            ? route('destinations.show', ['destination' => $slug])
            : '#';
    };
@endphp

<div class="sj-grid">
    @foreach($journeys as $index => $journey)
        @php
            $classes = ['sj-card'];
            if ($index === 0)
                $classes[] = 'sj-card--wide-left';
            if ($index === 1)
                $classes[] = 'sj-card--tall-center';
            if ($index === 2)
                $classes[] = 'sj-card--wide-right';
            if ($index >= 3 && $index <= 4)
                $classes[] = 'sj-card--bottom-sm';
            if ($index === 5)
                $classes[] = 'sj-card--bottom-right';

            $name = data_get($journey, 'name', data_get($journey, 'title', 'Seasonal Journey'));
            $price = data_get($journey, 'price_text');

            if (!$price) {
                $priceFrom = (int) data_get($journey, 'price_from', 0);
                $price = $priceFrom > 0 ? 'Start From Rs. ' . number_format($priceFrom) : 'On Request';
            }

            $img = data_get($journey, 'image_url') ?: data_get($journey, 'hero_image');

            if ($journey instanceof Destination) {
                $img = MediaUrl::asset($img);
            }
        @endphp

        <a href="{{ $makeUrl($journey) }}" class="{{ implode(' ', $classes) }}">
            <img src="{{ $img ?: asset('images/himachal.jpg') }}" alt="{{ $name }}" class="sj-card__img"
                width="360"
                height="480"
                loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
                decoding="async">
            <div class="sj-card__overlay"></div>
            <div class="sj-card__content">
                <h3 class="sj-card__name">{{ $name }}</h3>
                <p class="sj-card__price">{{ $price }}</p>
            </div>
        </a>
    @endforeach

</div>
