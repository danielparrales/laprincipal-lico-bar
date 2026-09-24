<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Licorería El Vecino</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0b0e] text-zinc-100 font-sans antialiased">

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

                <!-- Menú de Navegación -->
                <nav class="p-4 space-y-1">
                    <!-- Inicio -->
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">📊 Inicio</span>
                    </a>

                    <!-- Pedidos -->
                    <a href="{{ route('pedidos.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">🛍️ Pedidos</span>
                    </a>

                    <!-- Inventario -->
                    <a href="{{ route('inventario.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">📦 Inventario</span>
                    </a>

                    <!-- Clientes -->
                    <a href="#" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">👥 Clientes</span>
                    </a>

                    <!-- Productos (Activo aquí) -->
                    <a href="{{ route('productos.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm border border-orange-500/20">
                        <span class="flex items-center gap-3">🍾 Productos</span>
                    </a>


                    <!-- Ajustes -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">⚙️ Ajustes</span>
                    </a>
                </nav>
            </div>

            <!-- Botones Inferiores -->
            <div class="p-4 border-t border-zinc-800/60 space-y-2">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 w-full bg-zinc-800 hover:bg-zinc-700 text-zinc-200 py-2.5 rounded-xl text-xs font-bold transition">
                    ← Volver a la Tienda
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 py-2.5 rounded-xl text-xs font-bold transition">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 flex flex-col overflow-y-auto">
            
            <!-- Header superior -->
            <header class="bg-[#121215]/80 backdrop-blur-md border-b border-zinc-800 p-6 flex justify-between items-center sticky top-0 z-10">
                <div>
                    <h2 class="text-xl font-bold text-white">Gestionar Catálogo de Productos</h2>
                    <p class="text-xs text-zinc-400">Administra los productos disponibles en la tienda</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('productos.create') }}" class="bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-lg shadow-orange-600/20">
                        + Nuevo Producto
                    </a>
                </div>
            </header>

            <!-- Cuerpo de la Tabla -->
            <div class="p-8">
                <div class="bg-[#121215] border border-zinc-800/80 rounded-2xl p-6 shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-zinc-800 text-zinc-400 text-[11px] uppercase tracking-wider">
                                    <th class="py-3 px-4 font-semibold">Producto</th>
                                    <th class="py-3 px-4 font-semibold">Categoría</th>
                                    <th class="py-3 px-4 font-semibold">Precio</th>
                                    <th class="py-3 px-4 font-semibold text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-800/60 text-sm">
                                
                                @isset($productos)
                                    @forelse($productos as $producto)
                                    <tr class="hover:bg-zinc-800/30 transition">
                                        <td class="py-4 px-4 font-medium text-white">{{ $producto->nombre }}</td>
                                        <td class="py-4 px-4 text-zinc-300">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                        <td class="py-4 px-4 text-emerald-400 font-semibold">${{ number_format($producto->precio, 2) }}</td>
                                        <td class="py-4 px-4 text-right space-x-1">
                                            <a href="{{ route('productos.edit', $producto) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/20 transition">Editar</a>
                                            
                                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 transition">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-zinc-500 text-sm">No hay productos registrados.</td>
                                    </tr>
                                    @endforelse
                                @endisset

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>

    </div>

</body>
</html>