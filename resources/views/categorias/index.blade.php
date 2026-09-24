<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">📂 Gestionar Categorías</h2>
            <a href="/productos/gestionar" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition">
                ← Volver a Gestión de Productos
            </a>
        </div>

        <!-- Formulario para crear categoría -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-6 border border-gray-200">
            <form action="{{ route('categorias.store') }}" method="POST" class="flex gap-4 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-gray-700 font-semibold mb-2">Nombre de la Nueva Categoría</label>
                    <input type="text" name="nombre" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Ej: Lácteos, Bebidas..." required>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow transition">
                    + Agregar Categoría
                </button>
            </form>
        </div>

        <!-- Tabla de categorías existentes -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <table class="w-full border-collapse">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="p-4 text-left">Categoría</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-600">
                    @forelse($categorias as $categoria)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-medium text-gray-800">{{ $categoria->nombre }}</td>
                        <td class="p-4 text-center">
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-semibold shadow transition">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="p-4 text-center text-gray-500">No hay categorías registradas todavía.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>