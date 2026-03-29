<x-layouts.app>
    <main class="flex-grow-1" style="min-width: 0;" x-data="{ openModal: false }">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Atletas</h2>

            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Novo Atleta</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Atletas" value="1" subtitle="Cadastrados" icon="bi bi-people" color="primary" />
            </div>
        </div>

        <div class="card-premium mb-4">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <div class="flex-grow-1" style="min-width:220px;">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-start-0 ps-0" placeholder="Buscar por nome...">
                    </div>
                </div>

                <select class="form-select bg-light" style="width:200px;">
                    <option>Todas modalidades</option>
                    <option>Futebol</option>
                    <option>Vôlei</option>
                    <option>Basquete</option>
                    <option>Futsal</option>
                    <option>Handebol</option>
                </select>

                <select class="form-select bg-light" style="width:200px;">
                    <option>Todas categorias</option>
                    <option>Sub-15</option>
                    <option>Sub-17</option>
                    <option>Sub-20</option>
                    <option>Adulto</option>
                </select>
            </div>
        </div>

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc;">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0">Nome</th>
                            <th class="py-3 border-bottom-0">Modalidade</th>
                            <th class="py-3 border-bottom-0">Categoria</th>
                            <th class="py-3 border-bottom-0">Nasc.</th>
                            <th class="py-3 border-bottom-0">Contato</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="border-top-0">
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                        TE
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">teste</div>
                                        <div class="text-muted small">Doc: 123.456.789-00</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="py-3 text-secondary">Vôlei</td>

                            <td class="py-3">
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-medium border border-success border-opacity-25">
                                    Sub-20
                                </span>
                            </td>

                            <td class="py-3 text-secondary">03/03/2026</td>

                            <td class="py-3 text-secondary">teste@teste.com</td>

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
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 700px;" 
                     x-show="openModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Novo Atleta</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-light">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Documento (CPF/RG)</label>
                                <input type="text" class="form-control bg-light">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Data de Nascimento <span class="text-danger">*</span></label>
                                <input type="date" class="form-control bg-light">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Modalidade <span class="text-danger">*</span></label>
                                <select class="form-select bg-light">
                                    <option>Selecionar</option>
                                    <option>Futebol</option>
                                    <option>Vôlei</option>
                                    <option>Basquete</option>
                                    <option>Futsal</option>
                                    <option>Handebol</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Categoria <span class="text-danger">*</span></label>
                                <select class="form-select bg-light">
                                    <option>Selecionar</option>
                                    <option>Sub-15</option>
                                    <option>Sub-17</option>
                                    <option>Sub-20</option>
                                    <option>Adulto</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Contato (telefone/E-mail)</label>
                            <input type="text" class="form-control bg-light">
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">
                                Cancelar
                            </button>

                            <button type="button" class="btn btn-premium px-4">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </main>
</x-layouts.app>