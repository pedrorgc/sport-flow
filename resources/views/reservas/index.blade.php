<x-layouts.app>
    <div x-data="{ openModal: false }" class="w-100">
        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Agenda de Reservas</h2>
                <div class="text-secondary small mt-1">Gerencie os horários agendados nos espaços</div>
            </div>
            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Nova Reserva</span>
            </button>
        </div>

        <div class="card-premium mb-4 py-3">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-filter text-muted fs-5"></i>
                <select class="form-select bg-light border-0 shadow-none w-auto" style="min-width: 250px;">
                    <option>Filtrar por Espaço (Todos)</option>
                    <option>teste (Piscina)</option>
                </select>
            </div>
        </div>

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
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
                            <td class="ps-4 py-3 fw-medium titulo-marca">
                                <i class="bi bi-geo-alt text-primary me-1"></i> teste
                            </td>
                            <td class="py-3">
                                <div class="titulo-marca fw-medium">21/03/2026</div>
                                <div class="text-secondary small"><i class="bi bi-clock me-1"></i> 12:00 às 23:00</div>
                            </td>
                            <td class="py-3">
                                <div class="titulo-marca">boiar</div>
                                <div class="text-secondary small"><i class="bi bi-person me-1"></i> eu mesmo aqui</div>
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
</x-layouts.app>