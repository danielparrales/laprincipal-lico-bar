<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

it('shows products and categories stored in the database', function () {
    $category = \App\Models\Categoria::create(['nombre' => 'Whisky']);
    \App\Models\Producto::create([
        'nombre' => 'Producto de prueba',
        'precio' => 12.50,
        'stock' => 4,
        'categoria_id' => $category->id,
    ]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Whisky');
    $response->assertSee('Producto de prueba');
});

it('seeds the storefront categories without duplicates', function () {
    $this->seed(\Database\Seeders\CategorySeeder::class);
    $this->seed(\Database\Seeders\CategorySeeder::class);

    $this->assertDatabaseCount('categorias', 5);
});
