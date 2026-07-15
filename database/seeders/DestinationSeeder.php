<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Santorini',
                'country' => 'Greece',
                'type' => 'international',
                'image_url' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=1200&q=80',
                'badge_label' => '🔥 Trending',
                'badge_type' => 'hot',
                'rating' => 4.9,
                'tags' => ['Honeymoon', 'Luxury', '5-7 Days'],
                'price_from' => 185000,
                'short_description' => 'Whitewashed cliff towns, iconic sunsets, and romantic caldera views.',
                'about' => 'Santorini is one of the most loved Greek islands for couples and luxury travelers.',
                'highlights' => ['Sunset in Oia', 'Catamaran cruise', 'Cliffside stays'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => 'Complete Santorini Travel Guide 2026',
                        'slug' => 'complete-santorini-travel-guide-2026',
                        'excerpt' => 'Everything you need to know about planning your perfect Santorini honeymoon, from best hotels to sunset spots.',
                        'date' => '2026-05-15',
                        'reading_time' => 8,
                        'category' => 'Destination Guide',
                        'author' => 'Shabdd Travel Team',
                    ],
                    [
                        'title' => 'Best Time to Visit Santorini',
                        'slug' => 'best-time-to-visit-santorini',
                        'excerpt' => 'Discover the ideal months to visit Santorini for perfect weather and fewer crowds.',
                        'date' => '2026-05-10',
                        'reading_time' => 5,
                        'category' => 'Travel Tips',
                    ],
                ],
            ],
            [
                'name' => 'Bali',
                'country' => 'Indonesia',
                'type' => 'international',
                'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200&q=80',
                'badge_label' => '⭐ Bestseller',
                'badge_type' => 'bestseller',
                'rating' => 4.7,
                'tags' => ['Adventure', 'Friends', '5-7 Days'],
                'price_from' => 50000,
                'short_description' => 'Temples, waterfalls, beach clubs, and jungle experiences in one island.',
                'about' => 'Bali offers a balanced mix of budget and premium experiences for every traveler type.',
                'highlights' => ['Ubud day tour', 'Nusa Penida', 'Beach sunset dinners'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => 'Bali Under ₹40,000: Complete 7-Day Budget Itinerary',
                        'slug' => 'bali-budget-itinerary',
                        'excerpt' => 'Experience the best of Bali without breaking the bank. Complete guide to affordable stays, food, and activities.',
                        'date' => '2026-05-12',
                        'reading_time' => 10,
                        'category' => 'Budget Travel',
                    ],
                    [
                        'title' => 'Hidden Waterfalls of Bali',
                        'slug' => 'hidden-waterfalls-bali',
                        'excerpt' => 'Explore Bali\'s most stunning and lesser-known waterfalls away from tourist crowds.',
                        'date' => '2026-05-08',
                        'reading_time' => 6,
                        'category' => 'Adventure',
                    ],
                ],
            ],
            [
                'name' => 'Maldives',
                'country' => 'South Asia',
                'type' => 'international',
                'image_url' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=1200&q=80',
                'badge_label' => '✨ Luxury',
                'badge_type' => 'luxury',
                'rating' => 5.0,
                'tags' => ['Honeymoon', 'Overwater', '5-7 Days'],
                'price_from' => 150000,
                'short_description' => 'Overwater villas, turquoise lagoons, and all-inclusive private island stays.',
                'about' => 'The Maldives is ideal for premium, relaxed, and honeymoon-focused beach vacations.',
                'highlights' => ['Water villa stay', 'Snorkeling safari', 'Sunset cruise'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => '10 Reasons Why Maldives is the Ultimate Honeymoon Destination',
                        'slug' => 'maldives-honeymoon-guide',
                        'excerpt' => 'From overwater villas to private island experiences, discover why Maldives tops every honeymoon list.',
                        'date' => '2026-05-14',
                        'reading_time' => 7,
                        'category' => 'Honeymoon',
                    ],
                ],
            ],
            [
                'name' => 'Kashmir',
                'country' => 'India',
                'type' => 'domestic',
                'image_url' => 'https://images.unsplash.com/photo-1548013146-72479768bada?w=1200&q=80',
                'badge_label' => '🔥 Trending',
                'badge_type' => 'hot',
                'rating' => 4.6,
                'tags' => ['Family', 'Snow', '5-7 Days'],
                'price_from' => 35000,
                'short_description' => 'Snow-capped mountains, houseboats, and scenic valleys for all seasons.',
                'about' => 'Kashmir is a versatile destination for couples, families, and adventure lovers.',
                'highlights' => ['Srinagar houseboat', 'Gulmarg gondola', 'Pahalgam valleys'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => 'Kashmir Great Lakes Trek: Complete Guide for First-Timers',
                        'slug' => 'kashmir-great-lakes-trek',
                        'excerpt' => 'Everything you need to know about one of India\'s most beautiful treks, from preparation to best season.',
                        'date' => '2026-05-11',
                        'reading_time' => 9,
                        'category' => 'Adventure',
                    ],
                    [
                        'title' => 'Kashmir in Winter: Snow Paradise Guide',
                        'slug' => 'kashmir-winter-guide',
                        'excerpt' => 'Experience the magical winter wonderland of Kashmir with snow activities and cozy stays.',
                        'date' => '2026-05-06',
                        'reading_time' => 6,
                        'category' => 'Destination Guide',
                    ],
                ],
            ],
            [
                'name' => 'Switzerland',
                'country' => 'Europe',
                'type' => 'international',
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1200&q=80',
                'badge_label' => '✨ Luxury',
                'badge_type' => 'luxury',
                'rating' => 4.9,
                'tags' => ['Honeymoon', 'Alps', '7+ Days'],
                'price_from' => 200000,
                'short_description' => 'Alpine rail journeys, glacier towns, and postcard-perfect mountain views.',
                'about' => 'Switzerland delivers unmatched scenic routes and premium European experiences.',
                'highlights' => ['Jungfrau region', 'Scenic train rides', 'Lake Lucerne'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => 'Switzerland in Winter: Ultimate Alps & Snow Trains Guide',
                        'slug' => 'switzerland-winter-guide',
                        'excerpt' => 'From golden Bernese Oberland to icy Zermatt peaks, discover Switzerland\'s winter magic with best rail routes.',
                        'date' => '2026-05-13',
                        'reading_time' => 12,
                        'category' => 'Destination Guide',
                    ],
                ],
            ],
            [
                'name' => 'Thailand',
                'country' => 'Southeast Asia',
                'type' => 'international',
                'image_url' => 'https://images.unsplash.com/photo-1506665531195-3566af2b4dfa?w=1200&q=80',
                'badge_label' => '⭐ Bestseller',
                'badge_type' => 'bestseller',
                'rating' => 4.5,
                'tags' => ['Friends', 'Islands', '7+ Days'],
                'price_from' => 60000,
                'short_description' => 'Island hopping, nightlife, markets, and adventure activities at great value.',
                'about' => 'Thailand remains one of the strongest value-for-money international tours.',
                'highlights' => ['Phi Phi islands', 'Bangkok city tour', 'Krabi beaches'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => 'Thailand Visa on Arrival 2026: Everything Indians Need to Know',
                        'slug' => 'thailand-visa-guide',
                        'excerpt' => 'Complete guide to Thailand visa process, requirements, and tips for Indian travelers.',
                        'date' => '2026-05-09',
                        'reading_time' => 5,
                        'category' => 'Travel Tips',
                    ],
                    [
                        'title' => 'Island Hopping in Thailand: 10-Day Itinerary',
                        'slug' => 'thailand-island-hopping',
                        'excerpt' => 'Explore the best islands of Thailand from Phuket to Koh Samui with this detailed itinerary.',
                        'date' => '2026-05-04',
                        'reading_time' => 8,
                        'category' => 'Destination Guide',
                    ],
                ],
            ],
            [
                'name' => 'Dubai',
                'country' => 'UAE',
                'type' => 'international',
                'image_url' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=1200&q=80',
                'badge_label' => '🔥 Trending',
                'badge_type' => 'hot',
                'rating' => 4.8,
                'tags' => ['Luxury', 'Family', '3-5 Days'],
                'price_from' => 120000,
                'short_description' => 'Modern city landmarks, desert adventures, and high-end shopping.',
                'about' => 'Dubai blends ultra-modern attractions with memorable desert experiences.',
                'highlights' => ['Burj Khalifa', 'Desert safari', 'Marina cruise'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => 'Dubai in 3 Days: Perfect First-Timer Itinerary',
                        'slug' => 'dubai-3-day-itinerary',
                        'excerpt' => 'Make the most of your Dubai trip with this action-packed 3-day itinerary covering all major attractions.',
                        'date' => '2026-05-07',
                        'reading_time' => 7,
                        'category' => 'Destination Guide',
                    ],
                ],
            ],
            [
                'name' => 'Goa',
                'country' => 'India',
                'type' => 'domestic',
                'image_url' => 'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=1200&q=80',
                'badge_label' => '⭐ Bestseller',
                'badge_type' => 'bestseller',
                'rating' => 4.3,
                'tags' => ['Friends', 'Beach', 'Weekend'],
                'price_from' => 10000,
                'short_description' => 'Beach life, nightlife, water sports, and easy weekend itineraries.',
                'about' => 'Goa is a quick and flexible destination for short domestic getaways.',
                'highlights' => ['North beach circuit', 'South Goa escape', 'Water sports'],
                'is_trending' => true,
                'blogs' => [
                    [
                        'title' => 'North Goa vs South Goa: Which Side Should You Stay On?',
                        'slug' => 'north-vs-south-goa',
                        'excerpt' => 'Detailed comparison to help you choose between North Goa\'s party scene and South Goa\'s peaceful beaches.',
                        'date' => '2026-05-05',
                        'reading_time' => 6,
                        'category' => 'Destination Guide',
                    ],
                    [
                        'title' => 'Goa Weekend Getaway: 2-Day Perfect Plan',
                        'slug' => 'goa-weekend-getaway',
                        'excerpt' => 'Quick weekend escape to Goa with the best beaches, restaurants, and activities packed in 2 days.',
                        'date' => '2026-05-02',
                        'reading_time' => 5,
                        'category' => 'Travel Tips',
                    ],
                ],
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::updateOrCreate(
                ['name' => $destination['name']],
                $destination
            );
        }
    }
}
