<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generos = [
            ['nome' => 'Ação'],
            ['nome' => 'Comédia'],
            ['nome' => 'Drama'],
            ['nome' => 'Terror'],
            ['nome' => 'Ficção Científica'],
            ['nome' => 'Romance'],
            ['nome' => 'Aventura'],
            ['nome' => 'Suspense'],
            ['nome' => 'Animação'],
            ['nome' => 'Documentário'],
        ];

        foreach ($generos as $genero) {
            DB::table('genres')->insert([
                'nome' => $genero['nome'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}