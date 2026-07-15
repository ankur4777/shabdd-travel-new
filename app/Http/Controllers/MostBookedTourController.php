<?php

namespace App\Http\Controllers;

use App\Support\InternationalJourneyPackages;
use Illuminate\View\View;

class MostBookedTourController extends Controller
{
    public function show(string $slug): View
    {
        $journeys = $this->journeys();
        abort_unless(isset($journeys[$slug]), 404);

        $views = [
            'dubai-dream-holidays' => 'international-tours.dubai-dream-holidays',
            'thailand-beach-journeys' => 'international-tours.thailand-beach-journeys',
            'bali-island-escape' => 'international-tours.bali-island-escape',
            'singapore-family-fun' => 'international-tours.singapore-family-fun',
        ];

        return view($views[$slug], [
            'journey' => $journeys[$slug],
            'journeySlug' => $slug,
            'journeyPackages' => InternationalJourneyPackages::forJourney($journeys[$slug]),
            'mostBookedJourneys' => collect($journeys),
        ]);
    }

    private function journeys(): array
    {
        $dubaiImage = asset('images/dubai.jpg');

        return [
            'dubai-dream-holidays' => [
                'name' => 'Dubai Dream Holidays',
                'short_name' => 'Dubai',
                'country' => 'United Arab Emirates',
                'package_terms' => ['Dubai'],
                'hero_image' => $dubaiImage,
                'accent' => '#c89443',
                'eyebrow' => 'City lights, desert mornings',
                'headline' => 'Dubai, with enough room to enjoy it.',
                'intro' => 'A well-paced Dubai holiday should move between the city and the desert without feeling like an airport layover with attractions attached.',
                'starting_price' => 89999,
                'ideal_days' => '5 days',
                'best_months' => 'Nov–Mar',
                'flight_time' => 'Approx. 3.5 hrs',
                'overview_title' => 'Beyond the tallest building.',
                'overview' => [
                    'Dubai is easy to underestimate. The landmarks are famous, but the best trips are often shaped by the hours between them: an unhurried breakfast by the creek, a late-afternoon drive into the dunes, or a marina walk after the temperature drops.',
                    'Our preferred five-day rhythm keeps Downtown, the old city, the coast and the desert in separate chapters. It leaves space for shopping, a good dinner and the occasional change of plan.',
                ],
                'highlights' => [
                    ['number' => '01', 'title' => 'Old Dubai before the skyline', 'text' => 'Cross the creek by abra, browse the spice lanes and understand the trading city Dubai grew from.', 'icon' => 'bi bi-shop-window'],
                    ['number' => '02', 'title' => 'A desert evening done properly', 'text' => 'Dune drives at a comfortable hour, followed by dinner under open skies—not a rushed photo stop.', 'icon' => 'bi bi-sunset'],
                    ['number' => '03', 'title' => 'Waterfront after dark', 'text' => 'Marina, JBR and Bluewaters are best when the heat softens and the city begins to glow.', 'icon' => 'bi bi-water'],
                    ['number' => '04', 'title' => 'One spectacular viewpoint', 'text' => 'Choose Burj Khalifa, The View or the Frame based on the view you want, not simply the longest queue.', 'icon' => 'bi bi-buildings'],
                ],
                'day_plan' => [
                    ['day' => 'Day 1', 'title' => 'Arrive and settle into Downtown', 'text' => 'Airport pickup, hotel check-in and an easy first evening around Dubai Mall and the fountains.'],
                    ['day' => 'Day 2', 'title' => 'Creek, souks and the modern city', 'text' => 'Al Fahidi, an abra crossing and the old markets before moving toward the Frame and Downtown.'],
                    ['day' => 'Day 3', 'title' => 'A slow morning, then the desert', 'text' => 'Keep the morning open. Leave for the dunes after lunch and return after dinner at the camp.'],
                    ['day' => 'Day 4', 'title' => 'Palm, Marina and the coast', 'text' => 'Choose a Palm viewpoint or waterpark, then finish with JBR and a relaxed marina evening.'],
                    ['day' => 'Day 5', 'title' => 'Last coffee and fly home', 'text' => 'A free morning for a neighbourhood café, final shopping or a later checkout before the airport.'],
                ],
                'packages' => [
                    ['name' => 'The First Dubai Trip', 'duration' => '5D / 4N', 'price' => 89999, 'old_price' => 96999, 'tag' => 'Most balanced', 'features' => ['Downtown hotel', 'City tour', 'Desert safari', 'Airport transfers']],
                    ['name' => 'Dubai With The Family', 'duration' => '6D / 5N', 'price' => 112500, 'old_price' => 121000, 'tag' => 'Family favourite', 'features' => ['Family room', 'Aquarium or theme park', 'Private transfers', 'Desert evening']],
                    ['name' => 'A More Polished Dubai', 'duration' => '5D / 4N', 'price' => 139000, 'old_price' => 149000, 'tag' => 'Premium stay', 'features' => ['5-star hotel', 'Private city drive', 'Premium desert camp', 'Marina dinner']],
                ],
                'stay_areas' => [
                    ['name' => 'Downtown', 'best_for' => 'First visits', 'text' => 'Walkable evenings, landmark views and easy access to the city centre.'],
                    ['name' => 'Dubai Marina', 'best_for' => 'Couples & friends', 'text' => 'Waterfront dinners, beach access and a livelier evening rhythm.'],
                    ['name' => 'Bur Dubai', 'best_for' => 'Value & food', 'text' => 'Practical transport, excellent Indian food and a closer connection to old Dubai.'],
                ],
                'notes' => [
                    ['title' => 'Do not overbook viewpoints', 'text' => 'One great skyline experience is enough. Use the saved time for a neighbourhood or a long meal.'],
                    ['title' => 'Keep Friday timings in mind', 'text' => 'Traffic and attraction patterns can shift around the weekend, so route order matters.'],
                    ['title' => 'Summer needs a different plan', 'text' => 'From May to September, build the day around indoor attractions and evenings outdoors.'],
                ],
                'faqs' => [
                    ['question' => 'Is five days enough for Dubai?', 'answer' => 'Yes. Five days covers the old city, Downtown, the desert and the coast without turning every day into a race.'],
                    ['question' => 'Does the package include a visa?', 'answer' => 'Visa assistance can be added. Requirements and processing time are confirmed before booking based on the traveller profile.'],
                    ['question' => 'Which area should a first-time visitor stay in?', 'answer' => 'Downtown is convenient for landmark-led trips, while Marina suits travellers who prefer beach access and evening walks.'],
                    ['question' => 'Can the desert safari be made more comfortable for children or seniors?', 'answer' => 'Yes. We can arrange gentler dune driving, private vehicles or a direct transfer to the camp.'],
                ],
            ],
            'thailand-beach-journeys' => $this->companionJourney(
                'Thailand Beach Journeys',
                'Thailand',
                'Thailand',
                'https://images.unsplash.com/photo-1506665531195-3566af2b4dfa?w=1800&q=85',
                '#c89443',
                'Markets, islands and warm-water days',
                'Thailand, without trying to fit every island in.',
                74999,
                '7 days',
                'Nov–Apr'
            ),
            'bali-island-escape' => $this->companionJourney(
                'Bali Island Escape',
                'Bali',
                'Indonesia',
                'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1800&q=85',
                '#c89443',
                'Rice fields, temples and sea air',
                'Bali works best when the trip changes pace.',
                82999,
                '6 days',
                'Apr–Oct'
            ),
            'singapore-family-fun' => $this->companionJourney(
                'Singapore Family Fun',
                'Singapore',
                'Singapore',
                'https://images.unsplash.com/photo-1525625293386-3f8f99389edd?w=1800&q=85',
                '#c89443',
                'A city break made easy for families',
                'Singapore, planned around curious travellers of every age.',
                94999,
                '5 days',
                'Feb–Apr'
            ),
        ];
    }

    private function companionJourney(
        string $name,
        string $shortName,
        string $country,
        string $image,
        string $accent,
        string $eyebrow,
        string $headline,
        int $price,
        string $days,
        string $months
    ): array {
        return [
            'name' => $name,
            'short_name' => $shortName,
            'country' => $country,
            'package_terms' => [$shortName],
            'hero_image' => $image,
            'accent' => $accent,
            'eyebrow' => $eyebrow,
            'headline' => $headline,
            'intro' => "A considered {$shortName} itinerary balances the places you came to see with enough unplanned time to enjoy where you are.",
            'starting_price' => $price,
            'ideal_days' => $days,
            'best_months' => $months,
            'flight_time' => 'International short haul',
            'overview_title' => "A better-paced way to see {$shortName}.",
            'overview' => [
                "The strongest {$shortName} holidays are built around geography and pace, not a long list of attractions.",
                'We keep transfers sensible, protect a few slow mornings and choose experiences that suit the season and the people travelling.',
            ],
            'highlights' => [
                ['number' => '01', 'title' => 'The essential first chapter', 'text' => 'Begin with the signature sights and local context before the itinerary opens up.', 'icon' => 'bi bi-compass'],
                ['number' => '02', 'title' => 'A day shaped by local life', 'text' => 'Markets, neighbourhood food and a route that is not entirely built around landmarks.', 'icon' => 'bi bi-basket'],
                ['number' => '03', 'title' => 'Time near the water', 'text' => 'A coastal or waterfront day with fewer transfers and space to slow down.', 'icon' => 'bi bi-water'],
                ['number' => '04', 'title' => 'One memorable evening', 'text' => 'A considered dinner, performance or night view chosen for the group.', 'icon' => 'bi bi-moon-stars'],
            ],
            'day_plan' => collect(range(1, 5))->map(fn (int $day) => [
                'day' => "Day {$day}",
                'title' => $day === 1 ? "Arrive in {$shortName}" : "A well-paced {$shortName} day",
                'text' => $day === 1 ? 'Private arrival transfer and an easy first evening.' : 'A balanced mix of a key experience, local time and an unhurried evening.',
            ])->all(),
            'packages' => [
                ['name' => "{$shortName} Essentials", 'duration' => $days, 'price' => $price, 'old_price' => $price + 8000, 'tag' => 'Most balanced', 'features' => ['Central stay', 'Key sightseeing', 'Airport transfers', 'Trip support']],
                ['name' => "{$shortName} Family Edition", 'duration' => $days, 'price' => $price + 18000, 'old_price' => $price + 27000, 'tag' => 'Family favourite', 'features' => ['Family room', 'Flexible sightseeing', 'Private transfers', 'Easy pacing']],
                ['name' => "{$shortName} Premium", 'duration' => $days, 'price' => $price + 42000, 'old_price' => $price + 52000, 'tag' => 'Premium stay', 'features' => ['5-star stay', 'Private touring', 'Signature dinner', 'Priority support']],
            ],
            'stay_areas' => [
                ['name' => 'Central district', 'best_for' => 'First visits', 'text' => 'Convenient for sightseeing and simple evening plans.'],
                ['name' => 'Waterfront', 'best_for' => 'Couples & families', 'text' => 'A calmer base with restaurants and evening walks nearby.'],
                ['name' => 'Local quarter', 'best_for' => 'Food & value', 'text' => 'More neighbourhood character and practical transport links.'],
            ],
            'notes' => [
                ['title' => 'Fewer hotel changes', 'text' => 'Changing hotels can consume half a day. We only move base when it improves the trip.'],
                ['title' => 'Book around the season', 'text' => 'Weather changes the best order for outdoor, coastal and city experiences.'],
                ['title' => 'Leave one evening open', 'text' => 'A free evening is often the part travellers remember most fondly.'],
            ],
            'faqs' => [
                ['question' => "How many days are right for {$shortName}?", 'answer' => "{$days} gives most first-time travellers a comfortable introduction without rushing."],
                ['question' => 'Can the itinerary be customised?', 'answer' => 'Yes. Hotel category, activity mix, pacing and private transfers can all be adjusted.'],
                ['question' => 'Is visa assistance available?', 'answer' => 'Yes. The team can guide documentation and timelines relevant to the destination.'],
                ['question' => 'Are these journeys suitable for families?', 'answer' => 'Yes. We can change hotel configuration, transfer style and daily pacing for children or seniors.'],
            ],
        ];
    }
}
