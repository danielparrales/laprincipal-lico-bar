<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos - Licorería El Vecino</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#09090b] text-zinc-100 font-sans antialiased selection:bg-orange-500 selection:text-white">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR LATERAL -->
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

                    <a href="{{ route('pedidos.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm border border-orange-500/20">
                        <span class="flex items-center gap-3">🛍️ Pedidos</span>
                        <span class="bg-zinc-800 text-zinc-300 text-xs px-2 py-0.5 rounded-full font-bold">{{ \App\Models\Pedido::count() }}</span>
                    </a>

                    <a href="{{ route('inventario.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">📦 Inventario</span>
                        <span class="bg-zinc-800 text-zinc-300 text-xs px-2 py-0.5 rounded-full font-bold">{{ \App\Models\Producto::count() }}</span>
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

            <!-- Botones Inferiores -->
            <div class="p-4 border-t border-zinc-800/60 space-y-2">
                <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 w-full bg-zinc-800 hover:bg-zinc-700 text-zinc-200 py-2.5 rounded-xl text-xs font-bold transition">
                    ← Volver a la Tienda
                </a>
                
                <!-- Formulario de Cerrar Sesión -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 py-2.5 rounded-xl text-xs font-bold transition">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="flex-1 flex flex-col h-screen overflow-y-auto p-8">
            <header class="mb-8">
                <h2 class="text-2xl font-bold text-white">Gestión de Pedidos</h2>
                <p class="text-xs text-zinc-400">Aquí podrás ver y administrar los pedidos realizados en la licorería.</p>
            </header>

            <!-- Contenedor Principal / Tabla Vacía o de Ejemplo -->
            <div class="bg-[#18181b] border border-zinc-800/80 rounded-2xl p-6 shadow-xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-white text-base">Lista de Pedidos Recientes</h3>
                    <span class="text-xs text-zinc-400">Mostrando registros</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-800 text-zinc-400 text-xs">
                                <th class="py-3">#ID Pedido</th>
                                <th class="py-3">Cliente</th>
                                <th class="py-3">Fecha</th>
                                <th class="py-3">Total</th>
                                <th class="py-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-zinc-800/50">
                                @forelse($pedidos as $pedido)
                                    <tr>
                                        <td class="py-4 font-semibold text-white">#{{ $pedido->id }}</td>
                                        <td class="py-4 text-zinc-300">{{ $pedido->cliente }}</td>
                                        <td class="py-4 text-zinc-400 text-xs">{{ $pedido->created_at->format('d/m/Y') }}</td>
                                        <td class="py-4 text-orange-400 font-bold">${{ number_format($pedido->total, 2) }}</td>
                                        <td class="py-4">
    <form action="{{ route('pedidos.updateEstado', $pedido) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="group relative inline-flex items-center cursor-pointer transition transform active:scale-95" title="Hacer clic para cambiar estado">
            @if($pedido->estado == 'Completado')
                <span class="bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 px-2.5 py-1 rounded-lg text-xs font-bold border border-emerald-500/20 transition">
                    {{ $pedido->estado }} 🔄
                </span>
            @else
                <span class="bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 px-2.5 py-1 rounded-lg text-xs font-bold border border-amber-500/20 transition">
                    {{ $pedido->estado }} 🔄
                </span>
            @endif
        </button>
    </form>
</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-zinc-500 text-xs">
                                            No hay pedidos registrados todavía.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>
</body>
</html>