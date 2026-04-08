<x-layouts.app>
    <div x-data="{ openModal: false }" class="w-100">
        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Resultados</h2>
                <div class="text-secondary small mt-1">1 resultado registrado</div>
            </div>
            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Lançar Resultado</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Resultados" value="1" subtitle="Cadastrados" icon="bi bi-award" color="warning" />
            </div>
        </div>

        <div class="card-premium mb-4 py-3">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <select class="form-select bg-light border-0 shadow-none" style="width:250px;">
                    <option>Todos os Eventos</option>
                </select>
            </div>
        </div>

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0" style="width: 100px;">Posição</th>
                            <th class="py-3 border-bottom-0">Atleta</th>
                            <th class="py-3 border-bottom-0">Evento</th>
                            <th class="py-3 border-bottom-0">Marca / Pontos</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="badge rounded-pill bg-warning bg-opacity-25 titulo-marca px-3 py-2 fw-bold border border-warning border-opacity-50 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-trophy-fill text-warning"></i> 1º
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">TE</div>
                                    <div><div class="fw-semibold titulo-marca">teste</div></div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="fw-medium titulo-marca">Campeonato Regional</div>
                                <div class="text-secondary small">Futsal</div>
                            </td>
                            <td class="py-3">
                                <div class="fw-semibold titulo-marca">15 Gols</div>
                                <div class="text-secondary small">Artilheiro</div>
                            </td>
                            <td class="text-end pe-4 py-3">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button class="btn btn-sm btn-light text-primary hover-shadow"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-sm btn-light text-danger hover-shadow"><i class="bi bi-trash3"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>