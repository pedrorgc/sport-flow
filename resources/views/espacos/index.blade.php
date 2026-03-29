<x-layouts.app>
    
    <div x-data="{ modal: null }" class="w-100">
    
        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Espaços & Reservas</h2>
                <div class="text-secondary small mt-1">Gerencie locais físicos e horários</div>
            </div>
        </div>

        <div class="mb-5">
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                    <i class="bi bi-geo-alt-fill text-primary"></i>
                    Espaços Esportivos
                </div>

                <button class="btn btn-premium btn-sm d-flex align-items-center gap-2 shadow-sm" @click="modal = 'espaco'">
                    <i class="bi bi-plus-lg"></i>
                    <span class="d-none d-md-inline">Novo Espaço</span>
                </button>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-premium h-100 p-4 border-start border-primary border-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">teste</h5>
                                <div class="badge bg-primary bg-opacity-10 text-primary fw-medium px-2 py-1">Piscina</div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-light text-primary hover-shadow px-2 py-1" title="Editar">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-light text-danger hover-shadow px-2 py-1" title="Excluir">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-secondary small d-flex flex-column gap-2 mt-3">
                            <div><i class="bi bi-map me-2 text-muted"></i> rua tal</div>
                            <div><i class="bi bi-people me-2 text-muted"></i> Capacidade: 50 pessoas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                <div class="d-flex align-items-center gap-2 text-dark fw-bold fs-5">
                    <i class="bi bi-calendar-check-fill text-primary"></i>
                    Agenda de Reservas
                </div>

                <button class="btn btn-premium btn-sm d-flex align-items-center gap-2 shadow-sm" @click="modal = 'reserva'">
                    <i class="bi bi-plus-lg"></i>
                    <span class="d-none d-md-inline">Nova Reserva</span>
                </button>
            </div>

            <div class="card-premium mb-4 py-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-filter text-muted fs-5"></i>
                    <select class="form-select bg-light border-0 shadow-none w-auto">
                        <option>Filtrar por Espaço (Todos)</option>
                        <option>teste (Piscina)</option>
                    </select>
                </div>
            </div>

            <div class="card-premium p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #f8fafc;">
                            <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                                <th class="ps-4 py-3 border-bottom-0">Espaço</th>
                                <th class="py-3 border-bottom-0">Data / Horário</th>
                                <th class="py-3 border-bottom-0">Finalidade & Solicitante</th>
                                <th class="py-3 border-bottom-0">Status</th>
                                <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="border-top-0">
                            <tr>
                                <td class="ps-4 py-3 fw-medium text-dark">
                                    <i class="bi bi-geo-alt text-primary me-1"></i> teste
                                </td>
                                
                                <td class="py-3">
                                    <div class="text-dark fw-medium">21/03/2026</div>
                                    <div class="text-secondary small">
                                        <i class="bi bi-clock me-1"></i> 12:00 às 23:00
                                    </div>
                                </td>

                                <td class="py-3">
                                    <div class="text-dark">boiar</div>
                                    <div class="text-secondary small">
                                        <i class="bi bi-person me-1"></i> eu mesmo aqui
                                    </div>
                                </td>

                                <td class="py-3">
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-medium border border-success border-opacity-25">
                                        Confirmada
                                    </span>
                                </td>

                                <td class="text-end pe-4 py-3">
                                    <button class="btn btn-sm btn-light text-danger hover-shadow" title="Cancelar Reserva">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="modal === 'espaco'" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" 
            x-transition.opacity @click.self="modal = null">
            
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 600px;" 
                     x-show="modal === 'espaco'" x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Novo Espaço</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="modal = null">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Tipo <span class="text-danger">*</span></label>
                                <select class="form-select bg-light">
                                    <option>Quadra</option>
                                    <option>Piscina</option>
                                    <option>Campo</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Capacidade <span class="text-danger">*</span></label>
                                <input type="number" class="form-control bg-light">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Endereço / Localização <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light">
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="modal = null">Cancelar</button>
                            <button type="button" class="btn btn-premium px-4">Salvar Espaço</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="modal === 'reserva'" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" 
            x-transition.opacity @click.self="modal = null">
            
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 650px;" 
                     x-show="modal === 'reserva'" x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Nova Reserva</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="modal = null">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Espaço Desejado <span class="text-danger">*</span></label>
                            <select class="form-select bg-light">
                                <option>Selecionar espaço cadastrado...</option>
                                <option>teste (Piscina)</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Data <span class="text-danger">*</span></label>
                                <input type="date" class="form-control bg-light">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Hora Inicial <span class="text-danger">*</span></label>
                                <input type="time" class="form-control bg-light">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Hora Final <span class="text-danger">*</span></label>
                                <input type="time" class="form-control bg-light">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold small text-secondary">Finalidade da Reserva <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" placeholder="Ex: Treino, Torneio, Lazer">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">Nome do Solicitante <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="modal = null">Cancelar</button>
                            <button type="button" class="btn btn-premium px-4">Confirmar Reserva</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</x-layouts.app>