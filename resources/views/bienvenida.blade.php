<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Licorería El Vecino | Licores, Vinos y Bebidas</title>

    <meta name="description"
        content="Licorería El Vecino. Encuentra licores, whisky, vinos, champagne y bebidas para tus mejores momentos.">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orangeBrand: '#ff6b00',
                        orangeLight: '#ff9d42',
                        blackDeep: '#050505',
                        blackSoft: '#0d0d0d'
                    }
                }
            }
        }
    </script>

    <!-- CSS PRINCIPAL -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Iconos -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<!-- Imagen de fondo fija para toda la página -->
<div class="fixed inset-0 w-full h-full pointer-events-none z-[-1] overflow-hidden">
    <img src="{{ asset('images/LLL.jpeg') }}" 
         class="w-full h-full object-cover filter blur-[2px] opacity-25 scale-105" 
         alt="Fondo general Licorería">
</div>

<body

    x-data="minimarketApp()"
    x-init="init()"
    class="liquor-page bg-black text-white">

    <!-- =========================================================
         VERIFICACIÓN DE EDAD
    ========================================================== -->

    <div
        x-show="mostrarEdad"
        x-cloak
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/95 backdrop-blur-xl px-4"
        x-transition.opacity>

        <div
            class="w-full max-w-md rounded-3xl border border-orange-500/30 bg-[#0b0b0b] p-8 text-center shadow-[0_0_80px_rgba(255,107,0,0.20)]"
            x-transition.scale>

            <div class="mb-6 flex justify-center">
                <div
                    class="flex h-20 w-20 items-center justify-center rounded-full border border-orange-500/40 bg-orange-500/10 text-orange-500 text-4xl">
                    <i class="fa-solid fa-wine-glass"></i>
                </div>
            </div>

            <h2 class="mb-3 text-3xl font-black text-white">
                Bienvenido
            </h2>

            <p class="mb-6 text-gray-400">
                Para ingresar a <strong class="text-orange-500">Licorería El Vecino</strong>
                debes confirmar que eres mayor de edad.
            </p>

            <div class="mb-6 rounded-2xl border border-orange-500/20 bg-orange-500/5 p-4">
                <p class="text-sm text-gray-300">
                    Este sitio contiene productos destinados exclusivamente
                    para personas mayores de edad.
                </p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">

                <button
                    @click="confirmarEdad()"
                    class="flex-1 rounded-xl bg-orange-500 px-5 py-3 font-bold text-black transition duration-300 hover:-translate-y-1 hover:bg-orange-400 hover:shadow-[0_10px_30px_rgba(255,107,0,0.35)]">

                    <i class="fa-solid fa-check mr-2"></i>
                    Soy mayor de edad
                </button>

                <button
                    @click="salirSitio()"
                    class="flex-1 rounded-xl border border-gray-700 px-5 py-3 font-bold text-gray-300 transition duration-300 hover:border-orange-500 hover:text-orange-500">

                    Salir
                </button>

            </div>

        </div>
    </div>


    <!-- =========================================================
         NAVBAR
    ========================================================== -->

    <header class="main-header">

        <div class="nav-container">

            <!-- LOGO -->

            <a href="{{ url('/') }}" class="brand">

                <div class="brand-icon">
                    <i class="fa-solid fa-wine-bottle"></i>
                </div>

                <div>
                    <span class="brand-title">
                        LICORERÍA
                    </span>

                    <span class="brand-subtitle">
                        EL VECINO
                    </span>
                </div>

            </a>


            <!-- NAVEGACIÓN DESKTOP -->

            <nav class="nav-links">

                <a href="#inicio">
                    Inicio
                </a>

                <a href="#categorias">
                    Categorías
                </a>

                <a href="#productos">
                    Productos
                </a>

                <a href="#ofertas">
                    Ofertas
                </a>

                <a href="#contacto">
                    Contacto
                </a>

            </nav>


            <!-- ACCIONES -->

            <div class="flex items-center gap-3">

                @if (Route::has('login'))

                    @auth

                        <a href="{{ url('/dashboard') }}"
                            class="hidden rounded-xl border border-orange-500/30 px-4 py-2 text-sm font-bold text-orange-500 transition hover:bg-orange-500 hover:text-black md:block">

                            <i class="fa-solid fa-gauge-high mr-1"></i>

                            Dashboard

                        </a>

                    @else

                        <a href="{{ route('login') }}"
                            class="hidden rounded-xl px-4 py-2 text-sm font-bold text-gray-300 transition hover:text-orange-500 md:block">

                            Iniciar sesión

                        </a>

                        @if (Route::has('register'))

                            <a href="{{ route('register') }}"
                                class="hidden rounded-xl bg-orange-500 px-4 py-2 text-sm font-bold text-black transition hover:-translate-y-1 hover:bg-orange-400 md:block">

                                Registrarse

                            </a>

                        @endif

                    @endauth

                @endif


                <!-- CARRITO -->

                <button
                    @click="abrirModal()"
                    class="cart-button">

                    <i class="fa-solid fa-cart-shopping"></i>

                    <span
                        x-show="carrito.length > 0"
                        x-text="carrito.length"
                        class="cart-count">
                    </span>

                </button>


                <!-- MENU MOVIL -->

                <button
                    @click="menuMovil = !menuMovil"
                    class="mobile-menu-button">

                    <i
                        class="fa-solid"
                        :class="menuMovil ? 'fa-xmark' : 'fa-bars'">
                    </i>

                </button>

            </div>

        </div>


        <!-- MENU MOVIL -->

        <div
            x-show="menuMovil"
            x-transition
            x-cloak
            class="border-t border-orange-500/10 bg-black/95 px-5 py-5 backdrop-blur-xl lg:hidden">

            <div class="flex flex-col gap-2">

                <a href="#inicio"
                    @click="menuMovil = false"
                    class="rounded-xl px-4 py-3 text-gray-300 transition hover:bg-orange-500/10 hover:text-orange-500">
                    Inicio
                </a>

                <a href="#categorias"
                    @click="menuMovil = false"
                    class="rounded-xl px-4 py-3 text-gray-300 transition hover:bg-orange-500/10 hover:text-orange-500">
                    Categorías
                </a>

                <a href="#productos"
                    @click="menuMovil = false"
                    class="rounded-xl px-4 py-3 text-gray-300 transition hover:bg-orange-500/10 hover:text-orange-500">
                    Productos
                </a>

                <a href="#ofertas"
                    @click="menuMovil = false"
                    class="rounded-xl px-4 py-3 text-gray-300 transition hover:bg-orange-500/10 hover:text-orange-500">
                    Ofertas
                </a>

                <a href="#contacto"
                    @click="menuMovil = false"
                    class="rounded-xl px-4 py-3 text-gray-300 transition hover:bg-orange-500/10 hover:text-orange-500">
                    Contacto
                </a>


                @if (Route::has('login'))

                    @auth

                        <a href="{{ url('/dashboard') }}"
                            class="mt-2 rounded-xl border border-orange-500/30 px-4 py-3 text-center font-bold text-orange-500">
                            Dashboard
                        </a>

                    @else

                        <a href="{{ route('login') }}"
                            class="mt-2 rounded-xl border border-gray-700 px-4 py-3 text-center font-bold text-gray-300">
                            Iniciar sesión
                        </a>

                        @if (Route::has('register'))

                            <a href="{{ route('register') }}"
                                class="rounded-xl bg-orange-500 px-4 py-3 text-center font-bold text-black">
                                Registrarse
                            </a>

                        @endif

                    @endauth

                @endif

            </div>

        </div>

    </header>


    <!-- =========================================================
         HERO
    ========================================================== -->

    <main>

        <section id="inicio" class="hero-section">
            
</div>
        <!-- VIDEO DE FONDO 
            <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover opacity-60 z-0">
            <source src="{{ asset('videos/licobar1.mp4') }}" type="video/mp4">
            Tu navegador no soporta videos de fondo.
        </video> -->
            <div class="hero-container">

                <!-- CONTENIDO -->

                <div class="hero-content fade-up">

                    <div class="hero-tag">

                        <span class="inline-flex h-2 w-2 rounded-full bg-orange-500"></span>

                        CALIDAD • SABOR • EXPERIENCIA

                    </div>


                    <h1 class="hero-title">

                        TU MOMENTO.

                        <br>

                        <span class="masked-title">
                            TU LICOR.
                        </span>

                    </h1>


                    <p class="hero-description">

                        Descubre una selección especial de licores,
                        whisky, vinos, champagne y bebidas para
                        compartir tus mejores momentos.

                    </p>


                    <div class="hero-buttons">

                        <a href="#productos"
                            class="primary-button">

                            <i class="fa-solid fa-bag-shopping"></i>

                            Ver productos

                        </a>
                        
                        <a href="#categorias" class="primary-button">
                             <i class="fa-solid fa-list"></i>
                                  Explorar categorías
                             </a>

                    </div>


                    <!-- INFORMACIÓN -->

                    <div class="mt-8 flex flex-wrap gap-6 text-sm text-gray-400">

                        <div class="flex items-center gap-2">

                            <i class="fa-solid fa-circle-check text-orange-500"></i>

                            Productos seleccionados

                        </div>

                        <div class="flex items-center gap-2">

                            <i class="fa-solid fa-shield-halved text-orange-500"></i>

                            Compra segura

                        </div>

                        <div class="flex items-center gap-2">

                            <i class="fa-solid fa-truck-fast text-orange-500"></i>

                            Atención rápida

                        </div>

                    </div>

                </div>


                <!-- VISUAL 3D -->

                <div class="hero-visual">

                    <div class="hero-glow"></div>

                    <!--
                        FOTO PRINCIPAL DEL HERO

                        Guarda tu imagen aquí:

                        public/images/hero-licores.jpg

                        Puedes reemplazar este archivo por la fotografía
                        que quieras utilizar.
                    -->
                        

                    <div class="relative z-10 w-full max-w-[520px]">

                        <div
                            class="overflow-hidden rounded-[40px] border border-orange-500/20 bg-black/50 shadow-[0_0_100px_rgba(255,107,0,0.15)]">

                            <img
                                src="{{ asset('images/hero-licores.jpg') }}"
                                alt="Licorería El Vecino"
                                class="h-[520px] w-full object-cover opacity-90 transition duration-700 hover:scale-105"
                                onerror="this.style.display='none'; this.parentElement.classList.add('hero-image-fallback');">

                        </div>

                    </div>


                    <!-- ELEMENTOS DECORATIVOS -->

                    <div class="bottle-3d"></div>

                    <div class="orbit orbit-1"></div>
                    <div class="orbit orbit-2"></div>
                    <div class="orbit orbit-3"></div>

                </div>

            </div>

        </section>

        


     
      <!-- =====================================================
            CATEGORÍAS
        ====================================================== -->
        
        <section id="categorias" class="categories-section py-8">
           <section id="categorias" class="categories-section py-12">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-10">
            <span class="text-sm font-bold uppercase tracking-[0.3em] text-orange-500">
                Explora
            </span>
            
            <h2 class="masked-category-title text-4xl sm:text-5xl font-black mt-1 uppercase tracking-wider">
                Categorías
            </h2>

            <p class="text-zinc-400 text-sm mt-2">
                Encuentra la bebida perfecta para cada ocasión.
            </p>
        </div>

        <!-- Tus tarjetas de categorías -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($categorias as $cat)
                <!-- ... tus elementos ... -->
            @endforeach
        </div>

    </div>
</section>
    
                @if(request('categoria'))
                    <div class="mb-6 flex justify-center">
                        <a href="{{ url('/#productos') }}" class="px-4 py-2 rounded-xl bg-orange-500 text-black font-bold text-sm hover:bg-orange-400 transition">
                            <i class="fa-solid fa-rotate-left mr-2"></i> Ver todos los productos
                        </a>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($categorias as $cat)
                        <a href="{{ url('/?categoria=' . $cat->id . '#productos') }}"
                           class="category-card p-6 rounded-2xl border transition hover:border-orange-500 block {{ request('categoria') == $cat->id ? 'border-orange-500 bg-orange-500/10' : 'border-zinc-800 bg-[#121215]' }}">

                            <div class="flex items-center justify-between">
                                <div class="category-icon text-orange-500 text-2xl">
                                    <i class="fa-solid fa-wine-bottle"></i>
                                </div>
                                <i class="fa-solid fa-arrow-right text-zinc-500 category-arrow"></i>
                            </div>

                            <div class="mt-4">
                                <h3 class="text-white font-bold text-lg">{{ $cat->nombre }}</h3>
                                <p class="text-xs text-zinc-400 mt-1">Ver productos disponibles.</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- =====================================================
            PRODUCTOS
        ====================================================== -->

        <section id="productos" class="section-container">

            <div class="section-heading fade-up">

                <div class="text-center mb-10">
    <span class="text-sm font-bold uppercase tracking-[0.3em] text-orange-500">
        Catálogo
    </span>
    
    <!-- Título principal con el efecto animado -->
    <h2 class="masked-title text-4xl sm:text-5xl font-black mt-1 uppercase tracking-wider">
        Productos destacados
    </h2>

    <p class="text-zinc-400 text-sm mt-2">
        Calidad y variedad en un solo lugar.
    </p>
</div>


            @if(isset($productos) && $productos->count())

                <div class="products-grid">

                    @foreach($productos as $producto)

                        <article
                            class="product-card fade-up"
                            @mouseenter="activarProducto($el)"
                            @mouseleave="desactivarProducto($el)"
                            @mousemove="tiltCard($event)">

                            <!-- IMAGEN -->

                            <div class="product-image">

                                @if($producto->imagen)

                                    <img
                                        src="{{ asset('storage/' . $producto->imagen) }}"
                                        alt="{{ $producto->nombre }}"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                    <div
                                        class="hidden h-full w-full items-center justify-center text-7xl">
                                        🍾
                                    </div>

                                @else

                                    <div class="flex h-full w-full items-center justify-center text-7xl">
                                        🍾
                                    </div>

                                @endif


                                <div class="absolute left-4 top-4">

                                    <span class="offer-badge">
                                        DISPONIBLE
                                    </span>

                                </div>

                            </div>


                            <!-- INFORMACIÓN -->

                            <div class="product-info">

                                <span class="product-category">
                                    Licorería El Vecino
                                </span>


                                <h3 class="product-name">
                                    {{ $producto->nombre }}
                                </h3>

                                <!-- 👈 DESCRIPCIÓN VISIBLE PARA LOS CLIENTES -->
                                @if($producto->descripcion)
                                    <p class="text-xs text-zinc-400 mt-1 mb-3 line-clamp-2">
                                        {{ $producto->descripcion }}
                                    </p>
                                @endif


                                <div class="flex items-center justify-between gap-3">

                                    <span class="product-price">

                                        ${{ number_format((float)$producto->precio, 2) }}

                                    </span>


                                    <button
                                        @click="agregarAlCarrito(
                                            @js($producto->nombre),
                                            {{ (float)$producto->precio }}
                                        )"
                                        class="product-action"
                                        title="Agregar al carrito">

                                        <i class="fa-solid fa-plus"></i>

                                    </button>

                                </div>

                            </div>


                            <!-- ADMIN -->

                            @auth

                                @if(auth()->user()->is_admin)

                                    <div class="admin-actions">

                                        <a
                                            href="{{ url('/productos/gestionar') }}"
                                            class="admin-button">

                                            <i class="fa-solid fa-pen-to-square"></i>

                                        </a>

                                    </div>

                                @endif

                            @endauth

                        </article>

                    @endforeach

                </div>

            @else

                <!-- SIN PRODUCTOS -->

                <div
                    class="rounded-3xl border border-orange-500/10 bg-[#0b0b0b] p-12 text-center">

                    <div class="mb-5 text-6xl">
                        🍾
                    </div>

                    <h3 class="mb-2 text-2xl font-black">
                        Próximamente
                    </h3>

                    <p class="text-gray-500">
                        Estamos preparando nuestro catálogo de productos.
                    </p>

                    @auth

                        @if(auth()->user()->is_admin)

                            <a
                                href="{{ url('/productos/crear') }}"
                                class="mt-6 inline-flex rounded-xl bg-orange-500 px-6 py-3 font-bold text-black transition hover:-translate-y-1 hover:bg-orange-400">

                                <i class="fa-solid fa-plus mr-2"></i>

                                Agregar producto

                            </a>

                        @endif

                    @endauth

                </div>

            @endif

        </section>


        <!-- =====================================================
             OFERTA / CTA
        ====================================================== -->

        <section class="relative py-20 px-4 overflow-hidden">
    
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center bg-zinc-950/80 border border-orange-500/20 rounded-[40px] p-8 md:p-12 shadow-[0_0_50px_rgba(255,107,0,0.1)] backdrop-blur-xl relative">
        
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-orange-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col items-start z-10">
            
            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-orange-600/20 border border-orange-500/40 text-orange-500 text-xs font-extrabold tracking-[0.2em] uppercase animate-pulse mb-6 shadow-[0_0_15px_rgba(249,115,22,0.2)]">
                <span class="w-2 h-2 rounded-full bg-orange-500 mr-2 animate-ping"></span>
                EXPERIENCIA EL VECINO
            </div>

            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-none mb-6">
                El sabor de tus <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">mejores momentos.</span>
            </h2>

            <p class="text-zinc-400 text-base sm:text-lg leading-relaxed mb-8 max-w-xl">
                Encuentra opciones exclusivas para reuniones, celebraciones, regalos o simplemente para disfrutar y relajarte después de un largo día.
            </p>

            <a href="#productos" class="group relative inline-flex items-center gap-3 px-8 py-4 rounded-2xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold text-base shadow-[0_10px_25px_rgba(249,115,22,0.4)] transition-all duration-300 hover:scale-105 hover:shadow-[0_15px_35px_rgba(249,115,22,0.6)] active:scale-95">
                <span>Explorar catálogo</span>
                <i class="fa-solid fa-arrow-right transition-transform duration-300 group-hover:translate-x-1.5"></i>
            </a>

        </div>

        <div class="relative z-10 flex justify-center items-center">
            
            <div class="relative w-full max-w-[480px] h-[400px] sm:h-[450px] rounded-[30px] overflow-hidden border border-orange-500/30 shadow-[0_0_40px_rgba(255,107,0,0.2)] group">
                
                <video autoplay muted loop playsinline class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <source src="{{ asset('videos/hh.mp4') }}" type="video/mp4">
                    Tu navegador no soporta videos de fondo.
                </video>

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20 pointer-events-none"></div>

                <div class="absolute bottom-6 left-6 right-6 flex items-center justify-between bg-black/60 backdrop-blur-md border border-white/10 px-4 py-3 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center text-orange-400">
                            <i class="fa-solid fa-wine-glass-empty text-lg"></i>
                        </div>
                        <div>
                            <p class="text-white text-sm font-bold">Alta Coctelería</p>
                            <p class="text-zinc-400 text-xs">Calidad Premium garantizada</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-500/20 text-orange-400 border border-orange-500/30">
                        100% Original
                    </span>
                </div>

            </div>

        </div>

    </div>

</section>

        <!-- =====================================================
             BENEFICIOS
        ====================================================== -->

        <section class="section-container">

            <div class="section-heading fade-up">

                <div>

                    <span class="text-sm font-bold uppercase tracking-[0.3em] text-orange-500">
                        ¿Por qué elegirnos?
                    </span>

                    <h2>
                        Una experiencia diferente
                    </h2>

                </div>

            </div>


            <div class="benefits-grid">


                <div class="benefit-card fade-up">

                    <div class="benefit-icon">
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <h3>
                        Productos seleccionados
                    </h3>

                    <p>
                        Trabajamos para ofrecerte productos
                        de calidad y variedad.
                    </p>

                </div>


                <div class="benefit-card fade-up delay-1">

                    <div class="benefit-icon">
                        <i class="fa-solid fa-bolt"></i>
                    </div>

                    <h3>
                        Atención rápida
                    </h3>

                    <p>
                        Queremos que encuentres lo que buscas
                        de forma sencilla y rápida.
                    </p>

                </div>


                <div class="benefit-card fade-up delay-2">

                    <div class="benefit-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>

                    <h3>
                        Compra sencilla
                    </h3>

                    <p>
                        Agrega productos al carrito y envía
                        tu pedido fácilmente.
                    </p>

                </div>


                <div class="benefit-card fade-up delay-3">

                    <div class="benefit-icon">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>

                    <h3>
                        Atención por WhatsApp
                    </h3>

                    <p>
                        Comunícate directamente con nosotros
                        para realizar tus consultas.
                    </p>

                </div>

            </div>

        </section>


        <!-- =====================================================
             CTA FINAL
        ====================================================== -->

        <section class="section-container">

            <div
                class="relative overflow-hidden rounded-[35px] border border-orange-500/20 bg-gradient-to-br from-orange-500/15 via-black to-black p-8 text-center md:p-14">

                <div
                    class="absolute left-1/2 top-0 h-40 w-40 -translate-x-1/2 rounded-full bg-orange-500/20 blur-[100px]">
                </div>


                <div class="relative z-10">

                    <span class="text-sm font-bold uppercase tracking-[0.3em] text-orange-500">
                        Licorería El Vecino
                    </span>


                    <h2 class="mt-4 text-3xl font-black md:text-5xl">
                        ¿Listo para disfrutar?
                    </h2>


                    <p class="mx-auto mt-4 max-w-2xl text-gray-400">
                        Explora nuestro catálogo y encuentra
                        el producto ideal para tu próxima ocasión.
                    </p>


                    <a
                        href="#productos"
                        class="primary-button mt-8 inline-flex">

                        Ver productos

                        <i class="fa-solid fa-arrow-right"></i>

                    </a>

                </div>

            </div>

        </section>

    </main>


    <!-- =========================================================
         FOOTER
    ========================================================== -->

    <footer id="contacto" class="footer">

        <div class="footer-container">


            <!-- INFORMACIÓN -->

            <div>

                <a href="{{ url('/') }}" class="brand">

                    <div class="brand-icon">
                        <i class="fa-solid fa-wine-bottle"></i>
                    </div>

                    <div>

                        <span class="brand-title">
                            LICORERÍA
                        </span>

                        <span class="brand-subtitle">
                            EL VECINO
                        </span>

                    </div>

                </a>


                <p class="mt-5 max-w-sm text-gray-500">

                    Una selección pensada para acompañar
                    tus mejores momentos.

                </p>

            </div>


            <!-- ENLACES -->

            <div>

                <h3>
                    Navegación
                </h3>

                <div class="footer-links">

                    <a href="#inicio">
                        Inicio
                    </a>

                    <a href="#categorias">
                        Categorías
                    </a>

                    <a href="#productos">
                        Productos
                    </a>

                    <a href="#ofertas">
                        Ofertas
                    </a>

                </div>

            </div>


            <!-- CATEGORÍAS -->

            <div>

                <h3>
                    Categorías
                </h3>

                <div class="footer-links">

                    <a href="#productos">
                        Whisky
                    </a>

                    <a href="#productos">
                        Vinos
                    </a>

                    <a href="#productos">
                        Champagne
                    </a>

                    <a href="#productos">
                        Cócteles
                    </a>

                </div>

            </div>


            <!-- CONTACTO -->

            <div>

                <h3>
                    Contacto
                </h3>

                <div class="footer-links">

                    <a href="https://wa.me/593984088716"
                        target="_blank"
                        rel="noopener noreferrer">

                        <i class="fa-brands fa-whatsapp mr-2 text-orange-500"></i>

                        WhatsApp

                    </a>


                    @if(Route::has('login'))

                        @auth

                            <a href="{{ url('/dashboard') }}">

                                <i class="fa-solid fa-gauge-high mr-2 text-orange-500"></i>

                                Dashboard

                            </a>

                        @else

                            <a href="{{ route('login') }}">

                                <i class="fa-solid fa-right-to-bracket mr-2 text-orange-500"></i>

                                Iniciar sesión

                            </a>

                        @endauth

                    @endif

                </div>

            </div>

        </div>


        <!-- COPYRIGHT -->

        <div class="footer-bottom">

            <p>
                © {{ date('Y') }} Licorería El Vecino.
                Todos los derechos reservados.
            </p>

            <p>
                Diseñado con
                <span class="text-orange-500">♥</span>
                para disfrutar mejores momentos.
            </p>

        </div>

    </footer>


    <!-- =========================================================
         BOTÓN WHATSAPP
    ========================================================== -->

    <a
        href="https://wa.me/593984088716"
        target="_blank"
        rel="noopener noreferrer"
        class="floating-button floating-whatsapp"
        title="Contactar por WhatsApp">

        <i class="fa-brands fa-whatsapp"></i>

    </a>


    <!-- =========================================================
         BOTÓN CARRITO FLOTANTE
    ========================================================== -->

    <button
        @click="abrirModal()"
        class="floating-button floating-cart"
        title="Ver carrito">

        <i class="fa-solid fa-cart-shopping"></i>

        <span
            x-show="carrito.length > 0"
            x-text="carrito.length"
            class="absolute -right-1 -top-1 flex h-6 w-6 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-black">
        </span>

    </button>


    <!-- =========================================================
         MODAL CARRITO
    ========================================================== -->

    <div
        x-show="modalAbierto"
        x-cloak
        class="cart-overlay"
        @click.self="modalAbierto = false"
        x-transition.opacity>


        <div
            class="cart-modal"
            x-transition.scale>


            <!-- HEADER -->

            <div class="cart-header">

                <div>

                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-orange-500">
                        Tu pedido
                    </span>

                    <h2>
                        Carrito
                    </h2>

                </div>


                <button
                    @click="modalAbierto = false"
                    class="close-button">

                    <i class="fa-solid fa-xmark"></i>

                </button>

            </div>


            <!-- BODY -->

            <div class="cart-body">

            


                <!-- CARRITO VACÍO -->

                <template x-if="carrito.length === 0">

                    <div class="flex h-full min-h-[300px] flex-col items-center justify-center text-center">

                        <div
                            class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-orange-500/10 text-3xl text-orange-500">

                            <i class="fa-solid fa-cart-shopping"></i>

                        </div>

                        <h3 class="mb-2 text-xl font-black">
                            Tu carrito está vacío
                        </h3>

                        <p class="text-sm text-gray-500">
                            Agrega algunos productos para comenzar.
                        </p>

                        <button
                            @click="modalAbierto = false; document.getElementById('productos').scrollIntoView({behavior:'smooth'})"
                            class="mt-5 rounded-xl bg-orange-500 px-5 py-3 font-bold text-black">

                            Ver productos

                        </button>

                    </div>

                </template>


                <!-- PRODUCTOS -->

                <template x-if="carrito.length > 0">

                    <!-- CONTENEDOR DEL CARRITO -->
<div class="space-y-2 my-4">
    
    <template x-for="(item, index) in carrito" :key="index">
        <div class="flex justify-between items-center p-3 border-b border-zinc-800">
            <div>
                <h4 class="text-white font-medium" x-text="item.nombre"></h4>
                <span class="text-xs text-orange-400">Cantidad: <span x-text="item.cantidad || 1"></span></span>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-orange-500 font-bold">
                    $<span x-text="(item.precio * (item.cantidad || 1)).toFixed(2)"></span>
                </div>
                <!-- Botón para eliminar el producto agrupado -->
                <button @click="eliminarDelCarrito(index)" class="text-zinc-500 hover:text-red-400 text-xs">
                    🗑️
                </button>
            </div>
        </div>
    </template>

</div>

                        <template
                            x-for="(item, index) in carrito"
                            :key="index">

                            <div class="cart-item">


                                <!-- ICONO -->

                                <div class="cart-item-image">

                                    <i class="fa-solid fa-wine-bottle"></i>

                                </div>


                                <!-- INFO -->

                                <div class="cart-item-info">

                                    <h4 x-text="item.nombre"></h4>

                                    <p>

                                        $<span x-text="Number(item.precio).toFixed(2)"></span>

                                    </p>

                                </div>


                                <!-- ELIMINAR -->

                                <button
                                    @click="eliminarDelCarrito(index)"
                                    class="remove-item"
                                    title="Eliminar">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </div>

                        </template>

                    </div>

                </template>

            </div>


            <!-- FOOTER -->

            <div
                x-show="carrito.length > 0"
                class="cart-footer">


                <div class="cart-total">

                    <span>
                        Total
                    </span>

                    <strong>
                        $<span x-text="calcularTotal().toFixed(2)"></span>
                    </strong>

                </div>


                <button
                    @click="enviarAWhatsApp()"
                    class="primary-button w-full justify-center">

                    <i class="fa-brands fa-whatsapp"></i>

                    Pedir por WhatsApp

                </button>


                <button
                    @click="carrito = []; modalAbierto = false"
                    class="mt-2 w-full rounded-xl border border-gray-800 px-4 py-3 text-sm font-bold text-gray-500 transition hover:border-red-500 hover:text-red-400">

                    Vaciar carrito

                </button>

            </div>

        </div>

    </div>


    <!-- =========================================================
         ALPINE.JS
    ========================================================== -->

    <script>

        function minimarketApp() {

            return {

                carrito: [],

                modalAbierto: false,

                mostrarEdad: false,

                menuMovil: false,


                /* =============================================
                   INICIALIZAR
                ============================================== */

                init() {

                    const edadConfirmada =
                        localStorage.getItem('edad_confirmada');

                    if (edadConfirmada !== 'true') {

                        this.mostrarEdad = true;

                    }


                    const carritoGuardado =
                        localStorage.getItem('carrito_licoreria');

                    if (carritoGuardado) {

                        try {

                            this.carrito =
                                JSON.parse(carritoGuardado);

                        } catch (error) {

                            this.carrito = [];

                        }

                    }


                    this.$nextTick(() => {

                        this.initReveal();

                    });

                },


                /* =============================================
                   EDAD
                ============================================== */

                confirmarEdad() {

                    localStorage.setItem(
                        'edad_confirmada',
                        'true'
                    );

                    this.mostrarEdad = false;

                },


                salirSitio() {

                    window.location.href =
                        'https://www.google.com';

                },


                /* =============================================
                CARRITO
============================================= */

                agregarAlCarrito(nombre, precio) {
                    // 1. Buscamos si el producto ya existe en el carrito
                    let productoExistente = this.carrito.find(item => item.nombre === nombre);

                    if (productoExistente) {
                        // Si ya existe, sumamos 1 a su cantidad
                        productoExistente.cantidad = (productoExistente.cantidad || 1) + 1;
                    } else {
                        // Si no existe, lo agregamos por primera vez con cantidad 1
                        this.carrito.push({
                            nombre: nombre,
                            precio: Number(precio),
                            cantidad: 1,
                        });
                    }

                    this.guardarCarrito();

                },


                eliminarDelCarrito(index) {
                    this.carrito.splice(index, 1);
                    this.guardarCarrito();
                },


                guardarCarrito() {
                    localStorage.setItem(
                        'carrito_licoreria',
                        JSON.stringify(this.carrito)
                    );
                },


                calcularTotal() {
                    return this.carrito.reduce(
                        (total, item) =>
                            total + (Number(item.precio) * (item.cantidad || 1)),
                        0
                    );
                },


                abrirModal() {
                    this.modalAbierto = true;
                },


               /* =============================================
                    WHATSAPP
============================================= */

                enviarAWhatsApp() {

                    if (!this.carrito.length) {

                        return;

                    }


                    let mensaje =
                        'Hola, Licorería El Vecino 👋%0A%0A';

                    mensaje +=
                        'Quiero realizar el siguiente pedido:%0A%0A';


                    this.carrito.forEach((item, index) => {
                        let cantidad = item.cantidad || 1;
                        let subtotal = Number(item.precio) * cantidad;

                        mensaje +=
                            `${index + 1}. ${cantidad}x ${item.nombre} - $${subtotal.toFixed(2)}%0A`;
                    });


                    mensaje +=
                        `%0A*Total: $${this.calcularTotal().toFixed(2)}*`;


                    const telefono =
                        '593984088716';


                    window.open(
                        `https://wa.me/${telefono}?text=${mensaje}`,
                        '_blank'
                    );

                },
                /* =============================================
                   EFECTO 3D
                ============================================== */

                tiltCard(event) {

                    const card =
                        event.currentTarget;

                    const rect =
                        card.getBoundingClientRect();

                    const x =
                        event.clientX - rect.left;

                    const y =
                        event.clientY - rect.top;


                    const centerX =
                        rect.width / 2;

                    const centerY =
                        rect.height / 2;


                    const rotateX =
                        ((y - centerY) / centerY) * -5;

                    const rotateY =
                        ((x - centerX) / centerX) * 5;


                    card.style.transform =
                        `perspective(1000px)
                         rotateX(${rotateX}deg)
                         rotateY(${rotateY}deg)
                         translateY(-6px)`;

                },


                activarProducto(element) {

                    element.style.zIndex = '5';

                },


                desactivarProducto(element) {

                    element.style.transform = '';

                    element.style.zIndex = '';

                },


                /* =============================================
                   ANIMACIONES SCROLL
                ============================================== */

                initReveal() {

                    const elements =
                        document.querySelectorAll('.fade-up');


                    if (!('IntersectionObserver' in window)) {

                        elements.forEach(element => {

                            element.classList.add('visible');

                        });

                        return;

                    }


                    const observer =
                        new IntersectionObserver(
                            (entries) => {

                                entries.forEach(entry => {

                                    if (entry.isIntersecting) {

                                        entry.target.classList.add('visible');

                                        observer.unobserve(
                                            entry.target
                                        );

                                    }

                                });

                            },
                            {
                                threshold: 0.12
                            }
                        );


                    elements.forEach(element => {

                        observer.observe(element);

                    });

                }

            };

        }

    </script>


    <!-- =========================================================
         EFECTOS ADICIONALES
    ========================================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', () => {

            /* Smooth scroll */

            document.querySelectorAll('a[href^="#"]').forEach(link => {

                link.addEventListener('click', function (event) {

                    const target =
                        document.querySelector(
                            this.getAttribute('href')
                        );


                    if (target) {

                        event.preventDefault();

                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                    }

                });

            });


            /* Parallax suave */

            const hero =
                document.querySelector('.hero-visual');


            if (hero) {

                window.addEventListener('mousemove', (event) => {

                    const x =
                        (window.innerWidth / 2 - event.clientX) / 60;

                    const y =
                        (window.innerHeight / 2 - event.clientY) / 60;


                    hero.style.transform =
                        `translate(${x}px, ${y}px)`;

                });

            }

        });

    </script>

</body>

</html>
