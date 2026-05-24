<?php

namespace Database\Seeders;

use App\Models\PilgrimageDestination;
use Illuminate\Database\Seeder;

class PilgrimageDestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'CHAR DHAM',
                'slug' => 'char-dham',
                'description' => 'Experience the divine journey through the four sacred shrines in the Himalayas',
                'image_url' => 'https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=800&q=80',
                'tags' => ['Kedarnath', 'Badrinath', 'Gangotri', 'Yamunotri'],
                'order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'VARANASI',
                'slug' => 'varanasi',
                'description' => 'The spiritual capital of India on the banks of holy Ganges',
                'image_url' => 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?w=800&q=80',
                'tags' => ['Kashi Vishwanath', 'Ganga Aarti', 'Sarnath', 'Dashashwamedh Ghat'],
                'order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'VAISHNO DEVI',
                'slug' => 'vaishno-devi',
                'description' => 'Sacred pilgrimage to the holy cave shrine of Mata Vaishno Devi',
                'image_url' => 'https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=800&q=80',
                'tags' => ['Katra', 'Bhairavnath', 'Ardhkuwari', 'Jammu'],
                'order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'RAMESHWARAM',
                'slug' => 'rameshwaram',
                'description' => 'One of the holiest places in India, where Lord Rama worshipped Shiva',
                'image_url' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=800&q=80',
                'tags' => ['Ramanathaswamy', 'Dhanushkodi', 'Agni Teertham', 'Pamban Bridge'],
                'order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'TIRUPATI',
                'slug' => 'tirupati',
                'description' => 'Home to the richest temple in the world - Sri Venkateswara Temple',
                'image_url' => 'https://images.unsplash.com/photo-1609137144813-7d9921338f24?w=800&q=80',
                'tags' => ['Tirumala Temple', 'Balaji Darshan', 'Andhra Pradesh', 'Laddu Prasadam'],
                'order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'JAGANNATH PURI',
                'slug' => 'jagannath-puri',
                'description' => 'Famous for the annual Rath Yatra and Lord Jagannath Temple',
                'image_url' => 'https://images.unsplash.com/photo-1548013146-72479768bada?w=800&q=80',
                'tags' => ['Rath Yatra', 'Puri Beach', 'Konark', 'Odisha'],
                'order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'AMRITSAR',
                'slug' => 'amritsar',
                'description' => 'The holiest city of Sikhism, home to the magnificent Golden Temple',
                'image_url' => 'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?w=800&q=80',
                'tags' => ['Golden Temple', 'Wagah Border', 'Punjab', 'Langar'],
                'order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'SHIRDI',
                'slug' => 'shirdi',
                'description' => 'The sacred abode of Sai Baba, a revered spiritual master',
                'image_url' => 'https://images.unsplash.com/photo-1582510003544-4d00b7f74220?w=800&q=80',
                'tags' => ['Sai Baba Temple', 'Dwarkamai', 'Maharashtra', 'Spiritual Tour'],
                'order' => 8,
                'is_active' => true
            ]
        ];

        foreach ($destinations as $destination) {
            PilgrimageDestination::create($destination);
        }
    }
}
