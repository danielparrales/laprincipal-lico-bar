<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function storeRapido(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255|unique:categorias,nombre',
    ]);

    $categoria = Categoria::create([
        'nombre' => $request->nombre,
    ]);

    return response()->json([
        'success' => true,
        'id' => $categoria->id,
        'nombre' => $categoria->nombre
    ]);
}
    // Mostrar la lista y el formulario para crear categorías
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    // Guardar una nueva categoría
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias',
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
        ]);

        return back()->with('success', 'Categoría creada con éxito');
    }

    // Eliminar una categoría
    public function destroy(Categoria $categoria)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $categoria->delete();
        return back()->with('success', 'Categoría eliminada');
    }
}