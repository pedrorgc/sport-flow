<x-layouts.app>
    <x-sidebar />

    <main class="flex-grow-1 p-3 p-md-4" style="min-width: 0;" x-data="{ openModal: false }">
        <div class="d-flex d-md-none justify-content-between align-items-center mb-4 ps-5">
            <h2 class="fw-bold mb-0">Eventos</h2>

            <button type="button" class="btn btn-primary px-3 py-2 rounded-3" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                Novo Evento
            </button>
        </div>

        <div class="d-none d-md-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Eventos</h2>

            <button type="button" class="btn btn-primary d-flex align-items-center gap-2" @click="openModal = true">
                <i class="bi bi-plus"></i>
                Novo Evento
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Eventos" :value="count($eventos)" subtitle="Cadastrados" icon="bi bi-trophy" />
            </div>
        </div>

        @if (count($eventos) === 0)
            <div class="bg-white rounded-4 shadow-sm p-5 text-center text-secondary">
                <p class="mb-0 fs-5">Nenhum evento cadastrado</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($eventos as $evento)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="fw-bold mb-0">{{ $evento['nome'] }}</h5>

                                <span class="badge rounded-pill text-bg-warning px-3 py-2">
                                    {{ $evento['status'] }}
                                </span>
                            </div>

                            <p class="mb-2 text-secondary">
                                <i class="bi bi-trophy me-2 text-primary"></i>
                                {{ $evento['modalidade'] }}
                            </p>

                            <p class="mb-2 text-secondary">
                                <i class="bi bi-calendar-event me-2 text-primary"></i>
                                {{ \Carbon\Carbon::parse($evento['data'])->format('d/m/Y') }}
                            </p>

                            <p class="mb-2 text-secondary">
                                <i class="bi bi-geo-alt me-2 text-primary"></i>
                                {{ $evento['local'] }}
                            </p>

                            <p class="mb-3 text-secondary">
                                {{ $evento['descricao'] }}
                            </p>

                            <hr>

                            <div class="d-flex gap-3">
                                <a href="#" class="text-decoration-none text-secondary">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>

                                <a href="#" class="text-decoration-none text-secondary">
                                    <i class="bi bi-trash me-1"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div
            x-show="openModal"
            x-cloak
            class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(0,0,0,0.45); z-index: 2000;"
            @click.self="openModal = false"
        >
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow w-100" style="max-width: 700px;">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h3 class="fw-bold mb-0">Novo Evento</h3>

                        <button type="button" class="btn btn-sm" @click="openModal = false">
                            <i class="bi bi-x-lg fs-4"></i>
                        </button>
                    </div>

                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nome do Evento *</label>
                            <input type="text" class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Modalidade *</label>
                                <select class="form-select form-select-lg rounded-3">
                                    <option selected>Selecionar</option>
                                    <option>Futebol</option>
                                    <option>Futsal</option>
                                    <option>Basquete</option>
                                    <option>Vôlei</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select form-select-lg rounded-3">
                                    <option selected>Planejado</option>
                                    <option>Em andamento</option>
                                    <option>Finalizado</option>
                                    <option>Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Local *</label>
                                <input type="text" class="form-control form-control-lg rounded-3">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Data *</label>
                                <input type="date" class="form-control form-control-lg rounded-3">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Regulamento / Descrição</label>
                            <textarea class="form-control rounded-3" rows="5"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-link text-dark text-decoration-none"
                                @click="openModal = false">
                                Cancelar
                            </button>

                            <button type="submit" class="btn btn-primary px-4 rounded-3">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>