<x-layouts.app>
    <x-sidebar />

    <main class="flex-grow-1 p-3 p-md-4" style="min-width: 0;">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="fw-bold mb-0">Espaços</h3>

            <button class="btn btn-primary d-flex align-items-center gap-2">
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

            <button class="btn btn-primary d-flex align-items-center gap-2">
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

    </main>
</x-layouts.app>