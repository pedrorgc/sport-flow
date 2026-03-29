<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportFlow</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-sistema: #f1f5f9; /* Cinza claro elegante que devolve o contraste */
            --cor-primaria: #0d6efd; /* Azul padrão, sem gradientes exagerados */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-sistema) !important;
            color: #334155;
        }

        /* Títulos limpos, sem ser muito negritados */
        h1, h2, h3, h4, h5, .titulo-marca {
            font-weight: 600;
            color: #1e293b;
        }

        /* Os cards brancos agora vão aparecer de verdade */
        .card-premium {
            background-color: #ffffff;
            border: 1px solid #e2e8f0; /* Borda bem sutil */
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
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
            background-color: #0b5ed7;
            color: white;
        }

        /* ==============================================
           ESTILOS EXCLUSIVOS DA SIDEBAR
           ============================================== */
        .sidebar-premium {
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0 !important;
        }

        /* O botão da página atual (Azul com sombra brilhante) */
        .active-item {
            background-color: var(--cor-primaria) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3); /* Sombra azulada moderna */
            transform: translateY(-1px); /* Levanta um milímetro */
        }
        
        .active-item i {
            color: #ffffff !important;
        }

        /* O botão inativo ao passar o mouse */
        .item-hover:not(.active-item):hover {
            background-color: #f8fafc; /* Cinza super claro, quase branco */
            color: var(--cor-primaria) !important; /* Texto fica azul */
            transform: translateX(6px); /* Efeito de deslizar para a direita */
        }
        
        /* Acende apenas o ícone de azul no hover */
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
            .main-content { padding: 1rem; padding-top: 4.5rem; }
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