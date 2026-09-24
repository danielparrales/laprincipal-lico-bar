<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de Cliente - Licorería El Vecino</title>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="background-color: #09090b; color: #f4f4f5; font-family: ui-sans-serif, system-ui, sans-serif; margin: 0; padding: 0; min-height: 100vh;">

    <!-- Barra de Navegación Superior -->
    <nav style="background-color: rgba(24, 24, 27, 0.9); border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding: 18px 40px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 50; backdrop-filter: blur(10px);">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 26px;">🥃</span>
            <span style="font-weight: 900; font-size: 20px; letter-spacing: 1px; background: linear-gradient(to right, #fb923c, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                LICORERÍA EL VECINO
            </span>
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="{{ url('/') }}" style="background: rgba(255, 255, 255, 0.08); color: white; padding: 10px 16px; border-radius: 12px; font-size: 12px; font-weight: bold; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.15);">
                ← Catálogo
            </a>
            <a href="{{ route('profile.edit') }}" style="background: rgba(255, 255, 255, 0.08); color: white; padding: 10px 16px; border-radius: 12px; font-size: 12px; font-weight: bold; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.15);">
                ⚙️ Mi Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); padding: 10px 14px; border-radius: 12px; font-size: 12px; font-weight: bold; cursor: pointer;">
                    Salir
                </button>
            </form>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main style="max-width: 1200px; margin: 40px auto; padding: 0 20px;"
          x-data="{ 
             carritoDashboard: JSON.parse(localStorage.getItem('carrito_licoreria') || '[]'),
             
             guardar() {
                 localStorage.setItem('carrito_licoreria', JSON.stringify(this.carritoDashboard));
             },
             
             incrementar(index) {
                 if (!this.carritoDashboard[index].cantidad) {
                     this.carritoDashboard[index].cantidad = 1;
                 }
                 this.carritoDashboard[index].cantidad++;
                 this.guardar();
             },
             
             decrementar(index) {
                 if (!this.carritoDashboard[index].cantidad) {
                     this.carritoDashboard[index].cantidad = 1;
                 }
                 if (this.carritoDashboard[index].cantidad > 1) {
                     this.carritoDashboard[index].cantidad--;
                 } else {
                     this.carritoDashboard.splice(index, 1);
                 }
                 this.guardar();
             },
             
             eliminar(index) {
                 this.carritoDashboard.splice(index, 1);
                 this.guardar();
             },
             
             calcularTotal() {
                 return this.carritoDashboard.reduce((acc, item) => {
                     let cant = item.cantidad || 1;
                     return acc + (item.precio * cant);
                 }, 0).toFixed(2);
             },

             enviarWhatsApp() {
                 if (this.carritoDashboard.length === 0) return;
                 let cliente = '{{ Auth::user()->name }}';
                 let mensaje = `*📦 NUEVO PEDIDO - LICORERÍA EL VECINO*%0A`;
                 mensaje += `----------------------------------------%0A`;
                 mensaje += `👤 *Cliente:* ${cliente}%0A`;
                 mensaje += `📅 *Fecha:* ${new Date().toLocaleDateString()}%0A`;
                 mensaje += `----------------------------------------%0A`;
                 mensaje += `*🛒 DETALLE DEL PEDIDO:*%0A`;
                 
                 this.carritoDashboard.forEach(item => {
                     let cant = item.cantidad || 1;
                     mensaje += `▫️ ${cant}x ${item.nombre} ($${item.precio.toFixed(2)} c/u) ➡️ *$${(item.precio * cant).toFixed(2)}*%0A`;
                 });
                 
                 mensaje += `----------------------------------------%0A`;
                 mensaje += `💰 *TOTAL A PAGAR: $${this.calcularTotal()}*%0A`;
                 mensaje += `----------------------------------------%0A`;
                 mensaje += `¡Quedo atento a la confirmación de la entrega! 🛵💨`;
                 
                 let numeroWhatsApp = '593999999999'; // Cambia por tu número real
                 window.open(`https://wa.me/${numeroWhatsApp}?text=${mensaje}`, '_blank');
             }
          }">
        
        <!-- Tarjeta de Bienvenida -->
        <div style="background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 35px; margin-bottom: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.6);">
            <h1 style="font-size: 30px; font-weight: 900; margin: 0 0 10px 0; background: linear-gradient(to right, #fb923c, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                ¡Bienvenido, {{ Auth::user()->name }}! 🥃
            </h1>
            <p style="color: #a1a1aa; font-size: 14px; margin: 0; font-weight: 500;">
                Administra los productos de tu orden en tiempo real, ajusta cantidades o finaliza tu compra de forma inmediata.
            </p>
        </div>

        <!-- Cuadrícula -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            
            <!-- Pedido Actual -->
            <div style="background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.6); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 15px; margin-bottom: 20px;">
                        <h3 style="font-size: 16px; font-weight: bold; margin: 0; color: white;">🛒 Pedido Actual en Curso</h3>
                        <span style="background: rgba(249, 115, 22, 0.15); color: #fb923c; font-size: 11px; font-weight: bold; padding: 5px 12px; border-radius: 20px; border: 1px solid rgba(249, 115, 22, 0.3);">En proceso</span>
                    </div>

                    <!-- Si está vacío -->
                    <template x-if="carritoDashboard.length === 0">
                        <div style="text-align: center; padding: 50px 0; color: #a1a1aa;">
                            <span style="font-size: 36px; display: block; margin-bottom: 10px;">🛍️</span>
                            <p style="font-size: 14px; margin: 0 0 20px 0; font-weight: 500;">No tienes productos en tu carrito actual.</p>
                            <a href="{{ url('/') }}" style="background: linear-gradient(to right, #f97316, #d97706); color: white; padding: 12px 24px; border-radius: 12px; font-size: 12px; font-weight: 900; text-decoration: none; display: inline-block;">
                                Explorar Catálogo
                            </a>
                        </div>
                    </template>

                    <!-- Lista con controles profesionales -->
                    <div style="display: flex; flex-direction: column; gap: 12px; max-height: 280px; overflow-y: auto;" x-show="carritoDashboard.length > 0">
                        <template x-for="(item, index) in carritoDashboard" :key="index">
                            <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); padding: 14px 16px; border-radius: 16px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                                <div style="flex: 1;">
                                    <h5 style="font-weight: bold; color: white; font-size: 14px; margin: 0 0 4px 0;" x-text="item.nombre"></h5>
                                    <span style="color: #4ade80; font-weight: 900; font-size: 13px;" x-text="'$' + (item.precio * (item.cantidad || 1)).toFixed(2)"></span>
                                </div>
                                
                                <!-- Controles estilizados + / - -->
                                <div style="display: flex; align-items: center; gap: 10px; background: rgba(0, 0, 0, 0.4); padding: 6px 12px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.1);">
                                    <button @click="decrementar(index)" style="background: none; border: none; color: #a1a1aa; cursor: pointer; font-weight: bold; font-size: 15px; padding: 0 2px; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#a1a1aa'">-</button>
                                    <span style="font-size: 13px; font-weight: 900; color: white; width: 18px; text-align: center;" x-text="item.cantidad || 1"></span>
                                    <button @click="incrementar(index)" style="background: none; border: none; color: #a1a1aa; cursor: pointer; font-weight: bold; font-size: 15px; padding: 0 2px; transition: color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#a1a1aa'">+</button>
                                </div>

                                <!-- Botón Eliminar limpio -->
                                <button @click="eliminar(index)" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; width: 34px; height: 34px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 13px; transition: background 0.2s;" title="Eliminar producto" onmouseover="this.style.background='rgba(239, 68, 68, 0.25)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                    🗑️
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Total y botón WhatsApp -->
                <template x-if="carritoDashboard.length > 0">
                    <div style="border-top: 1px solid rgba(255, 255, 255, 0.1); padding-top: 20px; margin-top: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; background: rgba(255, 255, 255, 0.04); padding: 14px 18px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.06);">
                            <span style="font-size: 12px; font-weight: bold; color: #d4d4d8; letter-spacing: 1px;">TOTAL ESTIMADO:</span>
                            <span style="font-size: 22px; font-weight: 900; color: #4ade80;" x-text="'$' + calcularTotal()"></span>
                        </div>
                        <button @click="enviarWhatsApp()" style="width: 100%; display: block; text-align: center; background: linear-gradient(to right, #22c55e, #16a34a); color: white; padding: 14px; border-radius: 14px; font-size: 12px; font-weight: 900; border: none; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; box-shadow: 0 10px 25px rgba(34,197,94,0.3); transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            📱 Enviar pedido por WhatsApp
                        </button>
                    </div>
                </template>
            </div>

            <!-- Historial -->
            <div style="background: rgba(24, 24, 27, 0.8); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 30px; box-shadow: 0 20px 40px rgba(0,0,0,0.6);">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 15px; margin-bottom: 20px;">
                    <h3 style="font-size: 16px; font-weight: bold; margin: 0; color: white;">📦 Historial de Compras</h3>
                    <span style="font-size: 12px; color: #a1a1aa; font-weight: 500;">Tus pedidos pasados</span>
                </div>
                <div style="text-align: center; padding: 60px 0; color: #a1a1aa;">
                    <span style="font-size: 38px; display: block; margin-bottom: 12px;">📜</span>
                    <p style="font-size: 14px; margin: 0 0 5px 0; font-weight: 500;">Aún no registras compras anteriores en el sistema.</p>
                    <p style="font-size: 12px; color: #71717a; margin: 0;">Tus pedidos confirmados aparecerán aquí guardados.</p>
                </div>
            </div>

        </div>
    </main>

</body>
</html>