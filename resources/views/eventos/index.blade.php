<x-layouts.app>
    <main class="flex-grow-1" style="min-width: 0;" x-data="{ openModal: false }" @open-modal-evento.window="openModal = true">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Eventos</h2>

            <button type="button" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm"
                onclick="abrirNovoEvento()">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Novo Evento</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Eventos" value="{{ $eventos->count() }}" subtitle="Cadastrados" icon="bi bi-trophy"
                    color="primary" />
            </div>
        </div>

        @if ($errors->any())
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">

                <div id="toastErro" class="toast align-items-center text-bg-danger border-0 show" role="alert"
                    style="min-width: 420px; font-size: 16px; border-radius: 12px;">

                    <div class="d-flex">
                        <div class="toast-body">
                            @foreach ($errors->all() as $erro)
                                {{ $erro }}
                            @endforeach
                        </div>

                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast">
                        </button>
                    </div>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastErro');

                    if (toast) {
                        toast.classList.remove('show');
                    }
                }, 5000);
            </script>
        @endif

        <div class="row g-4">
            @forelse ($eventos as $evento)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-premium h-100 p-4 d-flex flex-column">

                        {{-- nome do evento --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold text-dark mb-0">{{ $evento->nome }}</h5>

                            {{-- status do evento --}}
                            @php
                                $cor = match ($evento->status) {
                                    'Concluído' => 'success',
                                    'Cancelado' => 'danger',
                                    'Em Andamento' => 'warning',
                                    default => 'secondary',
                                };
                            @endphp

                            <span
                                class="badge rounded-pill bg-{{ $cor }} bg-opacity-10 text-{{ $cor }} px-3 py-2 fw-medium border border-{{ $cor }} border-opacity-25">
                                {{ $evento->status ?? 'Agendado' }}
                            </span>
                        </div>

                        {{-- modalidade do evento --}}
                        <div class="mb-4 mt-2">
                            <div class="d-flex align-items-center mb-2 text-secondary">
                                <i class="bi bi-trophy text-primary me-2 fs-5"></i>
                                <span class="fw-medium">{{ $evento->modalidade->nome ?? 'Não informado' }}</span>
                            </div>

                            {{-- data inicio e fim formatadas --}}
                            <div class="d-flex align-items-center mb-2 text-secondary">
                                <i class="bi bi-calendar-event text-primary me-2 fs-5"></i>
                                <span>
                                    {{ \Carbon\Carbon::parse($evento->data_inicio)->format('d/m/Y H:i') }}
                                    até
                                    {{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y H:i') }}
                                </span>
                            </div>

                            {{-- periodo inscricoes --}}
                            <div class="d-flex align-items-center mb-2 text-secondary">
                                <i class="bi bi-clock text-primary me-2 fs-5"></i>
                                @php
                                    $agora = \Carbon\Carbon::now();
                                    
                                    $inicioInscricao = $evento->inscricao_inicio
                                        ? \Carbon\Carbon::parse($evento->inscricao_inicio)->startOfDay()
                                        : null;

                                    $fimInscricao = $evento->inscricao_fim
                                        ? \Carbon\Carbon::parse($evento->inscricao_fim)->endOfDay()
                                        : null;
                                        
                                    $abertas =
                                        $inicioInscricao &&
                                        $fimInscricao &&
                                        $agora->betweenIncluded($inicioInscricao, $fimInscricao);
                                @endphp

                                <span>
                                    Inscrições:
                                    {{ $inicioInscricao?->format('d/m/Y') ?? '--' }}
                                    até
                                    {{ $fimInscricao?->format('d/m/Y') ?? '--' }}
                                </span>

                                @if ($abertas)
                                    <span class="badge bg-success ms-2">
                                        Abertas
                                    </span>
                                @else
                                    <span class="badge bg-danger ms-2">
                                        Encerradas
                                    </span>
                                @endif
                            </div>

                            {{-- local do evento --}}
                            <div class="d-flex align-items-center text-secondary">
                                <i class="bi bi-geo-alt text-primary me-2 fs-5"></i>
                                <span>{{ $evento->espaco->nome ?? 'Espaço não definido' }}</span>
                            </div>
                        </div>

                        {{-- descrição do evento --}}
                        <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.6;">
                            {{ Str::limit($evento->descricao, 100, '...') }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <!-- Botão Editar chama a função JS passando o ID -->
                            <button type="button" class="btn btn-sm btn-light text-primary hover-shadow fw-medium px-3"
                                onclick="abrirEdicaoEvento({{ $evento->id }})">
                                <i class="bi bi-pencil-square me-1"></i> Editar
                            </button>

                            <!-- Formulário de Exclusão -->
                            <form action="/eventos/{{ $evento->id }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja cancelar/excluir este evento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-light text-danger hover-shadow fw-medium px-3">
                                    <i class="bi bi-trash3 me-1"></i> Excluir
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            @empty
                <div class="col-12">
                    <p class="text-center text-secondary py-5">Nenhum evento cadastrado no momento. Clique em "Novo
                        Evento" para começar.</p>
                </div>
            @endforelse

        </div>

        <!-- MODAL (CRIAR E EDITAR) -->
        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000; overflow-y: auto;"
            x-transition.opacity @click.self="openModal = false">

            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 700px;" x-show="openModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="tituloModalEvento">Novo Evento</h4>
                        <button type="button"
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('eventos.store') }}" class="p-4" id="formEvento"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="metodoFormEvento" value="POST">

                        {{-- nome --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome do Evento <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nome" id="inputNomeEvento" class="form-control bg-light"
                                required>
                        </div>

                        {{-- modalidade --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Modalidade <span
                                        class="text-danger">*</span></label>
                                <select name="modalidade_id" id="inputModalidade" class="form-select bg-light"
                                    required>
                                    <option value="" disabled selected>Selecione a Modalidade</option>
                                    @foreach ($modalidades as $id => $nome)
                                        <option value="{{ $id }}">{{ $nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- status --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Status</label>
                                <select name="status" id="inputStatus" class="form-select bg-light">
                                    <option value="Agendado">Agendado</option>
                                    <option value="Em Andamento">Em Andamento</option>
                                    <option value="Concluído">Concluído</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>

                        {{-- espaço físico --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">
                                Espaço Físico <span class="text-danger">*</span>
                            </label>

                            <select name="espaco_id" id="inputEspaco" class="form-select bg-light" required>
                                <option value="" disabled selected>Selecione onde ocorrerá o evento</option>
                                @foreach ($espacos as $id => $nome)
                                    <option value="{{ $id }}">{{ $nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- datas --}}
                        <div class="row">

                            {{-- inicio inscricoes --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">
                                    Início das Inscrições
                                </label>

                                <input type="date" name="inscricao_inicio" id="inputInscricaoInicio"
                                    class="form-control bg-light" required>
                            </div>

                            {{-- fim inscricoes --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">
                                    Fim das Inscrições
                                </label>

                                <input type="date" name="inscricao_fim" id="inputInscricaoFim"
                                    class="form-control bg-light" required>
                            </div>

                            {{-- data inicio --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">
                                    Data Início <span class="text-danger">*</span>
                                </label>

                                <input type="datetime-local" name="data_inicio" id="inputDataInicio"
                                    class="form-control bg-light" required>
                            </div>

                            {{-- data fim --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">
                                    Data Fim <span class="text-danger">*</span>
                                </label>

                                <input type="datetime-local" name="data_fim" id="inputDataFim"
                                    class="form-control bg-light" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="regulamento_path" class="form-label fw-bold">Regulamento Técnico do
                                Evento</label>
                            <input type="file" class="form-control @error('regulamento_path') is-invalid @enderror"
                                id="regulamento_path" name="regulamento_path" accept=".pdf">

                            <div class="form-text text-secondary small">
                                <i class="bi bi-info-circle"></i> Opcional. Apenas arquivos PDF (máx. 5MB).
                            </div>

                            @error('regulamento_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="openModal = false">Cancelar</button>
                            <button type="submit" id="btnSalvarEvento" class="btn btn-premium px-4">Salvar
                                Evento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <!-- SCRIPT DE GERENCIAMENTO (CREATE E EDIT) -->
    <script>
        const formEvento = document.getElementById('formEvento');
        const metodoFormEvento = document.getElementById('metodoFormEvento');
        const tituloModalEvento = document.getElementById('tituloModalEvento');
        const btnSalvarEvento = document.getElementById('btnSalvarEvento');

        function abrirNovoEvento() {
            formEvento.reset();
            formEvento.action = "{{ route('eventos.store') }}";
            metodoFormEvento.value = "POST";
            tituloModalEvento.innerText = "Novo Evento";
            btnSalvarEvento.innerText = "Salvar Evento";
            window.dispatchEvent(new CustomEvent('open-modal-evento'));
        }

        function abrirEdicaoEvento(id) {
            tituloModalEvento.innerText = "Carregando...";
            window.dispatchEvent(new CustomEvent('open-modal-evento'));

            fetch(`/eventos/${id}/edit`)
                .then(response => response.json())
                .then(dados => {
                    document.getElementById('inputNomeEvento').value = dados.nome;
                    document.getElementById('inputModalidade').value = dados.modalidade_id;
                    document.getElementById('inputStatus').value = dados.status || 'Agendado';
                    document.getElementById('inputEspaco').value = dados.espaco_id;
                    document.getElementById('inputDescricao').value = dados.descricao || '';

                    // Tratamento de Datas (Cortando qualquer HORA que venha do banco)
                    const tratarData = (dataHora) => {
                        if (!dataHora) return '';

                        return dataHora.replace(' ', 'T').slice(0, 16);
                    };

                    document.getElementById('inputDataInicio').value = tratarData(dados.data_inicio);
                    document.getElementById('inputDataFim').value = tratarData(dados.data_fim);
                    document.getElementById('inputInscricaoInicio').value = tratarData(dados.inscricao_inicio);
                    document.getElementById('inputInscricaoFim').value = tratarData(dados.inscricao_fim);


                    // Configura o formulário para Atualização (PUT)
                    formEvento.action = `/eventos/${id}`;
                    metodoFormEvento.value = "PUT";
                    tituloModalEvento.innerText = "Editar Evento";
                    btnSalvarEvento.innerText = "Atualizar Evento";
                })
                .catch(erro => console.error("Erro ao buscar dados do evento:", erro));
        }
    </script>
</x-layouts.app>
