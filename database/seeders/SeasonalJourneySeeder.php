<?php

namespace Database\Seeders;

use App\Models\SeasonalJourney;
use Illuminate\Database\Seeder;

class SeasonalJourneySeeder extends Seeder
{
    public function run(): void
    {
        $journeys = [
            [
                'title' => 'ANDAMAN',
                'slug' => 'andaman',
                'image' => 'images/dubai.jpg',
                'price_text' => 'Start From ₹ 14,999',
                'excerpt' => 'Island escapes, clear water, and soft beaches for a seasonal break.',
                'content' => '<p>Explore Andaman with beach stays, island hopping, water activities, and relaxed coastal days.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'EUROPE',
                'slug' => 'europe',
                'image' => 'images/himachal.jpg',
                'price_text' => 'Start From ₹ 69,089',
                'excerpt' => 'Classic cities, scenic landscapes, and memorable seasonal experiences.',
                'content' => '<p>Plan a Europe journey with handpicked routes, comfortable stays, sightseeing, and curated local experiences.</p>',
                'sort_order' => 2,
            ],
            [
                'title' => 'MAURITIUS',
                'slug' => 'mauritius',
                'image' => 'images/himachal.jpg',
                'price_text' => 'Start From ₹ 26,999',
                'excerpt' => 'A tropical island holiday with beaches, resorts, and easy adventure.',
                'content' => '<p>Enjoy Mauritius with beach resorts, island tours, leisure time, and beautiful coastal views.</p>',
                'sort_order' => 3,
            ],
            [
                'title' => 'HIMACHAL PRADESH',
                'slug' => 'himachal-pradesh',
                'image' => 'images/himachal.jpg',
                'price_text' => 'Start From ₹ 9,999',
                'excerpt' => 'Mountain air, hill towns, and scenic routes for the season.',
                'content' => '<p>Discover Himachal Pradesh through hill stations, valleys, temples, cafes, and mountain viewpoints.</p>',
                'sort_order' => 4,
            ],
            [
                'title' => 'KERALA',
                'slug' => 'kerala',
                'image' => 'images/kerala.avif',
                'price_text' => 'Start From ₹ 9,999',
                'excerpt' => 'Backwaters, greenery, and slow travel through God\'s Own Country.',
                'content' => '<p>Experience Kerala with houseboats, tea gardens, beaches, wildlife, and peaceful stays.</p>',
                'sort_order' => 5,
            ],
            [
                'title' => 'MALAYSIA',
                'slug' => 'malaysia',
                'image' => 'images/himachal.jpg',
                'price_text' => 'Start From ₹ 21,999',
                'excerpt' => 'City lights, island time, family attractions, and great food.',
                'content' => '<p>Visit Malaysia with Kuala Lumpur highlights, island add-ons, shopping, theme parks, and food trails.</p>',
                'sort_order' => 6,
            ],
        ];

        foreach ($journeys as $journey) {
            SeasonalJourney::updateOrCreate(
                ['slug' => $journey['slug']],
                $journey + ['is_active' => true],
            );
        }
    }
}
