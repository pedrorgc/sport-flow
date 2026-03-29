<x-layouts.app>
    <main class="flex-grow-1" style="min-width: 0;" x-data="{ openModal: false }">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Eventos</h2>

            <button type="button" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Novo Evento</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Eventos" value="1" subtitle="Cadastrados" icon="bi bi-trophy" color="primary" />
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card-premium h-100 p-4 d-flex flex-column">
                    
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-bold text-dark mb-0">Campeonato Regional</h5>

                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning px-3 py-2 fw-medium border border-warning border-opacity-25">
                            Em andamento
                        </span>
                    </div>

                    <div class="mb-4 mt-2">
                        <div class="d-flex align-items-center mb-2 text-secondary">
                            <i class="bi bi-trophy text-primary me-2 fs-5"></i>
                            <span class="fw-medium">Futsal</span>
                        </div>

                        <div class="d-flex align-items-center mb-2 text-secondary">
                            <i class="bi bi-calendar-event text-primary me-2 fs-5"></i>
                            <span>15/05/2026</span>
                        </div>

                        <div class="d-flex align-items-center text-secondary">
                            <i class="bi bi-geo-alt text-primary me-2 fs-5"></i>
                            <span>Ginásio Municipal</span>
                        </div>
                    </div>

                    <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.6;">
                        Torneio anual com as principais equipes da região. Uso de documento original na mesa é obrigatório para todos os atletas.
                    </p>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <button class="btn btn-sm btn-light text-primary hover-shadow fw-medium px-3">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </button>

                        <button class="btn btn-sm btn-light text-danger hover-shadow fw-medium px-3">
                            <i class="bi bi-trash3 me-1"></i> Excluir
                        </button>
                    </div>

                </div>
            </div>

        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" 
            x-transition.opacity
            @click.self="openModal = false">
            
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 700px;" 
                     x-show="openModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Novo Evento</h4>
                        
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome do Evento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Modalidade <span class="text-danger">*</span></label>
                                <select class="form-select bg-light">
                                    <option selected>Selecionar</option>
                                    <option>Futebol</option>
                                    <option>Futsal</option>
                                    <option>Basquete</option>
                                    <option>Vôlei</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Status</label>
                                <select class="form-select bg-light">
                                    <option selected>Planejado</option>
                                    <option>Em andamento</option>
                                    <option>Finalizado</option>
                                    <option>Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Local <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Data <span class="text-danger">*</span></label>
                                <input type="date" class="form-control bg-light">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Regulamento / Descrição</label>
                            <textarea class="form-control bg-light" rows="4"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">
                                Cancelar
                            </button>

                            <button type="button" class="btn btn-premium px-4">
                                Salvar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </main>
</x-layouts.app>