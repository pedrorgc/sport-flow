<x-layouts.app>
    <div x-data="{ openModal: false }" class="w-100">
        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Inscrições</h2>
                <div class="text-secondary small mt-1">1 inscrição registrada</div>
            </div>
            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Nova Inscrição</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Inscrições" value="1" subtitle="Realizadas" icon="bi bi-journal-check" color="secondary" />
            </div>
        </div>

        <div class="card-premium mb-4 py-3">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <select class="form-select bg-light border-0 shadow-none" style="width:250px;">
                    <option>Todos os Eventos</option>
                    <option>Campeonato Regional</option>
                </select>
            </div>
        </div>

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0">Atleta</th>
                            <th class="py-3 border-bottom-0">Evento</th>
                            <th class="py-3 border-bottom-0">Data da Inscrição</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">TE</div>
                                    <div>
                                        <div class="fw-semibold titulo-marca">teste</div>
                                        <div class="text-secondary small">Sub-20 - Futsal</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="fw-medium titulo-marca">Campeonato Regional</div>
                                <div class="text-secondary small">Futsal</div>
                            </td>
                            <td class="py-3 text-secondary">
                                <i class="bi bi-calendar3 me-2 text-primary opacity-75"></i> 29/03/2026
                            </td>
                            <td class="text-end pe-4 py-3">
                                <button class="btn btn-sm btn-light text-danger hover-shadow" title="Cancelar Inscrição"><i class="bi bi-trash3"></i></button>
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
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 600px;" 
                     x-show="openModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Nova Inscrição</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Atleta <span class="text-danger">*</span></label>
                            <select class="form-select bg-light">
                                <option>Selecionar atleta...</option>
                                <option>teste (Sub-20 - Futsal)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Evento <span class="text-danger">*</span></label>
                            <select class="form-select bg-light">
                                <option>Selecionar evento...</option>
                                <option>Campeonato Regional (Futsal)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">Cancelar</button>
                            <button type="button" class="btn btn-premium px-4">Confirmar Inscrição</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div> </x-layouts.app>