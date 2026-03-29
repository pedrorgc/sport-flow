<x-layouts.app>
    <x-sidebar />

    <main 
        class="flex-grow-1 p-3 p-md-4" 
        style="min-width: 0;"
        x-data="{ modal: null }"
    >

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold mb-0">Espaços</h3>

            <button 
                class="btn btn-primary d-flex align-items-center gap-2"
                @click="modal = 'espaco'"
            >
                <i class="bi bi-plus"></i>
                Novo Espaço
            </button>
        </div>

        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-3 text-muted fw-semibold">
                <i class="bi bi-geo-alt"></i>
                Espaços Esportivos
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <x-panel-card>
                        <div class="d-flex justify-content-between align-items-start">
                            
                            <div>
                                <div class="fw-semibold">teste</div>
                                <div class="text-primary small">Piscina</div>
                                <div class="text-muted small">rua tal</div>
                                <div class="text-muted small">Capacidade: 50</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-light">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-light">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                        </div>
                    </x-panel-card>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2 text-muted fw-semibold">
                <i class="bi bi-clock"></i>
                Reservas
            </div>

            <button 
                class="btn btn-primary d-flex align-items-center gap-2"
                @click="modal = 'reserva'"
            >
                <i class="bi bi-plus"></i>
                Nova Reserva
            </button>
        </div>

        <x-panel-card>
            <select class="form-select form-select-lg" style="max-width: 250px;">
                <option>Todos os espaços</option>
            </select>
        </x-panel-card>

        <x-panel-card>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead style="background:#f9fafb;">
                        <tr class="text-muted small">
                            <th>Espaço</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Finalidade</th>
                            <th>Solicitante</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="fw-semibold">teste</td>
                            <td>21/03/2026</td>
                            <td>12:00 - 23:00</td>
                            <td>boiar</td>
                            <td>eu mesmo aqui</td>

                            <td>
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                    Confirmada
                                </span>
                            </td>

                            <td class="text-end">
                                <button class="btn btn-sm btn-light">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-panel-card>

        <div 
            x-show="modal === 'espaco'"
            x-cloak
            class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.45); z-index: 2000;"
            @click.self="modal = null"
        >
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow w-100" style="max-width: 600px;">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h5 class="fw-bold mb-0">Novo Espaço</h5>
                        <button class="btn btn-sm" @click="modal = null">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome *</label>
                            <input class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tipo *</label>
                            <select class="form-select form-select-lg rounded-3">
                                <option>Quadra</option>
                                <option>Piscina</option>
                                <option>Campo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Capacidade *</label>
                            <input type="number" class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Endereço *</label>
                            <input class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-link text-dark text-decoration-none" @click="modal = null">
                                Cancelar
                            </button>
                            <button class="btn btn-primary px-4">Salvar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div 
            x-show="modal === 'reserva'"
            x-cloak
            class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.45); z-index: 2000;"
            @click.self="modal = null"
        >
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow w-100" style="max-width: 650px;">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h5 class="fw-bold mb-0">Nova Reserva</h5>
                        <button class="btn btn-sm" @click="modal = null">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Espaço *</label>
                            <select class="form-select form-select-lg rounded-3">
                                <option>Selecionar espaço</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Data *</label>
                                <input type="date" class="form-control form-control-lg rounded-3">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">Início *</label>
                                <input type="time" class="form-control form-control-lg rounded-3">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold">Fim *</label>
                                <input type="time" class="form-control form-control-lg rounded-3">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Finalidade *</label>
                            <input class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Solicitante *</label>
                            <input class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-link text-dark text-decoration-none" @click="modal = null">
                                Cancelar
                            </button>
                            <button class="btn btn-primary px-4">Salvar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </main>
</x-layouts.app>