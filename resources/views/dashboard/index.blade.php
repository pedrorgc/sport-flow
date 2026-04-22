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
                <div id="chart-modalidades" style="min-height: 280px; width: 100%;"></div>
            </x-panel-card>
        </div>

        <div class="col-12 col-lg-6">
            <x-panel-card title="Eventos por Status">
                <div id="chart-status" style="min-height: 280px; width: 100%;"></div>
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Verifica se o modo escuro está ativado ao carregar a página
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';

            // Configurações comuns para deixar o gráfico limpo e sem fundo
            const commonOptions = {
                chart: {
                    background: 'transparent',
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                theme: { mode: isDark ? 'dark' : 'light' }
            };

            // ==========================================
            // GRÁFICO 1: Atletas por Modalidade (Colunas)
            // ==========================================
            const modalidadeOptions = {
                ...commonOptions,
                series: [{
                    name: 'Atletas',
                    data: [25, 18, 15, 10, 5] // Dados fictícios
                }],
                chart: {
                    type: 'bar',
                    height: 280,
                    ...commonOptions.chart
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '45%',
                    }
                },
                dataLabels: { enabled: false },
                xaxis: {
                    categories: ['Futsal', 'Vôlei', 'Basquete', 'Natação', 'Handebol'],
                },
                colors: ['#3b82f6'],
                tooltip: {
                    y: { formatter: function (val) { return val + " atletas" } }
                }
            };
            const modalidadeChart = new ApexCharts(document.querySelector("#chart-modalidades"), modalidadeOptions);
            modalidadeChart.render();

            // ==========================================
            // GRÁFICO 2: Eventos por Status (Pizza/Donut)
            // ==========================================
            const statusOptions = {
                ...commonOptions,
                series: [12, 5, 2], // Dados fictícios: Concluídos, Agendados, Cancelados
                chart: {
                    type: 'donut', 
                    height: 280,
                    ...commonOptions.chart
                },
                labels: ['Concluídos', 'Agendados', 'Cancelados'],
                colors: ['#10b981', '#3b82f6', '#ef4444'],
                plotOptions: {
                    pie: {
                        donut: { size: '65%' }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: false }, 
                legend: { position: 'bottom' }
            };
            const statusChart = new ApexCharts(document.querySelector("#chart-status"), statusOptions);
            statusChart.render();

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "data-theme") {
                        const newMode = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                        modalidadeChart.updateOptions({ theme: { mode: newMode } });
                        statusChart.updateOptions({ theme: { mode: newMode } });
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
</x-layouts.app>