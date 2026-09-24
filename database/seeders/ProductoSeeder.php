<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::create([
            'nombre' => 'Arroz 1kg',
            'precio' => 1.50
        ]);

        Producto::create([
            'nombre' => 'Aceite de Girasol 1L',
            'precio' => 3.20
        ]);

        Producto::create([
            'nombre' => 'Azúcar 1kg',
            'precio' => 1.25
        ]);
    }
}