<section style="background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 35px; box-shadow: 0 20px 40px rgba(0,0,0,0.6); color: #f4f4f5; font-family: ui-sans-serif, system-ui, sans-serif;">
    <header style="border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 20px; margin-bottom: 25px;">
        <h2 style="font-size: 20px; font-weight: 900; color: white; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px;">
            <span>👤</span> {{ __('Información del Perfil') }}
        </h2>
        <p style="font-size: 13px; color: #a1a1aa; margin: 0; font-weight: 500;">
            {{ __("Actualiza la información de tu perfil y tu dirección de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" style="display: flex; flex-direction: column; gap: 20px;">
        @csrf
        @method('patch')

        <!-- Campo Nombre -->
        <div>
            <label for="name" style="display: block; font-size: 12px; font-weight: bold; color: #d4d4d8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('Nombre') }}</label>
            <input id="name" name="name" type="text" style="width: 100%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s;" :value="old('name', $user->name)" required autofocus autocomplete="name" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'" />
            @error('name')
                <p style="color: #f87171; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Campo Correo -->
        <div>
            <label for="email" style="display: block; font-size: 12px; font-weight: bold; color: #d4d4d8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('Correo Electrónico') }}</label>
            <input id="email" name="email" type="email" style="width: 100%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s;" :value="old('email', $user->email)" required autocomplete="username" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'" />
            @error('email')
                <p style="color: #f87171; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror

            <!-- direccion de domicilio -->
           <div>
            <label for="direccion" style="display: block; font-size: 12px; font-weight: bold; color: #d4d4d8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('Dirección') }}</label>
            <input id="direccion" name="direccion" type="text" style="width: 100%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s;" :value="old('direccion', $user->direccion)" required autofocus autocomplete="direccion" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'" />
            @error('direccion')
                <p style="color: #f87171; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

            <!-- telefono -->
                   <div>
            <label for="telefono" style="display: block; font-size: 12px; font-weight: bold; color: #d4d4d8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">{{ __('Teléfono') }}</label>
            <input id="telefono" name="telefono" type="text" style="width: 100%; background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.15); color: white; padding: 12px 16px; border-radius: 12px; font-size: 14px; outline: none; transition: border-color 0.2s;" :value="old('telefono', $user->telefono)" required autofocus autocomplete="telefono" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255, 255, 255, 0.15)'" />
            @error('telefono')
                <p style="color: #f87171; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 12px; background: rgba(234, 179, 8, 0.1); border: 1px solid rgba(234, 179, 8, 0.2); padding: 12px; border-radius: 10px;">
                    <p style="font-size: 13px; color: #fde047; margin: 0 0 8px 0;">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}
                    </p>

                    <button form="send-verification" style="background: none; border: none; color: #fb923c; text-decoration: underline; font-size: 13px; font-weight: bold; cursor: pointer; padding: 0;">
                        {{ __('Haz clic aquí para re-enviar el correo de verificación.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 8px; font-weight: bold; font-size: 13px; color: #4ade80;">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Botón Guardar y Estado -->
        <div style="display: flex; align-items: center; gap: 15px; padding-top: 10px;">
            <button type="submit" style="background: linear-gradient(to right, #f97316, #d97706); color: white; padding: 12px 24px; border-radius: 12px; font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; border: none; cursor: pointer; box-shadow: 0 10px 20px rgba(249,115,22,0.3); transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    style="color: #4ade80; font-size: 13px; font-weight: bold; margin: 0;"
                >✨ {{ __('¡Guardado con éxito!') }}</p>
            @endif
        </div>
    </form>
</section>