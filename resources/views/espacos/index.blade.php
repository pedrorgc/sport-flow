<x-layouts.app>
    <div x-data="{ openModal: false }" class="w-100">
    
        <div class="d-flex align-items-center justify-content-between mb-5 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Espaços Esportivos</h2>
                <div class="text-secondary small mt-1">Gerencie os locais físicos disponíveis</div>
            </div>

            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" @click="openModal = true">
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

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" 
            x-transition.opacity @click.self="openModal = false">
            
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 600px;" 
                     x-show="openModal" x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Novo Espaço</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="openModal = false">
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
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">Cancelar</button>
                            <button type="button" class="btn btn-premium px-4">Salvar Espaço</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>