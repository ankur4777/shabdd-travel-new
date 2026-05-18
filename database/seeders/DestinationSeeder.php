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
            ],
            [
                'name' => 'Bali',
                'country' => 'Indonesia',
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
            ],
            [
                'name' => 'Maldives',
                'country' => 'South Asia',
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
            ],
            [
                'name' => 'Kashmir',
                'country' => 'India',
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
            ],
            [
                'name' => 'Switzerland',
                'country' => 'Europe',
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
            ],
            [
                'name' => 'Thailand',
                'country' => 'Southeast Asia',
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
            ],
            [
                'name' => 'Dubai',
                'country' => 'UAE',
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
            ],
            [
                'name' => 'Goa',
                'country' => 'India',
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
