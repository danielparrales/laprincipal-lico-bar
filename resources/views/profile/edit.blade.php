<x-app-layout>
    <!-- Contenedor principal con fondo oscuro total -->
    <div style="background-color: #09090b; min-height: 100vh; padding: 40px 0 60px 0; font-family: ui-sans-serif, system-ui, sans-serif;">
        <div style="max-width: 900px; margin: 0 auto; padding: 0 20px; display: flex; flex-direction: column; gap: 30px;">
            
            <!-- Encabezado integrado (Reemplaza al header blanco de Breeze) -->
            <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); padding: 25px 35px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                <h2 style="font-size: 20px; font-weight: 900; background: linear-gradient(to right, #fb923c, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0;">
                    ⚙️ Configuración de la Cuenta
                </h2>
                <a href="{{ route('dashboard') }}" 
                   style="background: rgba(255, 255, 255, 0.08); color: white; padding: 8px 16px; border-radius: 12px; font-size: 12px; font-weight: bold; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.2s ease; display: inline-block;"
                   onmouseover="this.style.background='rgba(249, 115, 22, 0.2)'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)';"
                   onmouseout="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.borderColor='rgba(255, 255, 255, 0.15)'; this.style.transform='translateY(0)';"
                   onmousedown="this.style.transform='translateY(1px)';"
                   onmouseup="this.style.transform='translateY(-2px)'">
                    ← Volver al Panel
                </a>
            </div>
            
            <!-- Sección 1: Información del Perfil -->
            <div style="background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 35px; box-shadow: 0 20px 40px rgba(0,0,0,0.6);">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Sección 2: Actualizar Contraseña -->
            <div style="background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 35px; box-shadow: 0 20px 40px rgba(0,0,0,0.6);">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Sección 3: Eliminar Cuenta -->
            <div style="background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 24px; padding: 35px; box-shadow: 0 20px 40px rgba(0,0,0,0.6);">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>