<x-layouts.app>
    <x-sidebar />

    <main 
        class="flex-grow-1 p-3 p-md-4" 
        style="min-width: 0;"
        x-data="{ openModal: false }"
    >

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold mb-1">Resultados</h4>
                <small class="text-muted">0 resultados registrados</small>
            </div>

            <button 
                class="btn btn-primary d-flex align-items-center gap-2"
                @click="openModal = true"
            >
                <i class="bi bi-plus"></i>
                Lançar resultados
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6 col-xl-3">
                <x-stat-card 
                    title="Resultados" 
                    value="0" 
                    subtitle="Cadastrados" 
                    icon="bi bi-award" 
                />
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
                Nenhum resultado encontrado
            </div>
        </x-panel-card>

        <div 
            x-show="openModal"
            x-cloak
            class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.45); z-index: 2000;"
            @click.self="openModal = false"
        >
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow w-100" style="max-width: 650px;">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h5 class="fw-bold mb-0">Lançar Resultado</h5>

                        <button class="btn btn-sm" @click="openModal = false">
                            <i class="bi bi-x-lg fs-5"></i>
                        </button>
                    </div>

                    <form class="p-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Evento * 
                                <span class="text-muted">(Em andamento ou Finalizado)</span>
                            </label>
                            <select class="form-select form-select-lg rounded-3">
                                <option>Selecionar evento</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Atleta *</label>
                            <select class="form-select form-select-lg rounded-3">
                                <option>Selecionar atleta inscrito</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Posição *</label>
                                <input 
                                    type="number" 
                                    class="form-control form-control-lg rounded-3" 
                                    placeholder="1º, 2º..."
                                >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Pontuação / Tempo</label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-lg rounded-3"
                                >
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Observação</label>
                            <textarea class="form-control rounded-3" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button 
                                type="button" 
                                class="btn btn-link text-dark text-decoration-none"
                                @click="openModal = false"
                            >
                                Cancelar
                            </button>

                            <button class="btn btn-primary px-4 rounded-3">
                                Registrar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </main>
</x-layouts.app>