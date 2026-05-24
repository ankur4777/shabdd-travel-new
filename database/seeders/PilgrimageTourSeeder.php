<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PilgrimageTour;

class PilgrimageTourSeeder extends Seeder
{
    public function run(): void
    {
        $tours = [
            [
                'title' => 'CHAR DHAM',
                'slug' => 'char-dham',
                'description' => 'Experience the divine journey through the four sacred shrines of Uttarakhand',
                'image' => 'images/char-dham.jpg',
                'tags' => ['Kedarnath', 'Badrinath', 'Gangotri', 'Yamunotri'],
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'VARANASI',
                'slug' => 'varanasi',
                'description' => 'Witness the spiritual essence of India at the holy city on the banks of Ganga',
                'image' => 'images/varanasi.jpg',
                'tags' => ['Kashi Vishwanath', 'Ganga Aarti', 'Sarnath', 'Dashashwamedh Ghat'],
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'VAISHNO DEVI',
                'slug' => 'vaishno-devi',
                'description' => 'Embark on a sacred trek to the holy cave shrine of Mata Vaishno Devi',
                'image' => 'images/vaishno-devi.jpg',
                'tags' => ['Katra', 'Bhairavnath', 'Ardhkuwari', 'Jammu'],
                'order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'RAMESHWARAM',
                'slug' => 'rameshwaram',
                'description' => 'Visit the sacred island temple and one of the twelve Jyotirlinga shrines',
                'image' => 'images/rameshwaram.jpg',
                'tags' => ['Ramanathaswamy', 'Dhanushkodi', 'Agni Teertham', 'Pamban Bridge'],
                'order' => 4,
                'is_active' => true
            ],
            [
                'title' => 'TIRUPATI',
                'slug' => 'tirupati',
                'description' => 'Seek blessings at the richest temple in the world, Lord Venkateswara Temple',
                'image' => 'images/tirupati.jpg',
                'tags' => ['Tirumala Temple', 'Balaji Darshan', 'Andhra Pradesh', 'Laddu Prasadam'],
                'order' => 5,
                'is_active' => true
            ],
            [
                'title' => 'JAGANNATH PURI',
                'slug' => 'jagannath-puri',
                'description' => 'Experience the divine Rath Yatra and the sacred Jagannath Temple',
                'image' => 'images/jagannath-puri.jpg',
                'tags' => ['Rath Yatra', 'Puri Beach', 'Konark', 'Odisha'],
                'order' => 6,
                'is_active' => true
            ],
            [
                'title' => 'AMRITSAR',
                'slug' => 'amritsar',
                'description' => 'Visit the holiest Gurdwara and experience the spiritual langar tradition',
                'image' => 'images/amritsar.jpg',
                'tags' => ['Golden Temple', 'Wagah Border', 'Punjab', 'Langar'],
                'order' => 7,
                'is_active' => true
            ],
            [
                'title' => 'SHIRDI',
                'slug' => 'shirdi',
                'description' => 'Seek blessings at the sacred shrine of Sai Baba in Maharashtra',
                'image' => 'images/shirdi.jpg',
                'tags' => ['Sai Baba Temple', 'Dwarkamai', 'Maharashtra', 'Spiritual Tour'],
                'order' => 8,
                'is_active' => true
            ]
        ];

        foreach ($tours as $tour) {
            PilgrimageTour::create($tour);
        }
    }
}
