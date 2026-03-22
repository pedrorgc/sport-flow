<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportFlow - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=League+Spartan:wght@700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            font-size: clamp(0.95rem, 1vw + 0.5rem, 1.05rem); 
        }

        .left-panel {
            background-color: #eef3ff;
            position: relative;
            overflow: hidden;
        }

        .brand-title {
            font-family: 'League Spartan', sans-serif;
            font-size: clamp(3rem, 5vw, 4.5rem);
            color: #0d1b2a;
            margin-bottom: 0.2rem;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: clamp(0.9rem, 1.5vw, 1rem);
            color: #3b5bdb;
            font-weight: 500;
        }

        .brand-description {
            font-size: clamp(0.9rem, 1vw + 0.2rem, 1rem);
            color: #6c757d;
            max-width: 400px;
            line-height: 1.6;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.4s; }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); max-height: 0; padding: 0; margin-bottom: 0; }
            to { opacity: 1; transform: translateY(0); max-height: 100px; padding: 1rem; margin-bottom: 1rem; }
        }

        .form-group-custom {
            position: relative;
            transition: transform 0.2s ease;
        }

        .form-group-custom:focus-within {
            transform: scale(1.02);
        }

        .input-custom, .btn-gradient {
            height: clamp(50px, 7vh, 64px); 
            border-radius: 0.85rem;
            transition: all 0.2s ease;
            width: 100%;
        }

        .input-custom {
            padding-left: clamp(2.8rem, 4vw, 3.5rem);
            border: 1px solid #e5e7eb;
            font-size: clamp(1rem, 1vw + 0.5rem, 1.05rem);
            background-color: #f9fafb;
        }

        .input-custom:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.2);
            outline: none;
            background-color: #ffffff;
        }

        .icon-custom {
            position: absolute;
            left: clamp(1rem, 2vw, 1.25rem);
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: clamp(1.2rem, 1.5vw, 1.4rem);
            z-index: 10;
        }

        .error-alert {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fee2e2;
            border-radius: 0.75rem;
            font-size: 0.95rem;
            overflow: hidden;
            animation: slideDown 0.3s ease forwards;
        }

        .btn-gradient {
            background: linear-gradient(to right, #2563eb, #4f46e5);
            color: white;
            border: none;
            font-weight: 600;
            font-size: clamp(1rem, 1.5vw, 1.15rem);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        .btn-gradient:hover {
            background: linear-gradient(to right, #1d4ed8, #4338ca);
            transform: scale(1.02);
            color: white;
        }

        .btn-gradient:active {
            transform: scale(0.98);
        }

        @media (max-height: 750px) {
            .brand-description { display: none; } 
            .mb-5 { margin-bottom: 1.5rem !important; }
            .mb-4 { margin-bottom: 1rem !important; }
            .mt-4 { margin-top: 1rem !important; }
        }
    </style>
</head>

<body>

    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">

            <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center text-center left-panel p-4 p-lg-5">
                <div class="mb-3 mb-xl-4">
                    <img src="{{ asset('images/sportflow_3d.png') }}" alt="SportFlow Icon" class="img-fluid" style="max-height: 30vh; width: auto; object-fit: contain;">
                </div>

                <h1 class="brand-title">SportFlow</h1>
                <div class="brand-subtitle mb-3 mb-xl-4">
                    <i class="bi bi-stars"></i> Gestão Esportiva Inteligente
                </div>

                <p class="brand-description mt-2">
                    Simplifique a gestão de atletas, eventos e espaços esportivos em uma plataforma completa e intuitiva.
                    <br><br>
                    Controle inscrições, acompanhe resultados, gerencie reservas e visualize estatísticas em tempo real.
                </p>

                <div class="mt-auto" style="font-size: 0.75rem; color: #a1aab2;">
                    © 2026 SportFlow. Todos os direitos reservados.
                </div>
            </div>

            <div class="col-md-6 d-flex justify-content-center align-items-center p-4 p-md-5">
                <div class="w-100" style="max-width: 460px;">
                    <h2 class="fw-bold mb-2" style="color: #0d1b2a; font-size: clamp(2rem, 3vw, 2.5rem);">Bem-vindo</h2>
                    <p class="text-muted mb-4 mb-xl-5" style="font-size: clamp(0.95rem, 1.5vw, 1.1rem);">Faça login para continuar no sistema</p>

                    <form method="POST" action="/login-validar">
                        @csrf

                        <div class="mb-3 mb-xl-4 animate-fade-in-up delay-1">
                            <label for="username" class="form-label text-dark fw-medium mb-2" style="font-size: clamp(0.85rem, 1vw, 0.95rem);">
                                Usuário
                            </label>
                            <div class="form-group-custom">
                                <i class="bi bi-person icon-custom"></i>
                                <input type="text" class="form-control input-custom" id="username" name="username"
                                    placeholder="Digite seu usuário" value="{{ old('username') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3 mb-xl-4 animate-fade-in-up delay-2">
                            <label for="password" class="form-label text-dark fw-medium mb-2" style="font-size: clamp(0.85rem, 1vw, 0.95rem);">
                                Senha
                            </label>
                            <div class="form-group-custom">
                                <i class="bi bi-lock icon-custom"></i>
                                <input type="password" class="form-control input-custom" id="password" name="password"
                                    placeholder="Digite sua senha" required>
                            </div>
                        </div>

                        @error('username')
                            <div class="animate-fade-in-up delay-2">
                                <div class="error-alert">
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror

                        <div class="animate-fade-in-up delay-3 mt-3 mt-xl-4">
                            <button type="submit" class="btn btn-gradient">
                                Entrar
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</body>
</html>