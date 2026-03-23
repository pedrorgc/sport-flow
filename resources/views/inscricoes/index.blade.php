<x-layouts.app>
    <x-sidebar />

    <main class="flex-grow-1 p-3 p-md-4" style="min-width: 0;">

        {{-- HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1">Inscrições</h4>
                <small class="text-muted">0 inscrições registradas</small>
            </div>

            <button class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-journal-check"></i>
                Nova Inscrição
            </button>
        </div>

        {{-- STATS (opcional, mas recomendado) --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Inscrições" value="0" subtitle="Cadastrados" icon="bi bi-journal-check" />
            </div>
        </div>

        {{-- FILTROS --}}
        <x-panel-card>
            <div class="d-flex flex-wrap gap-2 align-items-center">

                <select class="form-select form-select-lg" style="width:250px;">
                    <option>Todos os Eventos</option>
                </select>

            </div>
        </x-panel-card>

        {{-- TABELA --}}
        <x-panel-card>
            <div class="d-flex align-items-center justify-content-center text-muted" style="min-height: 180px;">
                Nenhuma inscrição encontrada
        </x-panel-card>

    </main>
</x-layouts.app>
