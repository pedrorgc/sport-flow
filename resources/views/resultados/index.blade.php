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
                    <option>Campeonato Regional</option>
                    <option>Copa de Inverno</option>
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
                                    <button class="btn btn-sm btn-light text-primary hover-shadow" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-light text-danger hover-shadow" title="Excluir">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" 
            x-transition.opacity
            @click.self="openModal = false">
            
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 650px;" 
                     x-show="openModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Lançar Resultado</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Evento <span class="text-danger">*</span></label>
                            <select class="form-select bg-light">
                                <option>Selecionar evento...</option>
                                <option>Campeonato Regional</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Atleta <span class="text-danger">*</span></label>
                            <select class="form-select bg-light">
                                <option>Selecionar atleta inscrito...</option>
                                <option>teste (Sub-20)</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Posição <span class="text-danger">*</span></label>
                                <input type="number" class="form-control bg-light" placeholder="Ex: 1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Marca / Pontuação</label>
                                <input type="text" class="form-control bg-light" placeholder="Ex: 15 Gols ou 02:45.00">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Observações</label>
                            <textarea class="form-control bg-light" rows="3" placeholder="Detalhes opcionais..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">Cancelar</button>
                            <button type="button" class="btn btn-premium px-4">Registrar Resultado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div> </x-layouts.app>