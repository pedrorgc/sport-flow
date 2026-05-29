<x-layouts.public>

    <div class="pt-5 pb-4">
        <div class="container py-5 text-center animate-fade-in">
            <h1 class="titulo-marca display-4 fw-bold mb-3">O Esporte em Números</h1>
            <p class="text-secondary lead mx-auto" style="max-width: 650px;">
                Acompanhe o desenvolvimento das nossas modalidades e o impacto das atividades esportivas em nossa
                comunidade em tempo real.
            </p>
        </div>
    </div>

    <div class="container pb-5 animate-fade-in" style="animation-delay: 0.2s;">

        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <div
                    class="card-premium hover-scale-up h-100 p-4 premium-shadow border-0 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-secondary fw-semibold small mb-1"
                            style="letter-spacing: 0.5px;">Atletas Ativos</div>
                        <h2 class="mb-0 fw-bold titulo-marca" style="font-size: 2.8rem; line-height: 1;"
                            x-data="{ count: 0, target: {{ $totalAtletas }} }" x-init="setTimeout(() => {
                                let i = setInterval(() => {
                                    count += Math.ceil((target - count) / 10);
                                    if (count >= target) {
                                        count = target;
                                        clearInterval(i);
                                    }
                                }, 30)
                            }, 200)" x-text="count">0</h2>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center"
                        style="width: 64px; height: 64px;">
                        <i class="bi bi-people-fill icon-bounce" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div
                    class="card-premium hover-scale-up h-100 p-4 premium-shadow border-0 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-secondary fw-semibold small mb-1"
                            style="letter-spacing: 0.5px;">Eventos Realizados</div>
                        <h2 class="mb-0 fw-bold titulo-marca" style="font-size: 2.8rem; line-height: 1;"
                            x-data="{ count: 0, target: {{ $eventosAtivos }} }" x-init="setTimeout(() => {
                                let i = setInterval(() => {
                                    count += Math.ceil((target - count) / 10);
                                    if (count >= target) {
                                        count = target;
                                        clearInterval(i);
                                    }
                                }, 40)
                            }, 300)" x-text="count">0</h2>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-4 d-flex align-items-center justify-content-center"
                        style="width: 64px; height: 64px;">
                        <i class="bi bi-trophy-fill icon-bounce" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div
                    class="card-premium hover-scale-up h-100 p-4 premium-shadow border-0 d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase text-secondary fw-semibold small mb-1"
                            style="letter-spacing: 0.5px;">Inscrições Totais</div>
                        <h2 class="mb-0 fw-bold titulo-marca" style="font-size: 2.8rem; line-height: 1;"
                            x-data="{ count: 0, target: {{ $totalInscricoes }} }" x-init="setTimeout(() => {
                                let i = setInterval(() => {
                                    count += Math.ceil((target - count) / 8);
                                    if (count >= target) {
                                        count = target;
                                        clearInterval(i);
                                    }
                                }, 30)
                            }, 400)" x-text="count">0</h2>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-4 d-flex align-items-center justify-content-center"
                        style="width: 64px; height: 64px;">
                        <i class="bi bi-award-fill icon-bounce" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-7">
                <div class="card-premium p-4 premium-shadow border-0 h-100">
                    <h5 class="titulo-marca mb-4 fw-bold">Atletas por Modalidade</h5>
                    <div id="chart-modalidades" style="min-height: 320px; width: 100%;"></div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="card-premium p-4 premium-shadow border-0 h-100">
                    <h5 class="titulo-marca mb-4 fw-bold">Status da Temporada</h5>
                    <div id="chart-status" class="d-flex justify-content-center align-items-center"
                        style="min-height: 320px; width: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2 animate-fade-in" style="animation-delay: 0.4s;">

            <div class="col-12 col-lg-6">
                <div class="card-premium p-4 premium-shadow border-0 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="titulo-marca mb-0 fw-bold">Top 5 Atletas</h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Participações</span>
                    </div>

                    <div class="list-group list-group-flush">

                        @foreach ($topAtletas as $index => $atleta)
                            <div
                                class="list-group-item bg-transparent border-0 px-0 py-3 d-flex align-items-center justify-content-between {{ $index > 0 ? 'border-top' : '' }} list-hover-highlight">
                                <div class="d-flex align-items-center gap-3">

                                    <div class="{{ $index == 0 ? 'bg-warning text-dark' : 'bg-light text-secondary border' }} fw-bold rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                        style="width: 32px; height: 32px; font-size: 0.85rem;">
                                        {{ $index + 1 }}º
                                    </div>

                                    <div>
                                        <div class="fw-bold titulo-marca">
                                            {{ $atleta->nome }}
                                        </div>

                                        <div class="text-secondary small">
                                            {{ $atleta->modalidade->nome ?? 'Modalidade não informada' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <span class="fw-bold titulo-marca fs-5">
                                        {{ $atleta->inscricoes_count }}
                                    </span>

                                    <div class="text-secondary small">
                                        eventos
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card-premium p-4 premium-shadow border-0 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="titulo-marca mb-0 fw-bold">Próximos Eventos</h5>
                        <i class="bi bi-calendar-event text-primary fs-5"></i>
                    </div>

                    <div class="d-flex flex-column gap-3">

                        @forelse($proximosEventos as $index => $evento)
                            <div class="p-3 rounded-4 border {{ $index == 0 ? 'border-primary border-opacity-10 bg-primary bg-opacity-10' : 'border-opacity-10' }}
            d-flex align-items-center gap-3 list-hover-highlight"
                                style="{{ $index > 0 ? 'background-color: var(--bg-sistema);' : '' }}">

                                <div class="bg-white rounded-3 p-2 text-center shadow-sm d-flex flex-column justify-content-center"
                                    style="min-width: 60px; height: 65px;">

                                    <span class="{{ $index == 0 ? 'text-primary' : 'text-dark' }} fw-bold lh-1"
                                        style="font-size: 1.4rem;">

                                        {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d') }}
                                    </span>

                                    <span class="text-uppercase text-secondary fw-bold" style="font-size: 0.65rem;">

                                        {{ \Illuminate\Support\Str::upper(\Carbon\Carbon::parse($evento->data_inicio)->translatedFormat('F')) }}
                                    </span>

                                </div>

                                <div class="flex-grow-1">

                                    <div class="titulo-marca fw-bold">
                                        {{ $evento->nome }}
                                    </div>

                                    <div class="text-secondary small d-flex flex-wrap align-items-center gap-2">
                                        <span>
                                            <i class="bi bi-geo-alt me-1"></i>
                                            {{ $evento->local }}
                                        </span>

                                        <span class="text-muted">•</span>

                                        <span>
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y') }}
                                        </span>

                                        <span class="text-muted">•</span>

                                        <span>
                                            <i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($evento->data_inicio)->format('H:i') }}
                                        </span>
                                    </div>

                                </div>

                                <span
                                    class="badge {{ $index == 0 ? 'bg-primary rounded-pill px-3' : 'bg-secondary bg-opacity-25 text-secondary rounded-pill px-3 border border-secondary border-opacity-25' }}">
                                    {{ $index == 0 ? 'Inscrições Abertas' : 'Em breve' }}
                                </span>

                            </div>

                        @empty

                            <div class="text-center py-5 text-secondary">

                                <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>

                                <div class="fw-semibold">
                                    Não há eventos programados
                                </div>

                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('turbo:load', function() {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const commonOptions = {
                chart: {
                    background: 'transparent',
                    toolbar: {
                        show: false
                    },
                    fontFamily: 'Inter, sans-serif'
                },
                theme: {
                    mode: isDark ? 'dark' : 'light'
                }
            };

            const modalidadeChart = new ApexCharts(document.querySelector("#chart-modalidades"), {
                ...commonOptions,
                series: [{
                    name: 'Atletas',
                    data: {!! $atletasPorModalidade->pluck('atletas_count') !!}
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    ...commonOptions.chart
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '45%'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: {!! $atletasPorModalidade->pluck('nome') !!},
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                grid: {
                    borderColor: isDark ? '#334155' : '#e2e8f0',
                    strokeDashArray: 4
                },
                colors: ['#3b82f6'],
            });
            modalidadeChart.render();

            const statusChart = new ApexCharts(document.querySelector("#chart-status"), {
                ...commonOptions,
                series: {!! $statusTemporada->pluck('total') !!},
                chart: {
                    type: 'donut',
                    height: 320,
                    ...commonOptions.chart
                },
                labels: {!! $statusTemporada->pluck('status') !!},
                colors: [
                    '#3b82f6', // Agendado
                    '#f59e0b', // Em Andamento
                    '#10b981', // Concluído
                    '#ef4444' // Cancelado
                ],
                stroke: {
                    show: false
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%'
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    markers: {
                        radius: 12
                    }
                },
                dataLabels: {
                    enabled: false
                }
            });
            statusChart.render();

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "data-theme") {
                        const newMode = document.documentElement.getAttribute('data-theme') ===
                            'dark' ? 'dark' : 'light';
                        modalidadeChart.updateOptions({
                            theme: {
                                mode: newMode
                            },
                            grid: {
                                borderColor: newMode === 'dark' ? '#334155' : '#e2e8f0'
                            }
                        });
                        statusChart.updateOptions({
                            theme: {
                                mode: newMode
                            }
                        });
                    }
                });
            });
            observer.observe(document.documentElement, {
                attributes: true
            });
        });
    </script>
</x-layouts.public>
