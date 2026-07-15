<?php

namespace App\Http\Controllers;

use App\Support\InternationalJourneyPackages;
use Illuminate\View\View;

class PremiumJourneyController extends Controller
{
    public function show(string $slug): View
    {
        $journeys = $this->journeys();
        abort_unless(isset($journeys[$slug]), 404);

        $views = [
            'europe-signature-circuits' => 'international-tours.premium.europe-signature-circuits',
            'swiss-alpine-luxury' => 'international-tours.premium.swiss-alpine-luxury',
            'japan-seasonal-trails' => 'international-tours.premium.japan-seasonal-trails',
            'turkey-and-greece' => 'international-tours.premium.turkey-and-greece',
        ];

        return view($views[$slug], [
            'journey' => $journeys[$slug],
            'journeySlug' => $slug,
            'journeyPackages' => InternationalJourneyPackages::forJourney($journeys[$slug]),
            'premiumJourneys' => collect($journeys),
        ]);
    }

    private function journeys(): array
    {
        return [
            'europe-signature-circuits' => $this->journey(
                name: 'Europe Signature Circuits',
                shortName: 'Europe',
                packageTerms: ['Europe', 'France', 'Switzerland', 'Italy', 'Paris', 'Lucerne', 'Interlaken', 'Venice', 'Florence', 'Rome'],
                countries: 'France · Switzerland · Italy',
                eyebrow: 'Three countries, one considered route',
                headline: 'Europe deserves better than a blur through coach windows.',
                dek: 'Paris mornings, Swiss rail days and Italian evenings—connected with enough breathing room to remember where one chapter ended and the next began.',
                hero: 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=2000&q=88',
                accent: '#7b263a',
                price: 289000,
                duration: '12 nights',
                season: 'Apr–Jun · Sep–Oct',
                route: ['Paris', 'Lucerne', 'Interlaken', 'Venice', 'Florence', 'Rome'],
                routeNotes: [
                    ['city' => 'Paris', 'days' => '3 nights', 'note' => 'Left Bank mornings, one museum chosen well, and a Seine evening after the day crowds thin.'],
                    ['city' => 'Swiss Alps', 'days' => '4 nights', 'note' => 'Lakeside Lucerne followed by mountain rail days from Interlaken—no rushed bus crossings.'],
                    ['city' => 'Italy', 'days' => '5 nights', 'note' => 'Arrive in Venice by rail, move through Florence, and give Rome two complete days.'],
                ],
                philosophyTitle: 'The case for fewer borders.',
                philosophy: 'A premium European circuit is not measured by how many capitals fit on the brochure. It is measured by how often you can unpack, walk to dinner and understand the place beyond its landmark photograph.',
                details: [
                    ['label' => 'The pace', 'value' => '2–3 nights per base'],
                    ['label' => 'How you move', 'value' => 'First-class rail + private transfers'],
                    ['label' => 'Stay character', 'value' => 'Central boutique and heritage hotels'],
                    ['label' => 'Best for', 'value' => 'Couples, families and first Europe trips'],
                ],
                moments: [
                    ['title' => 'Paris before breakfast', 'text' => 'A quiet walk from Saint-Germain toward the river before the city reaches full volume.'],
                    ['title' => 'Rail through the Alps', 'text' => 'The transfer becomes part of the holiday when the route is chosen for the view.'],
                    ['title' => 'Venice after the day boats', 'text' => 'Stay on the island so the city belongs to you again after early evening.'],
                    ['title' => 'A table in Trastevere', 'text' => 'A final Roman dinner without an alarmingly early departure the next morning.'],
                ],
                stays: [
                    ['place' => 'Paris', 'style' => 'Left Bank townhouse', 'note' => 'Small scale, walkable streets and breakfast that feels residential rather than corporate.'],
                    ['place' => 'Lucerne', 'style' => 'Lake-facing grand hotel', 'note' => 'Old-world service with the station and waterfront both close enough to reach on foot.'],
                    ['place' => 'Florence', 'style' => 'Historic palazzo', 'note' => 'Inside the old centre, but on a street where the evening settles down.'],
                ],
                gallery: [
                    $this->photo('https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1600&q=85', 'Paris at first light', 'France'),
                    $this->photo('https://images.unsplash.com/photo-1530841377377-3ff06c0ca713?w=1600&q=85', 'A lake and mountain rail day', 'Switzerland'),
                    $this->photo('https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=1600&q=85', 'Venice after the crowds', 'Italy'),
                    $this->photo('https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=1600&q=85', 'Late afternoon in Rome', 'Italy'),
                    $this->photo('https://images.unsplash.com/photo-1549144511-f099e773c147?w=1600&q=85', 'The Parisian pause', 'France'),
                    $this->photo('https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=1600&q=85', 'Tuscan light between cities', 'Italy'),
                ],
                quote: 'The route felt generous. We saw the Europe we imagined, but never felt that we were chasing it.',
                quoteBy: 'Meera & Rohan, Bengaluru',
            ),
            'swiss-alpine-luxury' => $this->journey(
                name: 'Swiss Alpine Luxury',
                shortName: 'Switzerland',
                packageTerms: ['Switzerland', 'Swiss', 'Lucerne', 'Interlaken', 'Zermatt', 'Zurich'],
                countries: 'Lucerne · Bernese Oberland · Zermatt',
                eyebrow: 'Lakes, mountain railways, quiet precision',
                headline: 'The Alps, seen slowly and from the right carriage.',
                dek: 'A rail-led Swiss journey with lake hotels, mountain mornings and transfers that are as memorable as the destinations.',
                hero: 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?w=2000&q=88',
                accent: '#31574a',
                price: 349000,
                duration: '9 nights',
                season: 'Jun–Sep · Dec–Feb',
                route: ['Zurich', 'Lucerne', 'Interlaken', 'Zermatt'],
                routeNotes: [
                    ['city' => 'Lucerne', 'days' => '2 nights', 'note' => 'Lake promenades, old-town evenings and a mountain day chosen around the forecast.'],
                    ['city' => 'Bernese Oberland', 'days' => '4 nights', 'note' => 'One base, several valleys. Jungfrau days balanced with quieter lakes and villages.'],
                    ['city' => 'Zermatt', 'days' => '3 nights', 'note' => 'Arrive car-free, settle beneath the Matterhorn and keep one day entirely weather-flexible.'],
                ],
                philosophyTitle: 'Luxury is certainty, with room for weather.',
                philosophy: 'Switzerland rewards precise planning, but mountain travel still belongs to the sky. We reserve the right experiences, then keep the order flexible enough to choose the clearest day.',
                details: [
                    ['label' => 'The pace', 'value' => 'Three alpine bases'],
                    ['label' => 'How you move', 'value' => 'Panoramic and first-class rail'],
                    ['label' => 'Stay character', 'value' => 'Lakefront and mountain-view hotels'],
                    ['label' => 'Best for', 'value' => 'Honeymoons and scenic family travel'],
                ],
                moments: [
                    ['title' => 'Breakfast above the lake', 'text' => 'A window table in Lucerne before setting out for the mountain railways.'],
                    ['title' => 'The quieter Lauterbrunnen hour', 'text' => 'Waterfalls and valley paths before the day visitors arrive.'],
                    ['title' => 'Glacier Express, thoughtfully seated', 'text' => 'The right direction and carriage turn a transfer into a six-hour cinematic sequence.'],
                    ['title' => 'Matterhorn at dusk', 'text' => 'No excursion required—just a well-positioned terrace and patience.'],
                ],
                stays: [
                    ['place' => 'Lucerne', 'style' => 'Belle Époque lake hotel', 'note' => 'Water views, polished service and easy access to boats and trains.'],
                    ['place' => 'Interlaken', 'style' => 'Grand alpine retreat', 'note' => 'A calm base with enough facilities to enjoy a weather-rest day.'],
                    ['place' => 'Zermatt', 'style' => 'Matterhorn-facing chalet hotel', 'note' => 'Warm materials, a proper spa and a terrace worth returning to early for.'],
                ],
                gallery: [
                    $this->photo('https://images.unsplash.com/photo-1527668752968-14dc70a27c95?w=1600&q=85', 'The Bernese Oberland', 'Swiss Alps'),
                    $this->photo('https://images.unsplash.com/photo-1502784444187-359ac186c5bb?w=1600&q=85', 'Mountain railway country', 'Switzerland'),
                    $this->photo('https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1600&q=85', 'Winter light in the valley', 'Zermatt'),
                    $this->photo('https://images.unsplash.com/photo-1504218727796-db522606b16f?w=1600&q=85', 'A lake between journeys', 'Lucerne'),
                    $this->photo('https://images.unsplash.com/photo-1548777123-e216912df7d8?w=1600&q=85', 'Alpine village mornings', 'Switzerland'),
                    $this->photo('https://images.unsplash.com/photo-1531973576160-7125cd663d86?w=1600&q=85', 'The scenic transfer', 'Swiss Rail'),
                ],
                quote: 'Everything connected beautifully, but the holiday never felt over-engineered. The free mountain day made all the difference.',
                quoteBy: 'Ananya & Vikram, Mumbai',
            ),
            'japan-seasonal-trails' => $this->journey(
                name: 'Japan Seasonal Trails',
                shortName: 'Japan',
                packageTerms: ['Japan', 'Tokyo', 'Hakone', 'Kyoto', 'Osaka'],
                countries: 'Tokyo · Hakone · Kyoto · Osaka',
                eyebrow: 'Designed around the season, not around a checklist',
                headline: 'Japan changes its voice with every season.',
                dek: 'A tactile journey through neighbourhoods, ryokans, temple gardens and exceptional rail—timed around blossom, green summer, autumn colour or winter clarity.',
                hero: 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?w=2000&q=88',
                accent: '#a7353f',
                price: 319000,
                duration: '10 nights',
                season: 'Mar–Apr · Oct–Nov',
                route: ['Tokyo', 'Hakone', 'Kyoto', 'Osaka'],
                routeNotes: [
                    ['city' => 'Tokyo', 'days' => '3 nights', 'note' => 'Neighbourhood days rather than cross-city zigzags: old Tokyo, design Tokyo and one late-night district.'],
                    ['city' => 'Hakone', 'days' => '1 night', 'note' => 'A ryokan pause with onsen, seasonal dinner and a chance of Fuji in clear weather.'],
                    ['city' => 'Kyoto & Osaka', 'days' => '6 nights', 'note' => 'Temple mornings, craft streets and food-led evenings, with Osaka as the livelier final note.'],
                ],
                philosophyTitle: 'Follow texture, not just icons.',
                philosophy: 'Japan’s famous sights matter, but its character often lives in the transition: shoes left at a threshold, a train arriving exactly, steam above a bowl, rain changing a temple garden.',
                details: [
                    ['label' => 'The pace', 'value' => 'Four distinct chapters'],
                    ['label' => 'How you move', 'value' => 'Shinkansen + private luggage forwarding'],
                    ['label' => 'Stay character', 'value' => 'Design hotels and one ryokan'],
                    ['label' => 'Best for', 'value' => 'Culture, food and detail-oriented travellers'],
                ],
                moments: [
                    ['title' => 'Old Tokyo before ten', 'text' => 'Shrine lanes, small shops and breakfast counters before moving into the modern city.'],
                    ['title' => 'One night in a ryokan', 'text' => 'Tatami, onsen etiquette and a seasonal dinner that explains more than a guided tour can.'],
                    ['title' => 'Kyoto at the edge of day', 'text' => 'Temple gardens at opening time and Gion lanes after dinner.'],
                    ['title' => 'Osaka from the counter', 'text' => 'A food city best understood one small restaurant and conversation at a time.'],
                ],
                stays: [
                    ['place' => 'Tokyo', 'style' => 'Quiet design hotel', 'note' => 'Near a useful station, but one street removed from the city’s constant movement.'],
                    ['place' => 'Hakone', 'style' => 'Private-onsen ryokan', 'note' => 'Traditional hospitality with enough English support to make the rituals comfortable.'],
                    ['place' => 'Kyoto', 'style' => 'Machiya-inspired retreat', 'note' => 'Natural materials, garden calm and access to early temple routes.'],
                ],
                gallery: [
                    $this->photo('https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?w=1600&q=85', 'Kyoto in seasonal colour', 'Kyoto'),
                    $this->photo('https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=1600&q=85', 'Tokyo after dark', 'Tokyo'),
                    $this->photo('https://images.unsplash.com/photo-1524413840807-0c3cb6fa808d?w=1600&q=85', 'Temple morning', 'Kyoto'),
                    $this->photo('https://images.unsplash.com/photo-1490806843957-31f4c9a91c65?w=1600&q=85', 'Fuji on a clear day', 'Hakone'),
                    $this->photo('https://images.unsplash.com/photo-1528164344705-47542687000d?w=1600&q=85', 'The rural pause', 'Japan'),
                    $this->photo('https://images.unsplash.com/photo-1542051841857-5f90071e7989?w=1600&q=85', 'City rhythm', 'Tokyo'),
                ],
                quote: 'It felt observant rather than busy. The ryokan night and the luggage forwarding were the two details we would never have planned ourselves.',
                quoteBy: 'Kavya & Neel, Hyderabad',
            ),
            'turkey-and-greece' => $this->journey(
                name: 'Turkey and Greece',
                shortName: 'Turkey & Greece',
                packageTerms: ['Turkey', 'Greece', 'Istanbul', 'Cappadocia', 'Athens', 'Santorini'],
                countries: 'Istanbul · Cappadocia · Athens · Santorini',
                eyebrow: 'Two shores, one Mediterranean story',
                headline: 'Minarets, cave valleys and the blue Aegean.',
                dek: 'A cross-cultural route from Istanbul’s layered streets to Cappadocia’s dawn skies, then onward to Athens and a slower island finish.',
                hero: 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=2000&q=88',
                accent: '#99622f',
                price: 329000,
                duration: '11 nights',
                season: 'Apr–Jun · Sep–Oct',
                route: ['Istanbul', 'Cappadocia', 'Athens', 'Santorini'],
                routeNotes: [
                    ['city' => 'Istanbul', 'days' => '3 nights', 'note' => 'Historic peninsula mornings, Bosphorus light and dinners on the neighbourhood side of the city.'],
                    ['city' => 'Cappadocia', 'days' => '2 nights', 'note' => 'Two dawns improve the odds for balloon weather and allow one genuinely slow cave-hotel day.'],
                    ['city' => 'Athens & Santorini', 'days' => '6 nights', 'note' => 'Ancient Athens first, then a ferry or flight to an island stay positioned away from cruise-day congestion.'],
                ],
                philosophyTitle: 'A route joined by water and appetite.',
                philosophy: 'Turkey and Greece belong together through food, trade, architecture and the sea. The itinerary works when each stop has a different energy—and when the island comes last.',
                details: [
                    ['label' => 'The pace', 'value' => 'Four bases across two countries'],
                    ['label' => 'How you move', 'value' => 'Regional flights, private transfers and ferry'],
                    ['label' => 'Stay character', 'value' => 'Bosphorus, cave and caldera hotels'],
                    ['label' => 'Best for', 'value' => 'Couples, history and food-led travel'],
                ],
                moments: [
                    ['title' => 'Istanbul from the water', 'text' => 'The city makes more sense from a private Bosphorus boat near sunset.'],
                    ['title' => 'Two dawns in Cappadocia', 'text' => 'Balloon flights are weather-dependent; an extra morning turns hope into a sensible plan.'],
                    ['title' => 'Athens after the Acropolis', 'text' => 'A shaded lunch and neighbourhood walk reveal the living city beyond antiquity.'],
                    ['title' => 'Santorini beyond sunset', 'text' => 'A cliff-path morning and a village dinner away from the famous blue-domed queue.'],
                ],
                stays: [
                    ['place' => 'Istanbul', 'style' => 'Bosphorus-facing townhouse', 'note' => 'A smaller hotel in a walkable district with water or old-city access.'],
                    ['place' => 'Cappadocia', 'style' => 'Stone cave suite', 'note' => 'Terrace views, thoughtful heating and staff who understand balloon-day logistics.'],
                    ['place' => 'Santorini', 'style' => 'Caldera hideaway', 'note' => 'Privacy and a view, ideally outside the busiest lanes of central Oia.'],
                ],
                gallery: [
                    $this->photo('https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=1600&q=85', 'The Bosphorus city', 'Istanbul'),
                    $this->photo('https://images.unsplash.com/photo-1528181304800-259b08848526?w=1600&q=85', 'Cappadocia at dawn', 'Turkey'),
                    $this->photo('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=85', 'Aegean blue', 'Greece'),
                    $this->photo('https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=1600&q=85', 'White villages above the caldera', 'Santorini'),
                    $this->photo('https://images.unsplash.com/photo-1555993539-1732b0258235?w=1600&q=85', 'Ancient Athens', 'Athens'),
                    $this->photo('https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=1600&q=85', 'Stone, sea and late light', 'Mediterranean'),
                ],
                quote: 'Ending on the island was exactly right. Istanbul and Cappadocia filled the senses; Santorini gave us time to absorb it.',
                quoteBy: 'Ishita & Arjun, Delhi',
            ),
        ];
    }

    private function journey(
        string $name,
        string $shortName,
        array $packageTerms,
        string $countries,
        string $eyebrow,
        string $headline,
        string $dek,
        string $hero,
        string $accent,
        int $price,
        string $duration,
        string $season,
        array $route,
        array $routeNotes,
        string $philosophyTitle,
        string $philosophy,
        array $details,
        array $moments,
        array $stays,
        array $gallery,
        string $quote,
        string $quoteBy,
    ): array {
        return compact(
            'name', 'shortName', 'countries', 'eyebrow', 'headline', 'dek', 'hero', 'accent',
            'price', 'duration', 'season', 'route', 'routeNotes', 'philosophyTitle',
            'philosophy', 'details', 'moments', 'stays', 'gallery', 'quote', 'quoteBy', 'packageTerms'
        );
    }

    private function photo(string $src, string $caption, string $location): array
    {
        return compact('src', 'caption', 'location');
    }
}
