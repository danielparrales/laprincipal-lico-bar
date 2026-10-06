<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // <-- Importante para conectar con la base de datos
use App\Models\Categoria; // <-- 1. Importamos el modelo de Categorías

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 2. Traemos todas las categorías para mostrarlas en las tarjetas de arriba
        $categorias = Categoria::all();

        // 3. Iniciamos la consulta para los productos
        $query = Producto::query();

        // 4. Si el usuario hizo clic en una categoría, filtramos los productos
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria_id', $request->categoria);
        }

        // 5. Obtenemos los productos (ya sea filtrados o todos si no hay selección)
        $productos = $query->get();

        // 6. Enviamos ambas variables (productos y categorías) a la vista Bienvenida
        return view('bienvenida', compact('productos', 'categorias'));
    }
}