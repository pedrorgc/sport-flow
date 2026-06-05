<!DOCTYPE html>
<html lang="pt-BR" x-data="{ theme: localStorage.getItem('theme') || 'light' }" :data-theme="theme" x-effect="localStorage.setItem('theme', theme)">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal SportFlow</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>

    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-esm.js"></script>

    <style>
        :root {
            --bg-sistema: #f8fafc;
            /* Um tom ligeiramente mais limpo para o público */
            --bg-cards: #ffffff;
            --cor-primaria: #3b82f6;
            /* Azul moderno */
            --cor-borda: #e2e8f0;
        }

        [data-theme="dark"] {
            --bg-sistema: #0f172a;
            --bg-cards: #1e293b;
            --cor-borda: #334155;
        }

        body {
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.01em;
            background-color: var(--bg-sistema) !important;
            color: #334155;
            transition: background-color 0.3s ease;
        }

        [data-theme="dark"] body {
            color: #94a3b8;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .titulo-marca {
            font-weight: 600;
            color: #0f172a;
        }

        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] h4,
        [data-theme="dark"] h5,
        [data-theme="dark"] .titulo-marca {
            color: #f8fafc;
        }

        .card-premium {
            background-color: var(--bg-cards);
            border-radius: 1rem;
            /* Bordas um pouco mais arredondadas no público */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-premium {
            background-color: var(--cor-primaria);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-premium:hover {
            background-color: #2563eb;
            color: white;
            transform: translateY(-1px);
        }

        /* ==============================================
           ESTILOS PREMIUM (PÚBLICO)
           ============================================== */
        .glass-nav {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.85) !important;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        [data-theme="dark"] .glass-nav {
            background-color: rgba(30, 41, 59, 0.85) !important;
        }

        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.08), transparent 40%);
        }

        .premium-shadow {
            box-shadow: 0 10px 30px -12px rgba(0, 0, 0, 0.1) !important;
        }

        [data-theme="dark"] .premium-shadow {
            box-shadow: 0 10px 40px -15px rgba(0, 0, 0, 0.5) !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease forwards;
        }

        /* ==============================================
           ANIMAÇÕES E MICRO-INTERAÇÕES
           ============================================== */

        /* Efeito de levitação nos cards principais */
        .hover-scale-up {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
        }

        .hover-scale-up:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(var(--cor-primaria-rgb, 13, 110, 253), 0.15) !important;
        }

        /* O ícone dá um pequeno pulo e gira levemente no hover do card */
        .hover-scale-up .icon-bounce {
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hover-scale-up:hover .icon-bounce {
            transform: scale(1.15) rotate(5deg);
        }

        /* Efeito de destaque nas listas (Top 5 e Eventos) */
        .list-hover-highlight {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            padding-left: 0.5rem;
            margin-left: -0.5rem;
            /* Compensa o padding inicial */
            border-radius: 0.5rem;
        }

        .list-hover-highlight:hover {
            background-color: rgba(0, 0, 0, 0.02);
            /* Fundo sutil */
            border-left-color: var(--cor-primaria);
            /* Borda azul acende na esquerda */
            transform: translateX(4px);
            /* Desliza sutilmente para a direita */
        }

        [data-theme="dark"] .list-hover-highlight:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        /* Estilizando a barra de progresso do Turbo Drive */
        .turbo-progress-bar {
            height: 4px;
            background-color: #10b981;
            /* A cor 'success' do seu sistema */
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100 hero-gradient">

    <nav class="glass-nav border-bottom py-3" style="border-color: var(--cor-borda) !important;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="/">
                <span class="titulo-marca fs-4 mb-0 fw-bold">SportFlow</span>
            </a>

            <div class="d-flex align-items-center gap-3">
                <button @click="theme = theme === 'light' ? 'dark' : 'light'"
                    class="btn btn-light rounded-circle d-flex align-items-center justify-content-center border-0 text-secondary shadow-sm"
                    style="width: 40px; height: 40px; background-color: var(--bg-sistema);">
                    <i class="bi" :class="theme === 'dark' ? 'bi-moon-stars-fill' : 'bi-sun-fill'"></i>
                </button>

                <a href="/login" class="btn btn-premium px-4 rounded-pill d-none d-sm-block shadow-sm"
                    style="background-color: #3b82f6 !important; color: white !important;">
                    Acesso Restrito
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        {{ $slot }}
    </main>

    <footer class="py-5 text-center mt-5" style="background-color: var(--bg-sistema);">
        <div class="container border-top pt-4" style="border-color: var(--cor-borda) !important;">
            <div class="text-secondary small opacity-75">
                &copy; 2026 SportFlow. Gestão Esportiva Inteligente.
            </div>
        </div>
    </footer>

</body>

</html>
