<x-layouts.app>
    
    <div class="d-flex align-items-center mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
        <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Dashboard</h2>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6 col-xl-3">
            <x-stat-card title="Atletas" value="1" subtitle="Cadastrados" icon="bi bi-people" color="primary" />
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <x-stat-card title="Eventos" value="1" subtitle="No sistema" icon="bi bi-trophy" color="primary" />
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <x-stat-card title="Inscrições" value="0" subtitle="Realizadas" icon="bi bi-award" color="secondary" />
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <x-stat-card title="Em andamento" value="0" subtitle="Eventos ativos" icon="bi bi-graph-up" color="success" />
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

    <div class="row mb-4">
        <div class="col-12">
            <x-panel-card title="Top 5 Atletas (por participações)">
                <div class="d-flex align-items-center justify-content-center text-muted" style="min-height: 180px;">
                    Nenhuma inscrição registrada ainda
                </div>
            </x-panel-card>
        </div>
    </div>

</x-layouts.app>