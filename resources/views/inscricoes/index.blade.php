<x-layouts.app>
    <x-sidebar />

    <main class="flex-grow-1 p-3 p-md-4" style="min-width: 0;" x-data="{ openModal: false }">
    
    <div class ="d-flex align-items-center
        justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Inscrições</h4>
            <small class="text-muted">0 inscrições registradas</small>
        </div>

        <button class="btn btn-primary d-flex align-items-center gap-2" @click="openModal = true">
            <i class="bi bi-plus"></i>
            Nova Inscrição
        </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Inscrições" value="0" subtitle="Cadastrados" icon="bi bi-journal-check" />
            </div>
        </div>

        <x-panel-card>
            <div class="d-flex flex-wrap gap-2 align-items-center">

                <select class="form-select form-select-lg" style="width:250px;">
                    <option>Todos os Eventos</option>
                </select>

            </div>
        </x-panel-card>

        <x-panel-card>
            <div class="d-flex align-items-center justify-content-center text-muted" style="min-height: 180px;">
                Nenhuma inscrição encontrada
            </div>
        </x-panel-card>
        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.45); z-index: 2000;" @click.self="openModal = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow w-100" style="max-width: 700px;">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h3 class="fw-bold mb-0">Nova Inscrição</h3>

                        <button class="btn btn-sm" @click="openModal = false">
                            <i class="bi bi-x-lg fs-4"></i>
                        </button>
                    </div>

                    <form class="p-4">

                        <div class=" mb-3">
                                <label class="form-label fw-semibold">Atleta *</label>
                                <select class="form-select form-select-lg rounded-3">
                                    <option>Selecionar atleta</option>
                                </select>
                            </div>

                        <div class=" mb-3">
                                <label class="form-label fw-semibold">Evento *</label>
                                <select class="form-select form-select-lg rounded-3">
                                    <option>Selecionar evento</option>
                                </select>
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
