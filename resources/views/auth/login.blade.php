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
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=League+Spartan:wght@700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            font-size: 1.05rem;
        }

        .left-panel {
            background-color: #eef3ff;
            position: relative;
            overflow: hidden;
        }

        .brand-title {
            font-family: 'League Spartan', sans-serif;
            font-size: 4.5rem;
            color: #0d1b2a;
            margin-bottom: 0.2rem;
        }

        .brand-subtitle {
            font-size: 1.0rem;
            color: #3b5bdb;
            font-weight: 500;
        }

        .brand-description {
            font-size: 1.00rem;
            color: #6c757d;
            max-width: 400px;
            line-height: 1.6;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .delay-1 {
            animation-delay: 0.4s;
        }

        .delay-2 {
            animation-delay: 0.5s;
        }

        .delay-3 {
            animation-delay: 0.6s;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
                max-height: 0;
                padding: 0;
                margin-bottom: 0;
            }

            to {
                opacity: 1;
                transform: translateY(0);
                max-height: 100px;
                padding: 1rem;
                margin-bottom: 1rem;
            }
        }

        .form-group-custom {
            position: relative;
            transition: transform 0.2s ease;
        }

        .form-group-custom:focus-within {
            transform: scale(1.02);
        }

        .input-custom {
            height: 64px;
            padding-left: 3.5rem;
            border-radius: 0.85rem;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            font-size: 1.05rem;
            width: 100%;
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
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.4rem;
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
            height: 64px;
            background: linear-gradient(to right, #2563eb, #4f46e5);
            color: white;
            border: none;
            border-radius: 0.85rem;
            font-weight: 600;
            font-size: 1.15rem;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
        }

        .btn-gradient:hover {
            background: linear-gradient(to right, #1d4ed8, #4338ca);
            transform: scale(1.02);
            color: white;
        }

        .btn-gradient:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>

    <div class="container-fluid vh-100">
        <div class="row h-100">

            <div
                class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center text-center left-panel p-5">
                <div class="mb-4">
                    <img src="{{ asset('images/sportflow_3d.png') }}" alt="SportFlow Icon" width="800"
                        class="img-fluid">
                </div>

                <h1 class="brand-title">SportFlow</h1>
                <div class="brand-subtitle mb-4">
                    <i class="bi bi-stars"></i> Gestão Esportiva Inteligente
                </div>

                <p class="brand-description mt-3">
                    Simplifique a gestão de atletas, eventos e espaços esportivos em uma plataforma completa e
                    intuitiva.
                    <br><br>
                    Controle inscrições, acompanhe resultados, gerencie reservas e visualize estatísticas em tempo real.
                    Tudo que você precisa para organizar seus eventos esportivos com eficiência.
                </p>

                <div class="mt-auto" style="font-size: 0.75rem; color: #a1aab2;">
                    © 2026 SportFlow. Todos os direitos reservados.
                </div>
            </div>

            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="w-100" style="max-width: 460px; padding: 30px;">
                    <h2 class="fw-bold mb-2" style="color: #0d1b2a; font-size: 2.5rem;">Bem-vindo</h2>
                    <p class="text-muted mb-5" style="font-size: 1.1rem;">Faça login para continuar no sistema</p>

                    <form method="POST" action="/login-validar">
                        @csrf

                        <div class="mb-4 animate-fade-in-up delay-1">
                            <label for="username" class="form-label text-dark fw-medium mb-2"
                                style="font-size: 0.95rem;">
                                Usuário
                            </label>
                            <div class="form-group-custom">
                                <i class="bi bi-person icon-custom"></i>
                                <input type="text" class="form-control input-custom" id="username" name="username"
                                    placeholder="Digite seu usuário" value="{{ old('username') }}" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4 animate-fade-in-up delay-2">
                            <label for="password" class="form-label text-dark fw-medium mb-2"
                                style="font-size: 0.95rem;">
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

                        <div class="animate-fade-in-up delay-3 mt-4">
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
