<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Licorería El Vecino</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0b0e] text-zinc-100 font-sans antialiased min-h-screen flex">

    <aside class="w-64 bg-[#121215] border-r border-zinc-800 flex flex-col justify-between p-6 h-screen sticky top-0">
        <div class="space-y-8">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-tr from-orange-600 to-amber-500 p-2 rounded-xl text-white font-bold">🥃</div>
                <div>
                    <h1 class="font-extrabold text-sm tracking-wide text-white">Licorería El Vecino</h1>
                    <p class="text-[10px] text-zinc-400">Panel de Administración</p>
                </div>
            </div>

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

                    <a href="{{ route('clientes.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl bg-orange-500/10 text-orange-500 font-semibold text-sm border border-orange-500/20">
                        <span class="flex items-center gap-3">👥 Clientes</span>
                    </a>

                    <a href="{{ route('productos.index') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">🍾 Productos</span>
                    </a>

    

                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-800/50 text-sm transition">
                        <span class="flex items-center gap-3">⚙️ Ajustes</span>
                    </a>
                </nav>
        </div>

        <div class="space-y-2 pt-4 border-t border-zinc-800/80">
            <a href="{{ url('/') }}" class="w-full block text-center text-xs bg-zinc-800 hover:bg-zinc-700 text-zinc-300 py-2.5 rounded-xl font-semibold transition border border-zinc-700/60">
                ← Volver a la Tienda
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-xs bg-red-500/10 hover:bg-red-500/20 text-red-500 py-2.5 rounded-xl font-semibold transition border border-red-500/20">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white tracking-wide">Gestión de Clientes</h2>
                <p class="text-xs text-zinc-400 mt-1">Lista de usuarios registrados y compradores en la plataforma</p>
            </div>
        </div>

        <div class="bg-[#121215] border border-zinc-800/80 rounded-2xl shadow-xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-zinc-800 text-[11px] text-zinc-400 uppercase tracking-wider bg-zinc-900/50">
                        <th class="py-4 px-6 font-semibold">Nombre Completo</th>
                        <th class="py-4 px-6 font-semibold">Correo Electrónico</th>
                        <th class="py-4 px-6 font-semibold">Estado</th>
                        <th class="py-4 px-6 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60 text-sm">
                    @forelse($clientes as $cliente)
                        <tr class="hover:bg-zinc-900/30 transition">
                            <td class="py-4 px-6 font-medium text-white flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-500/20 text-orange-500 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($cliente->name, 0, 1)) }}
                                </div>
                                {{ $cliente->name }}
                            </td>
                            <td class="py-4 px-6 text-zinc-400 text-xs">{{ $cliente->email }}</td>
                            <td class="py-4 px-6">
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-1 rounded-full text-[10px] font-semibold">Activo</span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <span class="text-xs text-zinc-500">Registrado</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-zinc-500 text-xs">No hay clientes registrados en el sistema.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>