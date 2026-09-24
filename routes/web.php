<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Controllers\PedidoController;
use App\Models\Pedido;
use App\Models\User;

// 1. Tu tienda principal (pública)
Route::get('/', [HomeController::class, 'index']);

// 2. Rutas protegidas para USUARIOS LOGUEADOS (Redirección inteligente en el Dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            $totalProductos = Producto::count();
            $productosBajosStock = Producto::where('stock', '<=', 5)->get();
            $totalCategorias = Categoria::count();
            $ultimosProductos = Producto::latest()->take(5)->get();
            $totalPedidosPendientes = Pedido::where('estado', 'Pendiente')->count();
            $totalClientes = User::count();

            return view('admin.dashboard', compact(
                'totalProductos',
                'productosBajosStock',
                'totalCategorias',
                'ultimosProductos',
                'totalPedidosPendientes',
                'totalClientes'
            ));
        }

        return view('dashboard');
    })->name('dashboard');

    // Gestión de Pedidos (Ruta única y optimizada)
    Route::get('/admin/pedidos', function () {
        $pedidos = Pedido::latest()->get(); // Trae todos los pedidos ordenados del más nuevo al más viejo
        return view('admin.pedidos.index', compact('pedidos'));
    })->name('pedidos.index');

    Route::patch('/admin/pedidos/{pedido}/estado', function (App\Models\Pedido $pedido) {
        // Alterna el estado actual
        $pedido->estado = $pedido->estado == 'Pendiente' ? 'Completado' : 'Pendiente';
        $pedido->save();

        return redirect()->route('pedidos.index');
    })->name('pedidos.updateEstado');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Rutas exclusivas para el ADMINISTRADOR (Gestión de Productos, Categorías y Clientes)
Route::middleware(['auth'])->group(function () {
    
    // Gestión de Productos e Inventario
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/gestionar', [ProductoController::class, 'indexAdmin'])->name('productos.index');
    Route::get('/inventario', [ProductoController::class, 'inventario'])->name('inventario.index');
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Gestión de Categorías
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::post('/categorias/store-rapido', [CategoriaController::class, 'storeRapido'])->name('categorias.store.rapido');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    // Gestión de Clientes
    Route::get('/admin/clientes', function () {
        $clientes = User::latest()->get();
        return view('admin.clientes.index', compact('clientes'));
    })->name('clientes.index');

    Route::get('/admin/marketing', function () {
        $totalProductos = Producto::count();
        $stockTotal = Producto::sum('stock');
        $valorInventario = Producto::sum(\DB::raw('precio * stock'));
        $productosBajoStock = Producto::where('stock', '<=', 5)->count();
        $categorias = Categoria::withCount('productos')->get();

        return view('admin.marketing.index', compact(
            'totalProductos',
            'stockTotal',
            'valorInventario',
            'productosBajoStock',
            'categorias'
        ));
    })->name('marketing.index');

    Route::get('/admin/informes', function () {
        $totalProductos = Producto::count();
        $totalClientes = User::count();
        $totalPedidos = Pedido::count();
        $ventasTotales = Pedido::sum('total');
        $pedidosPendientes = Pedido::where('estado', 'Pendiente')->count();
        $ultimosPedidos = Pedido::latest()->take(5)->get();

        $topProductos = Producto::orderByDesc('stock')->take(5)->get()->map(function ($producto, $index) {
            return [
                'posicion' => $index + 1,
                'nombre' => $producto->nombre,
                'unidades' => (int) $producto->stock,
            ];
        });

        $productosBajoStock = Producto::where('stock', '<=', 10)->orderBy('stock', 'asc')->take(5)->get()->map(function ($producto) {
            return [
                'nombre' => $producto->nombre,
                'stock' => (int) $producto->stock,
                'minimo' => 10,
            ];
        });

        $clientesTop = User::orderByDesc('id')->take(5)->get()->map(function ($user, $index) {
            return [
                'posicion' => $index + 1,
                'nombre' => $user->name,
                'monto' => 0,
            ];
        });

        $categoriasInforme = Categoria::withCount('productos')->get()->map(function ($categoria) {
            return [
                'nombre' => $categoria->nombre,
                'valor' => max(5, (int) $categoria->productos_count * 10),
            ];
        });

        return view('admin.informes.index', compact(
            'totalProductos',
            'totalClientes',
            'totalPedidos',
            'ventasTotales',
            'pedidosPendientes',
            'ultimosPedidos',
            'topProductos',
            'productosBajoStock',
            'clientesTop',
            'categoriasInforme'
        ));
    })->name('informes.index');

    Route::get('/admin/ajustes', function () {
        return redirect()->route('profile.edit');
    })->name('ajustes.index');
});

require __DIR__.'/auth.php';