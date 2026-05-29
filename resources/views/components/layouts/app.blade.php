<!DOCTYPE html>
<html lang="pt-BR" x-data="{ theme: localStorage.getItem('theme') || 'light' }" :data-theme="theme" x-effect="localStorage.setItem('theme', theme)">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportFlow</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>

    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-esm.js"></script>

    <style>
        /* ==============================================
           PALETA DE CORES: MODO CLARO (Padrão)
           ============================================== */
        :root {
            --bg-sistema: #f1f5f9;
            --bg-cards: #ffffff;
            --cor-texto-titulo: #1e293b;
            --cor-texto-corpo: #334155;
            --cor-borda: #e2e8f0;
            --cor-hover: #f8fafc;
            --cor-primaria: #0d6efd;
            --sombra-card: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
        }

        /* ==============================================
           PALETA DE CORES: MODO ESCURO
           ============================================== */
        [data-theme="dark"] {
            --bg-sistema: #0f172a;
            /* Slate 900 (Fundo bem escuro) */
            --bg-cards: #1e293b;
            /* Slate 800 (Fundo das caixas) */
            --cor-texto-titulo: #f8fafc;
            /* Quase branco */
            --cor-texto-corpo: #94a3b8;
            /* Cinza claro */
            --cor-borda: #334155;
            /* Borda escura */
            --cor-hover: #334155;
            /* Fundo do menu ao passar o mouse */
            --cor-primaria: #3b82f6;
            /* Azul um pouco mais vivo para dar contraste no escuro */
            --sombra-card: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        /* ==============================================
           APLICAÇÃO DAS VARIÁVEIS NO SISTEMA
           ============================================== */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-sistema) !important;
            color: var(--cor-texto-corpo);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .titulo-marca {
            font-weight: 600;
            color: var(--cor-texto-titulo);
        }

        .card-premium {
            background-color: var(--bg-cards);
            border: 1px solid var(--cor-borda);
            border-radius: 0.75rem;
            box-shadow: var(--sombra-card);
            padding: 1.5rem;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-premium {
            background-color: var(--cor-primaria);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: background-color 0.2s;
        }

        .btn-premium:hover {
            background-color: #2563eb;
            color: white;
        }

        /* Sidebar Base */
        .sidebar-premium {
            background-color: var(--bg-cards) !important;
            border-right: 1px solid var(--cor-borda) !important;
            transition: background-color 0.3s ease;
        }

        .active-item {
            background-color: var(--cor-primaria) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
            transform: translateY(-1px);
        }

        .active-item i {
            color: #ffffff !important;
        }

        .item-hover:not(.active-item):hover {
            background-color: var(--cor-hover);
            color: var(--cor-primaria) !important;
            transform: translateX(6px);
        }

        .item-hover:not(.active-item):hover i {
            color: var(--cor-primaria) !important;
        }

        .main-content {
            flex-grow: 1;
            padding: 2rem;
            height: 100vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
                padding-top: 4.5rem;
            }
        }

        /* ==============================================
           HACK: ADAPTANDO O BOOTSTRAP PARA O MODO ESCURO
           Isso evita que você precise mudar o HTML das outras telas!
           ============================================== */
        [data-theme="dark"] .bg-white {
            background-color: var(--bg-cards) !important;
        }

        [data-theme="dark"] .bg-light {
            background-color: #0f172a !important;
            color: var(--cor-texto-corpo);
            border-color: var(--cor-borda) !important;
        }

        [data-theme="dark"] .text-dark {
            color: var(--cor-texto-titulo) !important;
        }

        [data-theme="dark"] .text-secondary,
        [data-theme="dark"] .text-muted {
            color: var(--cor-texto-corpo) !important;
        }

        [data-theme="dark"] .border-bottom,
        [data-theme="dark"] .border-top {
            border-color: var(--cor-borda) !important;
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #0f172a;
            border-color: var(--cor-borda);
            color: var(--cor-texto-titulo);
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: #0f172a;
            color: var(--cor-texto-titulo);
        }

        [data-theme="dark"] .btn-light {
            background-color: var(--cor-hover);
            color: var(--cor-texto-titulo);
            border-color: var(--cor-borda);
        }

        /* Inverte a cor da Logo Preta para Branca no modo escuro */
        [data-theme="dark"] .logo-img {
            filter: brightness(0) invert(1);
        }

        [data-theme="dark"] .table {
            color: var(--cor-texto-corpo);
            --bs-table-bg: transparent;
            --bs-table-hover-bg: var(--cor-hover);
            --bs-table-border-color: var(--cor-borda);
        }

        [data-theme="dark"] th {
            color: var(--cor-texto-titulo);
        }

        [x-cloak] {
            display: none !important;
        }

        [data-theme="dark"] .form-control::placeholder,
        [data-theme="dark"] .form-select::placeholder {
            color: #94a3b8 !important;
            opacity: 1 !important;
        }

        [data-theme="dark"] .form-label {
            color: var(--cor-texto-titulo) !important;
        }

        [data-theme="dark"] .form-text {
            color: #94a3b8 !important;
        }

        [data-theme="dark"] .text-primary {
            color: #60a5fa !important;
        }

        [data-theme="dark"] .bg-primary {
            background-color: #3b82f6 !important;
        }

        [data-theme="dark"] .text-secondary {
            color: #94a3b8 !important;
        }

        /* Estilizando a barra de progresso do Turbo Drive */
        .turbo-progress-bar {
            height: 4px;
            background-color: #10b981;
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">
        <x-sidebar />
        <main class="main-content">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
