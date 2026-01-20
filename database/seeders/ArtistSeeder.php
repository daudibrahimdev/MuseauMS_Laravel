<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $artists = [
            ['name' => 'Leonardo da Vinci', 'nationality' => 'Italian', 'bio' => 'High Renaissance polymath.'],
            ['name' => 'Vincent van Gogh', 'nationality' => 'Dutch', 'bio' => 'Post-Impressionist painter.'],
            ['name' => 'Raden Saleh', 'nationality' => 'Indonesian', 'bio' => 'Pioneer of Romanticism in Indonesia.'],
            ['name' => 'Affandi', 'nationality' => 'Indonesian', 'bio' => 'Maestro of Indonesian Expressionism.'],
            ['name' => 'Basoeki Abdullah', 'nationality' => 'Indonesian', 'bio' => 'Famous Indonesian realist painter.'],
            ['name' => 'Pablo Picasso', 'nationality' => 'Spanish', 'bio' => 'Co-founder of Cubism.'],
            ['name' => 'Salvador Dalí', 'nationality' => 'Spanish', 'bio' => 'Icon of Surrealism.'],
            ['name' => 'Claude Monet', 'nationality' => 'French', 'bio' => 'Founder of Impressionism.'],
            ['name' => 'Frida Kahlo', 'nationality' => 'Mexican', 'bio' => 'Known for self-portraits and surrealism.'],
            ['name' => 'Johannes Vermeer', 'nationality' => 'Dutch', 'bio' => 'Master of domestic interior scenes.'],
            ['name' => 'Rembrandt', 'nationality' => 'Dutch', 'bio' => 'Greatest storyteller in art history.'],
            ['name' => 'S. Sudjojono', 'nationality' => 'Indonesian', 'bio' => 'Father of Modern Indonesian Art.'],
            ['name' => 'Hendra Gunawan', 'nationality' => 'Indonesian', 'bio' => 'Painter of Indonesian common people.'],
            ['name' => 'Andy Warhol', 'nationality' => 'American', 'bio' => 'Leading figure in Pop Art.'],
            ['name' => 'Michelangelo', 'nationality' => 'Italian', 'bio' => 'Legendary sculptor and painter.'],
        ];

        foreach ($artists as $art) {
            \App\Models\Artist::create($art);
        }
    }
}
