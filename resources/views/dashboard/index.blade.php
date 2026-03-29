<x-layouts.app>
    <x-sidebar />

    <main class="flex-grow-1 p-3 p-md-4" style="min-width: 0;">
        <div class="d-flex d-md-none align-items-center mb-4" style="padding-left: 47px; min-height: 47px;">
            <h2 class="fw-bold mb-0">Dashboard</h2>
        </div>

        <div class="d-none d-md-flex align-items-center mb-4">
            <h2 class="fw-bold mb-0">Dashboard</h2>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <x-stat-card title="Atletas" value="1" subtitle="cadastrados" icon="bi bi-people" color="primary" />
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <x-stat-card title="Eventos" value="1" subtitle="no sistema" icon="bi bi-trophy" color="primary" />
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <x-stat-card title="Inscrições" value="0" subtitle="realizadas" icon="bi bi-award"
                    color="secondary" />
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <x-stat-card title="Em andamento" value="0" subtitle="eventos ativos" icon="bi bi-graph-up"
                    color="success" />
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <x-panel-card title="Atletas por Modalidade">
                    <div class="d-flex align-items-center justify-content-center text-muted" style="min-height: 280px;">
                        Gráfico em desenvolvimento
                    </div>
                </x-panel-card>
            </div>

            <div class="col-12 col-lg-6">
                <x-panel-card title="Eventos por Status">
                    <div class="d-flex align-items-center justify-content-center text-muted" style="min-height: 280px;">
                        Gráfico em desenvolvimento
                    </div>
                </x-panel-card>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <x-panel-card title="Top 5 Atletas (por participações)">
                    <div class="d-flex align-items-center justify-content-center text-muted" style="min-height: 180px;">
                        Nenhuma inscrição registrada ainda
                    </div>
                </x-panel-card>
            </div>
        </div>
    </main>
</x-layouts.app>
