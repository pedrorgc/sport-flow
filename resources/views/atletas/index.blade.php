<x-layouts.app>
    <x-sidebar />

    <main class="flex-grow-1 p-4 p-md-5" style="min-width: 0;" x-data="{ openModal: false }">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-bold mb-1">Atletas</h2>

            <button class="btn btn-primary d-flex align-items-center gap-2" @click="openModal = true">
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
        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.45); z-index: 2000;" @click.self="openModal = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow w-100" style="max-width: 700px;">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h3 class="fw-bold mb-0">Novo Atleta</h3>

                        <button class="btn btn-sm" @click="openModal = false">
                            <i class="bi bi-x-lg fs-4"></i>
                        </button>
                    </div>

                    <form class="p-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome Completo *</label>
                            <input type="text" class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Documento (CPF/RG)</label>
                                <input class="form-control form-control-lg rounded-3">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Data de Nascimento</label>
                                <input type="date" class="form-control form-control-lg rounded-3">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Modalidade *</label>
                                <select class="form-select form-select-lg rounded-3">
                                    <option>Selecionar</option>
                                    <option>Futebol</option>
                                    <option>Vôlei</option>
                                    <option>Basquete</option>
                                    <option>Futsal</option>
                                    <option>Handebol</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Categoria *</label>
                                <select class="form-select form-select-lg rounded-3">
                                    <option>Selecionar</option>
                                    <option>Sub-15</option>
                                    <option>Sub-17</option>
                                    <option>Sub-20</option>
                                    <option>Adulto</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contato (telefone/E-mail)</label>
                            <input class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-link text-dark text-decoration-none"
                                @click="openModal = false">
                                Cancelar
                            </button>

                            <button class="btn btn-primary px-4 rounded-3">
                                Salvar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
