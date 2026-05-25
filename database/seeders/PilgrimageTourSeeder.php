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
                'title' => 'KEDARNATH',
                'slug' => 'kedarnath',
                'description' => 'A sacred Himalayan yatra to one of the holiest Jyotirlinga shrines in India.',
                'image' => 'https://images.unsplash.com/photo-1623082574085-157d955f8e3d?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Temple Darshan', 'Uttarakhand', 'Yatra', 'Himalayas'],
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'VARANASI',
                'slug' => 'varanasi',
                'description' => 'Witness the spiritual pulse of Kashi with Ganga aarti and ancient temples.',
                'image' => 'https://images.unsplash.com/photo-1561361513-2d000a50f0dc?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Kashi Vishwanath', 'Ganga Aarti', 'Ghats', 'Sarnath'],
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'HARIDWAR',
                'slug' => 'haridwar',
                'description' => 'A timeless pilgrimage by the Ganga with sacred rituals and evening aarti.',
                'image' => 'https://images.unsplash.com/photo-1598091383021-15ddea10925d?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Har Ki Pauri', 'Ganga Aarti', 'Temples', 'Uttarakhand'],
                'order' => 3,
                'is_active' => true
            ],
            [
                'title' => 'RISHIKESH',
                'slug' => 'rishikesh',
                'description' => 'Blend spirituality and nature at the yoga capital by the holy Ganges.',
                'image' => 'https://images.unsplash.com/photo-1583417267826-aebc4d1542e1?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Triveni Ghat', 'Laxman Jhula', 'Ashrams', 'Yoga'],
                'order' => 4,
                'is_active' => true
            ],
            [
                'title' => 'AMRITSAR',
                'slug' => 'amritsar',
                'description' => 'Seek peace at Sri Harmandir Sahib and experience seva and langar.',
                'image' => 'https://images.unsplash.com/photo-1587914187980-3689e0d4e6cb?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Golden Temple', 'Langar', 'Wagah', 'Punjab'],
                'order' => 5,
                'is_active' => true
            ],
            [
                'title' => 'JAGANNATH PURI',
                'slug' => 'jagannath-puri',
                'description' => 'Experience Jagannath dham and the devotional aura of Puri.',
                'image' => 'https://images.unsplash.com/photo-1606298855672-3efb63017be8?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Jagannath Temple', 'Rath Yatra', 'Puri', 'Odisha'],
                'order' => 6,
                'is_active' => true
            ],
            [
                'title' => 'SHIRDI',
                'slug' => 'shirdi',
                'description' => 'Offer prayers at the revered shrine of Sai Baba in Maharashtra.',
                'image' => 'https://images.unsplash.com/photo-1624862074295-2a8b4c5bc9b4?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Sai Baba Mandir', 'Dwarkamai', 'Maharashtra', 'Darshan'],
                'order' => 7,
                'is_active' => true
            ],
            [
                'title' => 'TIRUPATI',
                'slug' => 'tirupati',
                'description' => 'Receive blessings at Tirumala and experience one of India\'s most visited temples.',
                'image' => 'https://images.unsplash.com/photo-1594453385841-a2b7e4f87e43?auto=format&fit=crop&w=900&q=80',
                'tags' => ['Balaji Darshan', 'Tirumala', 'Andhra Pradesh', 'Temple Tour'],
                'order' => 8,
                'is_active' => true
            ]
        ];

        foreach ($tours as $tour) {
            PilgrimageTour::updateOrCreate(
                ['slug' => $tour['slug']],
                $tour
            );
        }
    }
}
