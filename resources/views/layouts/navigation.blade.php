<nav style="background-color: #18181b; border-bottom: 1px solid rgba(255, 255, 255, 0.1); position: sticky; top: 0; z-index: 50; width: 100%; font-family: ui-sans-serif, system-ui, sans-serif;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; height: 75px; align-items: center;">
        
        <!-- Logo / Marca -->
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 26px;">🥃</span>
            <a href="{{ route('dashboard') }}" style="font-weight: 900; font-size: 18px; letter-spacing: 1px; background: linear-gradient(to right, #fb923c, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-decoration: none;">
                LICORERÍA EL VECINO
            </a>
        </div>

        <!-- Enlaces del menú y Usuario con efectos interactivos -->
        <div style="display: flex; align-items: center; gap: 15px;">
            
            <!-- Botón Panel -->
            <a href="{{ route('dashboard') }}" 
               style="background: rgba(255, 255, 255, 0.08); color: white; padding: 9px 16px; border-radius: 12px; font-size: 12px; font-weight: bold; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.2s ease; display: inline-block;"
               onmouseover="this.style.background='rgba(249, 115, 22, 0.2)'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)';"
               onmouseout="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.borderColor='rgba(255, 255, 255, 0.15)'; this.style.transform='translateY(0)';"
               onmousedown="this.style.transform='translateY(1px)';"
               onmouseup="this.style.transform='translateY(-2px)'">
                📊 Panel
            </a>
            
            <!-- Botón Perfil -->
            <a href="{{ route('profile.edit') }}" 
               style="background: rgba(255, 255, 255, 0.08); color: white; padding: 9px 16px; border-radius: 12px; font-size: 12px; font-weight: bold; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.15); transition: all 0.2s ease; display: inline-block;"
               onmouseover="this.style.background='rgba(249, 115, 22, 0.2)'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)';"
               onmouseout="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.borderColor='rgba(255, 255, 255, 0.15)'; this.style.transform='translateY(0)';"
               onmousedown="this.style.transform='translateY(1px)';"
               onmouseup="this.style.transform='translateY(-2px)'">
                ⚙️ Perfil
            </a>

            <!-- Botón Salir -->
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" 
                        style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 9px 14px; border-radius: 12px; font-size: 12px; font-weight: bold; cursor: pointer; transition: all 0.2s ease; display: inline-block;"
                        onmouseover="this.style.background='rgba(239, 68, 68, 0.3)'; this.style.borderColor='#ef4444'; this.style.transform='translateY(-2px)';"
                        onmouseout="this.style.background='rgba(239, 68, 68, 0.15)'; this.style.borderColor='rgba(239, 68, 68, 0.3)'; this.style.transform='translateY(0)';"
                        onmousedown="this.style.transform='translateY(1px)';"
                        onmouseup="this.style.transform='translateY(-2px)'">
                    Salir
                </button>
            </form>
        </div>

    </div>
</nav>