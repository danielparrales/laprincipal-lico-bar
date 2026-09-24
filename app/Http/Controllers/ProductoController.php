<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function create()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/')->with('error', 'No tienes permisos de administrador.');
        }

        $categorias = Categoria::all();

        return view('productos.crear', compact('categorias'));
    }

    public function store(Request $request)
{
    if (!auth()->check() || !auth()->user()->is_admin) {
        return redirect('/')->with('error', 'No tienes permisos de administrador.');
    }

    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:1000', // 👈 1. Validar la descripción
        'precio' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'categoria_id' => 'required|exists:categorias,id',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $imagen = null;

    if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen')->store('productos', 'public');
    }

    Producto::create([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion, // 👈 2. Guardar la descripción
        'precio' => $request->precio,
        'stock' => $request->stock,
        'categoria_id' => $request->categoria_id,
        'imagen' => $imagen,
    ]);

    return redirect('/productos/gestionar')->with('success', '¡Producto agregado con éxito!');
}

    public function indexAdmin()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $productos = Producto::orderByDesc('id')->get();

        return view('productos.gestionar', compact('productos'));
    }

    public function destroy(Producto $producto)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return back()->with('success', 'Producto eliminado');
    }

    public function edit(Producto $producto)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $categorias = Categoria::all();

        return view('productos.editar', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagen = $producto->imagen;

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'categoria_id' => $request->categoria_id,
            'imagen' => $imagen,
        ]);

        return redirect('/productos/gestionar')->with('success', 'Producto actualizado correctamente');
    }

    public function inventario()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect('/');
        }

        // Obtenemos los productos con su categoría y los enviamos a la vista
$productos = \App\Models\Producto::with('categoria')->get();
        return view('admin.inventario.index', compact('productos'));
    }
}