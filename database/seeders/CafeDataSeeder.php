<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cafes;
use App\Models\Tags;
use App\Models\Type;
use App\Models\User;
use App\Models\Role;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class CafeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::whereHas('role', function($q) {
            $q->where('name', 'owner');
        })->first();

        if (!$owner) {
            $role = Role::firstOrCreate(['name' => 'owner']);
            $owner = User::create([
                'name' => 'Budi Owner',
                'username' => 'budiowner',
                'email' => 'budi@owner.com',
                'password' => Hash::make('password123'),
                'role_id' => $role->id,
            ]);
        }

        $typeCafe = Type::firstOrCreate(['type_name' => 'Cafe & Bakkery']);
        $typeWarkop = Type::firstOrCreate(['type_name' => 'Warkop']);

        $tagPromo = Tags::firstOrCreate(['tag_name' => 'promo']);
        $tagWifi = Tags::firstOrCreate(['tag_name' => 'wifi']);
        $tagCozy = Tags::firstOrCreate(['tag_name' => 'quite']);
        $tagAesthetic = Tags::firstOrCreate(['tag_name' => 'cool']);

        $cafesData = [
            [
                'name' => 'Senja Coffee & Eatery',
                'description' => 'Tempat yang cocok untuk menikmati kopi sambil menikmati senja. Menyediakan menu lengkap dan suasana nyaman.',
                'type_id' => $typeCafe->id,
                'num_phone' => '081234567890',
                'address' => 'Jl. Kopi Harapan No. 12, Pusat Kota',
                'email' => 'hello@senjacoffee.com',
                'latitude' => -7.9826145,
                'longitude' => 112.630737,
                'maps_link' => 'https://maps.google.com/?q=-7.9826145,112.630737',
                'kecamatan' => 'Lowokwaru',
                'published' => 1,
                'rating' => 4.8,
                'tags' => [$tagPromo->id, $tagWifi->id, $tagAesthetic->id],
            ],
            [
                'name' => 'Warkop Nusantara',
                'description' => 'Warkop legendaris dengan cita rasa kopi nusantara asli. Buka 24 jam untuk menemanimu.',
                'type_id' => $typeWarkop->id,
                'num_phone' => '081298765432',
                'address' => 'Jl. Pahlawan No. 45, Timur Kota',
                'email' => 'kontak@warkopnusantara.com',
                'latitude' => -7.9786145,
                'longitude' => 112.632737,
                'maps_link' => 'https://maps.google.com/?q=-7.9786145,112.632737',
                'kecamatan' => 'Klojen',
                'published' => 1,
                'rating' => 4.5,
                'tags' => [$tagWifi->id],
            ],
            [
                'name' => 'Ruang Teduh Cafe',
                'description' => 'Ruang teduh untuk kamu yang butuh ketenangan untuk bekerja atau nugas. Wi-Fi super cepat.',
                'type_id' => $typeCafe->id,
                'num_phone' => '085511223344',
                'address' => 'Jl. Ketenangan No. 8, Utara Kota',
                'email' => 'info@ruangteduh.com',
                'latitude' => -7.9856145,
                'longitude' => 112.620737,
                'maps_link' => 'https://maps.google.com/?q=-7.9856145,112.620737',
                'kecamatan' => 'Blimbing',
                'published' => 1,
                'rating' => 4.9,
                'tags' => [$tagPromo->id, $tagCozy->id, $tagWifi->id],
            ],
            [
                'name' => 'Kopi Titik Kumpul',
                'description' => 'Titik kumpul terbaik bareng teman-teman. Vibe asik dengan live music setiap akhir pekan.',
                'type_id' => $typeCafe->id,
                'num_phone' => '082233445566',
                'address' => 'Jl. Kebersamaan No. 99, Selatan Kota',
                'email' => 'halo@titikkumpul.com',
                'latitude' => -7.9906145,
                'longitude' => 112.640737,
                'maps_link' => 'https://maps.google.com/?q=-7.9906145,112.640737',
                'kecamatan' => 'Sukun',
                'published' => 1,
                'rating' => 4.6,
                'tags' => [$tagAesthetic->id],
            ]
        ];

        foreach ($cafesData as $data) {
            $tags = $data['tags'];
            unset($data['tags']);
            $data['user_id'] = $owner->id;

            $cafe = Cafes::create($data);
            $cafe->tags()->attach($tags);

            // Create some mock ratings so they show up as Top Rated
            Comment::create([
                'user_id' => $owner->id,
                'cafe_id' => $cafe->id,
                'body' => 'Tempatnya nyaman banget!',
                'type' => 'review',
                'rating_score' => $data['rating'],
            ]);
            
            Comment::create([
                'user_id' => $owner->id,
                'cafe_id' => $cafe->id,
                'body' => 'Kopinya mantap.',
                'type' => 'review',
                'rating_score' => $data['rating'] > 4.5 ? 5 : 4,
            ]);
            
            $cafe->updateAverageRating();
        }
    }
}
