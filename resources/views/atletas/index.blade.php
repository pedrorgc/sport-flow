<x-layouts.app>
    <x-sidebar />

    <main class="flex-grow-1 p-4 p-md-5" style="min-width: 0;">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1">Atletas</h4>
            </div>

            <button class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus"></i>
                Novo Atleta
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Atletas" value="1" subtitle="Cadastrados" icon="bi bi-people" />
            </div>
        </div>

        <x-panel-card>
            <div class="d-flex flex-wrap gap-2 align-items-center">

                <div class="flex-grow-1" style="min-width:220px;">
                    <input type="text" class="form-control form-control-lg" placeholder="Buscar por nome...">
                </div>

                <select class="form-select form-select-lg" style="width:230px;">
                    <option>Todas modalidade</option>
                    <option>Futebol</option>
                    <option>Vôlei</option>
                    <option>Basquete</option>
                    <option>Futsal</option>
                    <option>Handebol</option>
                </select>

                <select class="form-select form-select-lg" style="width:215px;">
                    <option>Todas categorias</option>
                    <option>Sub-15</option>
                    <option>Sub-17</option>
                    <option>Sub-20</option>
                    <option>Adulto</option>
                </select>

            </div>
        </x-panel-card>

        <x-panel-card>
            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead style="background:#f9fafb;">
                        <tr class="text-muted small">
                            <th>Nome</th>
                            <th>Modalidade</th>
                            <th>Categoria</th>
                            <th>Nasc.</th>
                            <th>Contato</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td class="fw-semibold">teste</td>
                            <td>Vôlei</td>

                            <td>
                                <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                    Sub-20
                                </span>
                            </td>

                            <td>03/03/2026</td>

                            <td class="text-muted">
                                teste@teste.com
                            </td>

                            <td class="text-end">
                                <button class="btn btn-sm btn-light">
                                    <i class="bi bi-pencil"></i>
                                </button>
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
