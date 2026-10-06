<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PedidoController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cliente' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'min:8', 'max:25'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.producto_id' => ['required', 'integer', 'distinct', 'exists:productos,id'],
            'items.*.cantidad' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $pedido = DB::transaction(function () use ($validated) {
            $items = [];
            $total = 0;
            $lineas = collect($validated['items'])->sortBy('producto_id');

            foreach ($lineas as $linea) {
                $producto = Producto::query()
                    ->whereKey($linea['producto_id'])
                    ->lockForUpdate()
                    ->firstOrFail();
                $cantidad = (int) $linea['cantidad'];

                if ($producto->stock < $cantidad) {
                    throw ValidationException::withMessages([
                        'items' => "No hay stock suficiente de {$producto->nombre}.",
                    ]);
                }

                $precio = (float) $producto->precio;
                $subtotal = round($precio * $cantidad, 2);
                $total += $subtotal;

                $items[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'subtotal' => $subtotal,
                ];
            }

            $pedido = Pedido::create([
                'cliente' => $validated['cliente'],
                'telefono' => $validated['telefono'],
                'total' => $total,
                'estado' => 'Pendiente',
            ]);

            foreach ($items as $item) {
                PedidoItem::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item['producto']->id,
                    'nombre_producto' => $item['producto']->nombre,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);

                $item['producto']->decrement('stock', $item['cantidad']);
            }

            return $pedido->load('items');
        });

        $mensaje = "Hola, quiero confirmar el pedido #{$pedido->id}.\n";
        $mensaje .= "Cliente: {$pedido->cliente}\nTeléfono: {$pedido->telefono}\n\n";

        foreach ($pedido->items as $item) {
            $mensaje .= "{$item->cantidad}x {$item->nombre_producto} - $".number_format((float) $item->subtotal, 2)."\n";
        }

        $mensaje .= "\nTotal: $".number_format((float) $pedido->total, 2);

        return response()->json([
            'pedido_id' => $pedido->id,
            'whatsapp_url' => 'https://wa.me/593984088716?'.http_build_query(['text' => $mensaje]),
        ], 201);
    }
}