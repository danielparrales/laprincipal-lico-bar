<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // <-- Importante para conectar con la base de datos
use App\Models\Categoria; // <-- 1. Importamos el modelo de Categorías

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::withCount('productos')->orderBy('nombre')->get();
        $productos = Producto::with('categoria')
            ->when($request->filled('categoria'), fn ($query) => $query->where('categoria_id', $request->query('categoria')))
            ->orderBy('nombre')
            ->get();

        return view('bienvenida', compact('productos', 'categorias'));
    }
}