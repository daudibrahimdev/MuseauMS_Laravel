<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $categories = [
            ['name' => 'Renaissance', 'slug' => 'renaissance'],
            ['name' => 'Baroque', 'slug' => 'baroque'],
            ['name' => 'Impressionism', 'slug' => 'impressionism'],
            ['name' => 'Post-Impressionism', 'slug' => 'post-impressionism'],
            ['name' => 'Cubism', 'slug' => 'cubism'],
            ['name' => 'Surrealism', 'slug' => 'surrealism'],
            ['name' => 'Romanticism', 'slug' => 'romanticism'],
            ['name' => 'Modern Art', 'slug' => 'modern-art'],
            ['name' => 'Contemporary Art', 'slug' => 'contemporary-art'],
            ['name' => 'Abstract', 'slug' => 'abstract'],
            ['name' => 'Realism', 'slug' => 'realism'],
            ['name' => 'Pop Art', 'slug' => 'pop-art'],
            ['name' => 'Expressionism', 'slug' => 'expressionism'],
            ['name' => 'Indonesian Modernism', 'slug' => 'indonesian-modernism'],
            ['name' => 'Traditional Indonesian', 'slug' => 'traditional-indonesian'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }
    }
}
