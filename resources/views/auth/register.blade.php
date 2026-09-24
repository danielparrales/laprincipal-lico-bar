<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Minimarket El Vecino</title>
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body class="custom-body">

    <div class="login-card" style="height: 600px;"> <!-- Ajustado ligeramente para más campos -->
        <div class="header">
            <h2>Registro</h2>
            <p>Únete a nuestra plataforma</p>
        </div>

        <!-- Formulario oficial de Registro de Laravel -->
        <form method="POST" action="{{ route('register') }}" class="form-content" style="opacity: 1; transform: translateY(10px); pointer-events: all;">
            @csrf

            <div class="input-group" style="gap: 4px;">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Tu nombre">
            </div>

            <div class="input-group" style="gap: 4px;">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="correo@domain.com">
            </div>

            <div class="input-group" style="gap: 4px;">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>

            <div class="input-group" style="gap: 4px;">
                <label for="password_confirmation">Confirm</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
            </div>

            <button type="submit" class="submit-btn" style="margin-top: 5px;">Crear una cuenta</button>
        </form>

        <div class="footer-text" style="opacity: 1;">
            <a href="{{ route('login') }}">Ya registrado?</a>
        </div>
    </div>

</body>
</html>