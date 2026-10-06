<?php

use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;

it('creates a pending order using database prices and reserves stock', function () {
    $category = Categoria::create(['nombre' => 'Whisky']);
    $product = Producto::create([
        'nombre' => 'Whisky de prueba',
        'precio' => 13.75,
        'stock' => 5,
        'categoria_id' => $category->id,
    ]);

    $response = $this->postJson('/pedidos', [
        'cliente' => 'Cliente de prueba',
        'telefono' => '0991234567',
        'items' => [
            ['producto_id' => $product->id, 'cantidad' => 2],
        ],
        'precio' => 0,
    ]);

    $response->assertCreated()
        ->assertJsonPath('pedido_id', 1)
        ->assertJsonPath('whatsapp_url', fn ($url) => str_starts_with($url, 'https://wa.me/'));

    $pedido = Pedido::firstOrFail();
    expect((float) $pedido->total)->toBe(27.5);
    expect(PedidoItem::where('pedido_id', $pedido->id)->value('cantidad'))->toBe(2);
    expect($product->fresh()->stock)->toBe(3);
});

it('rejects an order above available stock without saving it', function () {
    $category = Categoria::create(['nombre' => 'Vinos']);
    $product = Producto::create([
        'nombre' => 'Vino de prueba',
        'precio' => 8.00,
        'stock' => 1,
        'categoria_id' => $category->id,
    ]);

    $response = $this->postJson('/pedidos', [
        'cliente' => 'Cliente de prueba',
        'telefono' => '0991234567',
        'items' => [
            ['producto_id' => $product->id, 'cantidad' => 2],
        ],
    ]);

    $response->assertUnprocessable();
    $this->assertDatabaseCount('pedidos', 0);
    expect($product->fresh()->stock)->toBe(1);
});