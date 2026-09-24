<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - Licorería El Vecino</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- 👈 AGREGAR ESTA LÍNEA DE ALPINE.JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            <a href="{{ route('inventario.index') }}" class="text-xs bg-zinc-800 hover:bg-zinc-700 text-zinc-300 px-3.5 py-2 rounded-xl font-semibold transition border border-zinc-700/60">
                ← Volver al Inventario
            </a>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-xl">
            
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white tracking-wide">📦 Agregar Producto</h2>
                <p class="text-xs text-zinc-400 mt-1">Registra un nuevo producto para el inventario de la tienda</p>
            </div>

            <!-- Formulario con diseño oscuro unificado -->
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="bg-[#121215] border border-zinc-800/80 rounded-2xl p-6 shadow-xl space-y-5">
                @csrf

                <!-- Nombre del Producto -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Nombre del Producto</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition"
                        placeholder="Ej: Whisky Old Parr 1L">
                </div>
                <!-- Descripción del Producto -->
<div>
    <label class="block text-xs font-semibold text-zinc-300 mb-2">Descripción (Visible para clientes)</label>
    <textarea name="descripcion" rows="3"
        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition resize-none"
        placeholder="Ej: Whisky escocés de 12 años, notas ahumadas y sabor excepcional...">{{ old('descripcion') }}</textarea>
</div>
                



                <!-- Precio -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Precio ($)</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" required
                        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition"
                        placeholder="Ej: 35.00">
                </div>

                <!-- Stock / Unidades -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Stock / Unidades</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                        class="w-full bg-[#18181b] border border-zinc-800 rounded-xl px-4 py-2.5 text-white text-sm focus:border-orange-500 focus:outline-none transition"
                        placeholder="Ej: 15">
                </div>

                <!-- CATEGORÍA CON OPCIÓN DE AGREGAR NUEVA -->
                <div class="mb-4" x-data="{ modalCategoriaAbierto: false, nuevaCategoria: '' }">
                    <label class="block text-white text-sm font-medium mb-2">Categoría</label>
                    
                    <div class="flex gap-2">
                        <!-- Selector de categorías existentes -->
                        <select name="categoria_id" id="select-categoria" class="w-full bg-[#18181b] border border-zinc-800 text-white rounded-xl p-3 focus:outline-none focus:border-orange-500">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>

                        <!-- Botón con Alpine.js funcional -->
                        <button type="button" @click="modalCategoriaAbierto = true" class="bg-orange-500 hover:bg-orange-600 text-white px-4 rounded-xl font-bold transition flex items-center justify-center text-lg" title="Crear nueva categoría">
                            +
                        </button>
                    </div>

                    <!-- MODAL FLOTANTE PARA CREAR NUEVA CATEGORÍA -->
                    <div x-show="modalCategoriaAbierto" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4" style="display: none;">
                        <div class="bg-[#18181b] border border-zinc-800 p-6 rounded-2xl w-full max-w-md space-y-4 shadow-xl">
                            <h3 class="text-white font-bold text-lg">Crear Nueva Categoría</h3>
                            
                            <div>
                                <label class="block text-zinc-400 text-xs mb-1">Nombre de la categoría</label>
                                <input type="text" x-model="nuevaCategoria" placeholder="Ej: Vinos, Cervezas..." class="w-full bg-zinc-900 border border-zinc-700 text-white rounded-xl p-3 focus:outline-none focus:border-orange-500 text-sm">
                            </div>

                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" @click="modalCategoriaAbierto = false; nuevaCategoria = ''" class="bg-zinc-800 hover:bg-zinc-700 text-white px-4 py-2 rounded-xl text-sm transition">
                                    Cancelar
                                </button>
                                <button type="button" @click="
                                    if(nuevaCategoria.trim() !== '') {
                                        fetch('{{ route('categorias.store.rapido') }}', {
                                            method: 'POST',
                                            headers: { 
                                                'Content-Type': 'application/json', 
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                                            },
                                            body: JSON.stringify({ nombre: nuevaCategoria })
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if(data.success) {
                                                let select = document.getElementById('select-categoria');
                                                let option = document.createElement('option');
                                                option.value = data.id;
                                                option.text = data.nombre;
                                                option.selected = true;
                                                select.appendChild(option);

                                                modalCategoriaAbierto = false;
                                                nuevaCategoria = '';
                                            }
                                        })
                                        .catch(err => alert('Error al crear la categoría'));
                                    }
                                " class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                                    Guardar Categoría
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Imagen -->
                <div>
                    <label class="block text-xs font-semibold text-zinc-300 mb-2">Imagen del Producto</label>
                    <input type="file" name="imagen" accept="image/*"
                        class="w-full text-xs text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-500/10 file:text-orange-500 hover:file:bg-orange-500/20 transition cursor-pointer bg-[#18181b] border border-zinc-800 rounded-xl">
                </div>

                <!-- Botón de Guardar -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold py-3 px-4 rounded-xl text-sm transition shadow-lg shadow-orange-500/10">
                        Guardar Producto
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