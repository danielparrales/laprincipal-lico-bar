<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Licorería El Vecino</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#09090b] text-zinc-100 font-sans antialiased selection:bg-orange-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR LATERAL -->
        <aside class="w-64 bg-[#121215] border-r border-zinc-800 flex flex-col justify-between hidden md:flex">
            <div>
                <!-- Logo -->
                <div class="p-6 flex items-center gap-3 border-b border-zinc-800/60">
                    <div class="bg-gradient-to-tr from-orange-600 to-amber-500 p-2 rounded-xl text-white font-bold">🥃</div>
                    <div>
                        <h1 class="font-extrabold text-sm tracking-wide text-white">Licorería El Vecino</h1>
                        <p class="text-[10px] text-zinc-400">Panel de Administración</p>
                    </div>
                </div>

               
                <!-- Menú de Navegación Funcional -->
<nav class="p-4 space-y-1">
    <!-- Inicio (Dashboard) -->
    <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm border border-orange-500/20">
        <span class="flex items-center gap-3">📊 Inicio</span>
    </a>

    <a href="{{ route('pedidos.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
        <span class="flex items-center gap-3">🛍️ Pedidos</span>
        <span class="bg-zinc-800 text-zinc-300 text-xs px-2 py-0.5 rounded-full">{{ \App\Models\Pedido::count() }}</span>
    </a>

    <a href="{{ route('inventario.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
        <span class="flex items-center gap-3">📦 Inventario</span>
        <span class="bg-zinc-800 text-zinc-300 text-xs px-2 py-0.5 rounded-full">{{ $totalProductos ?? 0 }}</span>
    </a>

    <a href="{{ route('clientes.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-xs font-medium transition">
        👥 Clientes
    </a>

    <a href="{{ route('productos.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
        <span class="flex items-center gap-3">🍾 Productos</span>
    </a>


    <a href="{{ route('profile.edit') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
        <span class="flex items-center gap-3">⚙️ Ajustes</span>
    </a>
</nav>
            </div>

           <!-- Botones Inferiores: Volver a la Tienda y Cerrar Sesión -->
            <div class="p-4 border-t border-zinc-800/60 space-y-2">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 w-full bg-zinc-800 hover:bg-zinc-700 text-zinc-200 py-2.5 rounded-xl text-xs font-bold transition">
                    ← Volver a la Tienda
                </a>

                <!-- Formulario de Cerrar Sesión (Obligatorio POST en Laravel) -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 py-2.5 rounded-xl text-xs font-bold transition">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 flex flex-col h-screen overflow-y-auto">
            
            <!-- Header Superior -->
            <header class="bg-[#121215]/80 backdrop-blur-md border-b border-zinc-800 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
                <div>
                    <h2 class="text-lg font-bold text-white">Panel de Administración</h2>
                    <p class="text-xs text-zinc-400">Resumen general y métricas del negocio</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-semibold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-orange-500 font-bold">Administrador</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-500 to-amber-500 flex items-center justify-center font-bold text-white shadow-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Cuerpo del Panel -->
            <div class="p-8 space-y-6">
                
                <!-- Tarjetas de Métricas Superiores -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    <!-- Tarjeta 1: Total Productos (Real) -->
                    <div class="bg-[#18181b] border border-zinc-800/80 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-zinc-400">Total Productos</p>
                                <h3 class="text-2xl font-black text-white mt-1">{{ $totalProductos ?? 0 }}</h3>
                            </div>
                            <span class="p-2 bg-orange-500/10 text-orange-500 rounded-xl text-lg">📦</span>
                        </div>
                        <div class="mt-3 flex items-center gap-2 text-xs">
                            <span class="text-zinc-500">Registrados en tienda</span>
                        </div>
                    </div>

                    <!-- Tarjeta 2 -->
                    <div class="bg-[#18181b] border border-zinc-800/80 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-zinc-400">Pedidos Pendientes</p>
                                <h3 class="text-2xl font-black text-white mt-1">15</h3>
                            </div>
                            <span class="p-2 bg-amber-500/10 text-amber-500 rounded-xl text-lg">📦</span>
                        </div>
                        <div class="mt-3 flex items-center gap-2 text-xs">
                            <span class="text-amber-400 font-bold flex items-center">↗ +12%</span>
                            <span class="text-zinc-500">en proceso</span>
                        </div>
                    </div>

                    <!-- Tarjeta 3 -->
                    <div class="bg-[#18181b] border border-zinc-800/80 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-zinc-400">Productos Bajos Stock</p>
                                <h3 class="text-2xl font-black text-white mt-1">{{ isset($productosBajosStock) ? count($productosBajosStock) : 0 }}</h3>
                            </div>
                            <span class="p-2 bg-red-500/10 text-red-500 rounded-xl text-lg">⚠️</span>
                        </div>
                        <div class="mt-3 flex items-center gap-2 text-xs">
                            <span class="text-red-400 font-bold flex items-center">⚠ Alerta</span>
                            <span class="text-zinc-500">requiere reposición</span>
                        </div>
                    </div>

                    <!-- Tarjeta 4 -->
                    <div class="bg-[#18181b] border border-zinc-800/80 rounded-2xl p-5 shadow-xl relative overflow-hidden">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-medium text-zinc-400">Nuevos Clientes</p>
                                <h3 class="text-2xl font-black text-white mt-1">7</h3>
                            </div>
                            <span class="p-2 bg-purple-500/10 text-purple-400 rounded-xl text-lg">👥</span>
                        </div>
                        <div class="mt-3 flex items-center gap-2 text-xs">
                            <span class="text-purple-400 font-bold flex items-center">↗ +17%</span>
                            <span class="text-zinc-500">registrados hoy</span>
                        </div>
                    </div>

                </div>

                <!-- Sección Inferior: Tablas y Accesos -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Tabla de Últimos Productos Añadidos (Real) -->
                    <div class="lg:col-span-2 bg-[#18181b] border border-zinc-800/80 rounded-2xl p-6 shadow-xl">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-white text-base">Últimos Productos Añadidos</h3>
                            <a href="{{ route('productos.index') }}" class="text-xs font-semibold text-orange-500 hover:underline">Ver inventario →</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-zinc-800 text-zinc-400 text-xs">
                                        <th class="py-3">#ID</th>
                                        <th class="py-3">Producto</th>
                                        <th class="py-3">Fecha</th>
                                        <th class="py-3">Precio</th>
                                        <th class="py-3">Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-zinc-800/50">
                                    @forelse($ultimosProductos as $item)
                                        <tr>
                                            <td class="py-3 font-semibold text-white">#{{ $item->id }}</td>
                                            <td class="py-3 text-zinc-300">{{ $item->nombre ?? $item->name }}</td>
                                            <td class="py-3 text-zinc-400 text-xs">{{ $item->created_at ? $item->created_at->format('d/m/Y') : 'N/D' }}</td>
                                            <td class="py-3 text-orange-400 font-bold">${{ number_format($item->precio ?? $item->price, 2) }}</td>
                                            <td class="py-3">
                                                <span class="bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-lg text-xs font-bold">
                                                    {{ $item->stock }} un.
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-4 text-center text-zinc-500 text-xs">No hay productos registrados todavía.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Inventario Crítico (Real) -->
                    <div class="bg-[#18181b] border border-zinc-800/80 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-white text-base mb-4">Inventario Crítico</h3>
                            <div class="space-y-4 text-sm">
                                @forelse($productosBajosStock as $prod)
                                    <div>
                                        <div class="flex justify-between mb-1 text-xs">
                                            <span class="text-zinc-300 font-medium">{{ $prod->nombre ?? $prod->name }}</span>
                                            <span class="text-red-400 font-bold">{{ $prod->stock }} un.</span>
                                        </div>
                                        <div class="w-full bg-zinc-800 h-2 rounded-full overflow-hidden">
                                            <div class="bg-red-500 h-full" style="width: {{ min($prod->stock * 15, 100) }}%"></div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-zinc-500">¡Excelente! No hay productos con stock crítico.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-zinc-800">
                            <a href="{{ route('productos.index') }}" class="block w-full text-center bg-gradient-to-r from-orange-600 to-amber-500 text-white py-2.5 rounded-xl font-bold text-xs shadow-lg shadow-orange-600/20 hover:opacity-90 transition">
                                Administrar Productos →
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </main>

    </div>
</body>
</html>