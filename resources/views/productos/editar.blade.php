<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Licorería El Vecino</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0b0e] text-zinc-100 font-sans antialiased min-h-screen flex flex-col justify-between">

    <!-- HEADER SUPERIOR -->
    <header class="bg-[#121215]/80 backdrop-blur-md border-b border-zinc-800 p-6 flex justify-between items-center sticky top-0 z-10">
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-tr from-orange-600 to-amber-500 p-2 rounded-xl text-white font-bold">🥃</div>
            <div>
                <h1 class="font-extrabold text-sm tracking-wide text-white">Licorería El Vecino</h1>
                <p class="text-[10px] text-zinc-400">Panel de Administración</p>
            </div>
        </div>
        <div>
            <a href="{{ route('productos.index') }}" class="text-xs bg-zinc-800 hover:bg-zinc-700 text-zinc-300 px-3.5 py-2 rounded-xl font-semibold transition border border-zinc-700/60">
                ← Volver al Panel
            </a>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-xl">
            
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white tracking-wide">Editar Producto</h2>
                <p class="text-xs text-zinc-400 mt-1">Actualiza los datos del producto en el inventario</p>
            </div>

            <!-- Formulario con diseño oscuro -->
            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="bg-[#121215] border border-zinc-800/80 rounded-2xl p-6 shadow-xl space-y-5">
                @csrf
                @method('PUT')
                
                <!-- Nombre -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Nombre del producto</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition">
                </div>
                
                <!-- Precio -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}" required
                        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition">
                </div>

                <!-- Stock / Unidades -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Stock / Unidades</label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock ?? 0) }}" min="0" required
                        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition">
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Categoría</label>
                    <select name="categoria_id" required
                        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition">
                        <option value="" disabled class="bg-zinc-900 text-zinc-500">Selecciona una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" class="bg-zinc-900 text-white" {{ (old('categoria_id', $producto->categoria_id) == $categoria->id) ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Imagen -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Imagen del Producto</label>
                    <input type="file" name="imagen" accept="image/*"
                        class="w-full text-xs text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-500/10 file:text-orange-500 hover:file:bg-orange-500/20 transition cursor-pointer bg-[#18181b] border border-zinc-800 rounded-xl">
                    
                    @if($producto->imagen)
                        <div class="mt-3 flex items-center gap-3 bg-zinc-900/50 p-2.5 rounded-xl border border-zinc-800">
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="h-14 w-14 object-cover rounded-lg border border-zinc-700">
                            <span class="text-xs text-zinc-400">Imagen actual guardada en el sistema</span>
                        </div>
                    @endif
                </div>

                <!-- Botón de Guardar -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold py-3 px-4 rounded-xl text-sm transition shadow-lg shadow-orange-500/10">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="text-center py-6 text-xs text-zinc-500 border-t border-zinc-800/60">
        Licorería El Vecino &copy; 2026 - Panel de Control
    </footer>

</body>
</html>