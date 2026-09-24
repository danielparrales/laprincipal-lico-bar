<section style="color: #f4f4f5; font-family: ui-sans-serif, system-ui, sans-serif;">
    <header style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 20px; margin-bottom: 25px;">
        <h2 style="font-size: 20px; font-weight: 900; color: white; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
            <span>🔒</span> {{ __('Actualizar Contraseña') }}
        </h2>
        <p style="font-size: 13px; color: #a1a1aa; margin: 0; font-weight: 500;">
            {{ __('Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantenerse segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        @method('put')

        <!-- Contraseña Actual -->
        <div>
            <label for="update_password_current_password" style="display: block; font-size: 12px; font-weight: bold; color: #d4d4d8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('Contraseña Actual') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" style="width: 100%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s;" autocomplete="current-password" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'" />
            @foreach ($errors->updatePassword->get('current_password') as $message)
                <p style="color: #f87171; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @endforeach
        </div>

        <!-- Nueva Contraseña -->
        <div>
            <label for="update_password_password" style="display: block; font-size: 12px; font-weight: bold; color: #d4d4d8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('Nueva Contraseña') }}</label>
            <input id="update_password_password" name="password" type="password" style="width: 100%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s;" autocomplete="new-password" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'" />
            @foreach ($errors->updatePassword->get('password') as $message)
                <p style="color: #f87171; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @endforeach
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <label for="update_password_password_confirmation" style="display: block; font-size: 12px; font-weight: bold; color: #d4d4d8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('Confirmar Contraseña') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" style="width: 100%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s;" autocomplete="new-password" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'" />
            @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                <p style="color: #f87171; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @endforeach
        </div>

        <!-- Botón Guardar y Estado -->
        <div style="display: flex; align-items: center; gap: 15px; padding-top: 10px;">
            <button type="submit" style="background: linear-gradient(to right, #f97316, #d97706); color: white; padding: 12px 24px; border-radius: 12px; font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; border: none; cursor: pointer; box-shadow: 0 10px 20px rgba(249,115,22,0.3); transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                {{ __('Guardar Contraseña') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    style="color: #4ade80; font-size: 13px; font-weight: bold; margin: 0;"
                >✨ {{ __('¡Contraseña actualizada!') }}</p>
            @endif
        </div>
    </form>
</section>