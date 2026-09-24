<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-zinc-400">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o información que deseas conservar.') }}
        </p>
    </header>

    <!-- Botón principal -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="background: linear-gradient(to right, #dc2626, #e11d48) !important; border: none !important;"
        class="text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-xl shadow-lg shadow-red-600/20 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer"
    >
        <span>🗑️</span>
        {{ __('Eliminar Cuenta') }}
    </x-danger-button>

    <!-- Modal oficial de Breeze adaptado con diseño oscuro completo -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div style="background-color: #121215 !important; border: 1px solid #27272a !important; color: #f4f4f5 !important;" class="p-8 rounded-3xl shadow-2xl">
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                <div>
                    <h2 class="text-lg font-bold text-white tracking-wide">
                        {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
                    </h2>

                    <p class="mt-2 text-sm text-zinc-400 leading-relaxed">
                        {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
                    </p>
                </div>

                <div>
                    <label for="password" class="sr-only">{{ __('Contraseña') }}</label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        style="background-color: #18181b !important; color: white !important; border-color: #3f3f46 !important;"
                        class="w-full border rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 placeholder-zinc-500"
                        placeholder="{{ __('Ingresa tu contraseña actual') }}"
                    />

                    @if($errors->userDeletion->get('password'))
                        <ul class="text-sm text-red-400 space-y-1 mt-2">
                            @foreach ((array) $errors->userDeletion->get('password') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" 
                        x-on:click="$dispatch('close')" 
                        style="background-color: #27272a !important; color: #d4d4d8 !important; border-color: #3f3f46 !important;"
                        class="font-semibold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl border transition cursor-pointer"
                    >
                        {{ __('Cancelar') }}
                    </button>

                    <button type="submit" 
                        style="background: linear-gradient(to right, #dc2626, #e11d48) !important; color: white !important;"
                        class="font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl shadow-lg transition border-0 cursor-pointer"
                    >
                        {{ __('Sí, Eliminar') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>