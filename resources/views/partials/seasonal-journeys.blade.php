@php
    use App\Models\SeasonalJourney;

    $journeys = SeasonalJourney::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    if ($journeys->isEmpty()) {
        $journeys = collect([
            (object) [
                'title' => 'ANDAMAN',
                'price_text' => 'Start From ₹ 14,999',
                'image_url' => asset('images/dubai.jpg'),
                'slug'
                => '#'
            ],
            (object) [
                'title' => 'EUROPE',
                'price_text' => 'Start From ₹ 69,089',
                'image_url' => asset('images/himachal.jpg'),
                'slug' => '#'
            ],
            (object) [
                'title' => 'MAURITIUS',
                'price_text' => 'Start From ₹ 26,999',
                'image_url' => asset('images/himachal.jpg'),
                'slug' => '#'
            ],
            (object) [
                'title' => 'HIMACHAL PRADESH',
                'price_text' => 'Start From ₹ 9,999',
                'image_url' =>
                    asset('images/himachal.jpg'),
                'slug' => '#'
            ],
            (object) [
                'title' => 'KERALA',
                'price_text' => 'Start From ₹ 9,999',
                'image_url' => asset('images/kerala.avif'),
                'slug'
                => '#'
            ],
            (object) [
                'title' => 'MALAYSIA',
                'price_text' => 'Start From ₹ 21,999',
                'image_url' => asset('images/himachal.jpg'),
                'slug' => '#'
            ],
        ]);
    }

    $makeUrl = function ($item) {
        $slug = data_get($item, 'slug');

        return $slug && $slug !== '#'
            ? route('seasonal-journeys.show', ['slug' => $slug])
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
                $classes[] = 'sj-card--bottom-right'
                ;
            $img = $journey->image_url ?? ($journey->image ?? ($journey->image_url ?? null));
            if (is_object($journey) && property_exists($journey, 'image_url')) {
                $img = $journey->image_url;
            }

            // Support model accessor
            if (method_exists($journey, 'getImageUrlAttribute')) {
                $img = $journey->image_url;
            }
        @endphp

        <a href="{{ $makeUrl($journey) }}" class="{{ implode(' ', $classes) }}">
            <img src="{{ $img ?: asset('images/himachal.jpg') }}" alt="{{ $journey->title }}" class="sj-card__img"
                width="360"
                height="480"
                loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
                decoding="async">
            <div class="sj-card__overlay"></div>
            <div class="sj-card__content">
                <h3 class="sj-card__name">{{ $journey->title }}</h3>
                <p class="sj-card__price">{{ $journey->price_text }}</p>
            </div>
        </a>
    @endforeach

</div>
