<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Minimarket El Vecino</title>
    
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body class="custom-body">

    <div class="login-card">
        <div class="header">
            <h2>Bienvenido</h2>
            <p>Acceso a la plataforma</p>
        </div>

        <!-- Formulario oficial de Login de Laravel -->
        <form method="POST" action="{{ route('login') }}" class="form-content">
            @csrf

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email o Username">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Password">
            </div>

            <button type="submit" class="submit-btn">Iniciar Sesión</button>
        </form>

        <div class="footer-text">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Olvidaste tu contraseña?</a>
            @endif
        </div>
    </div>

</body>
</html>