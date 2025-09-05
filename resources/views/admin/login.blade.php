<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAI - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Variables de color para fácil personalización */
        :root {
            --primary-color: #0d6efd; /* Azul primario de Bootstrap */
            --light-gray: #f8f9fa;
            --dark-text: #212529;
            --gray-text: #6c757d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .login-image-section {
            background-image: url('{{ asset('example.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .login-form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-form-container {
            width: 100%;
            max-width: 450px;
        }

        .login-form-container h2 {
            color: var(--dark-text);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-form-container .form-text {
            color: var(--gray-text);
            margin-bottom: 2rem;
        }

        .form-control {
            padding: 0.8rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-login {
            background-color: var(--primary-color);
            border: none;
            padding: 0.8rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .btn-login:hover {
            background-color: #0b5ed7; /* Un azul un poco más oscuro */
        }

        .form-check-label {
            color: var(--gray-text);
        }

        .forgot-password-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0 login-container">
        <div class="row g-0 w-100">
            <div class="col-lg-7 d-none d-lg-block login-image-section">
                {{-- Esta columna solo contiene la imagen de fondo via CSS --}}
            </div>

            <div class="col-lg-5 col-md-12 login-form-section">
                <div class="login-form-container">
                    
                    {{-- Logo o Título --}}
                    <h2 class="text-center text-lg-start">Admin Panel</h2>
                    <p class="text-center text-lg-start form-text">Welcome back! Please enter your details.</p>

                    {{-- Formulario de Login --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Mostrar errores de validación si existen --}}
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            {{-- Si tienes una ruta para "olvidé mi contraseña", puedes añadirla aquí --}}
                            {{-- <a href="#" class="forgot-password-link">Forgot password?</a> --}}
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-login">
                            Iniciar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>