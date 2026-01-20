<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $artistIds = \App\Models\Artist::pluck('id')->toArray();
        $categoryIds = \App\Models\Category::pluck('id')->toArray();

        // Contoh data spesifik Indo
        \App\Models\Artwork::create([
            'artist_id' => \App\Models\Artist::where('name', 'Raden Saleh')->first()->id,
            'category_id' => \App\Models\Category::where('slug', 'romanticism')->first()->id,
            'title' => 'Penangkapan Pangeran Diponegoro',
            'slug' => 'penangkapan-pangeran-diponegoro',
            'description' => 'Karya agung Raden Saleh tentang sejarah Indonesia.',
            'price' => 100000000000,
            'dimensions' => '110 cm x 160 cm',
            'medium' => 'Oil on Canvas',
            'year_created' => 1857,
            'image_url' => 'diponegoro.jpg',
        ]);

        // Loop untuk sisa 49 data lainnya agar cepat
        for ($i = 1; $i <= 49; $i++) {
            \App\Models\Artwork::create([
                'artist_id' => $artistIds[array_rand($artistIds)],
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'title' => "Masterpiece Item $i",
                'slug' => "masterpiece-item-$i",
                'description' => "Description for masterpiece number $i.",
                'price' => rand(1000000, 50000000),
                'dimensions' => '100 cm x 100 cm',
                'medium' => 'Oil on Canvas',
                'year_created' => rand(1500, 2024),
                'image_url' => "artwork-$i.jpg",
            ]);
        }
    }
}
