<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Licores', 'Whisky', 'Vinos', 'Cervezas', 'Champagne'] as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }
    }
}