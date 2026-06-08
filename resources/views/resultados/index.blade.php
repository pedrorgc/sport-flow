<x-layouts.app>
    <div x-data="{ openModal: false }" @abrir-modal.window="openModal = true" class="w-100">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Resultados</h2>
                <div class="text-secondary small mt-1">{{ $eventos->sum(fn($e) => $e->resultados->count()) }}
                    resultado(s) registrado(s)</div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Resultados" value="{{ $eventos->sum(fn($e) => $e->resultados->count()) }}"
                    subtitle="Cadastrados" icon="bi bi-award" color="warning" />
            </div>
        </div>

        <div class="card-premium mb-4 py-3 px-4">
            <form method="GET" action="{{ route('resultados.index') }}"
                class="d-flex flex-wrap gap-3 align-items-center">

                <select name="evento_id" class="form-select bg-light shadow-sm" style="width:250px;">
                    <option value="">Todos os Eventos</option>
                    @foreach ($eventos as $ev)
                        <option value="{{ $ev->id }}" {{ request('evento_id') == $ev->id ? 'selected' : '' }}>
                            {{ $ev->nome }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>

                @if (request()->filled('evento_id'))
                    <a href="{{ route('resultados.index') }}"
                        class="btn btn-light text-danger d-flex align-items-center gap-2 shadow-sm"
                        title="Limpar Filtro">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        @forelse ($eventos as $evento)
            <div class="card-premium mb-4" x-data="{ openPodio: false }">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center p-4">
                    <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-trophy fs-4"></i>
                        </div>
                        <div>
                            <h5 class="titulo-marca mb-1">{{ $evento->nome }}</h5>
                            <div class="text-secondary small">
                                <i class="bi bi-tag-fill me-1"></i>
                                {{ $evento->modalidade?->nome ?? 'Modalidade indefinida' }}
                                <span class="mx-2">•</span>
                                {{ $evento->resultados->count() }} resultado(s) lançado(s)
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-light d-flex align-items-center gap-2" @click="openPodio = !openPodio">
                            <i class="bi" :class="openPodio ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                            <span x-text="openPodio ? 'Ocultar Pódio' : 'Ver Pódio'"></span>
                        </button>

                        <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm"
                            onclick="abrirModalCadastro({{ $evento->id }}, '{{ $evento->nome }}')">
                            <i class="bi bi-plus-lg"></i> Lançar
                        </button>
                    </div>
                </div>

                <div x-show="openPodio" x-transition x-cloak class="border-top bg-light bg-opacity-50">
                    @if ($evento->resultados->isEmpty())
                        <div class="text-center py-4 text-secondary small">
                            <i class="bi bi-info-circle me-1"></i> Nenhum resultado lançado para este evento ainda.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                                        <th class="ps-4 py-3 border-bottom-0" style="width: 100px;">Pos</th>
                                        <th class="py-3 border-bottom-0">Vencedor</th>
                                        <th class="py-3 border-bottom-0">Marca / Pontos</th>
                                        <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0 bg-white">
                                    @foreach ($evento->resultados as $resultado)
                                        @php
                                            $nomeVencedor = $resultado->inscricao->atleta
                                                ? $resultado->inscricao->atleta->nome
                                                : ($resultado->inscricao->time
                                                    ? $resultado->inscricao->time->nome
                                                    : 'N/A');
                                            $iniciais = strtoupper(substr($nomeVencedor, 0, 2));
                                        @endphp
                                        <tr>
                                            <td class="ps-4 py-3">
                                                @if ($resultado->posicao == 1)
                                                    <span
                                                        class="badge rounded-pill bg-warning bg-opacity-25 text-dark px-3 py-2 fw-bold border border-warning border-opacity-50"><i
                                                            class="bi bi-trophy-fill text-warning"></i> 1º</span>
                                                @elseif($resultado->posicao == 2)
                                                    <span
                                                        class="badge rounded-pill bg-secondary bg-opacity-25 text-dark px-3 py-2 fw-bold border border-secondary border-opacity-50">2º</span>
                                                @elseif($resultado->posicao == 3)
                                                    <span
                                                        class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 fw-bold border border-danger border-opacity-50">3º</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill bg-light text-dark px-3 py-2 fw-bold border">{{ $resultado->posicao }}º</span>
                                                @endif
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center fw-bold border"
                                                        style="width: 35px; height: 35px; font-size: 0.8rem;">
                                                        {{ $iniciais }}
                                                    </div>
                                                    <div class="fw-semibold titulo-marca">{{ $nomeVencedor }}</div>
                                                </div>
                                            </td>
                                            <td class="py-3 fw-medium">{{ $resultado->marca_pontuacao ?? '-' }}</td>
                                            <td class="text-end pe-4 py-3">
                                                <button type="button" class="btn btn-sm btn-light text-primary me-1"
                                                    onclick="abrirModalEdicao({{ $resultado->id }}, '{{ $evento->nome }}')">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <form action="{{ route('resultados.destroy', $resultado->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Excluir este resultado?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light text-danger"><i
                                                            class="bi bi-trash3"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-secondary">
                <i class="bi bi-calendar-x display-4 d-block mb-3 opacity-50"></i>
                Nenhum evento cadastrado no sistema ainda.
            </div>
        @endforelse

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="openModal = false">

            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 650px;" x-show="openModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="modalTitle">Lançar Resultado</h4>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form id="formResultado" action="{{ route('resultados.store') }}" method="POST"
                        class="p-4">
                        @csrf
                        <input type="hidden" name="_method" id="methodInput" value="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Evento <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="evento_nome_display" class="form-control bg-light" readonly>
                            <input type="hidden" name="evento_id" id="evento_id_hidden">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Vencedor (Atleta/Time) <span
                                    class="text-danger">*</span></label>
                            <select name="inscricao_id" id="inscricao_id" class="form-select bg-light" required
                                disabled>
                                <option value="">Selecione um evento primeiro...</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Posição <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="posicao" class="form-control bg-light"
                                    placeholder="Ex: 1" required min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Marca / Pontuação</label>
                                <input type="text" name="marca_pontuacao" class="form-control bg-light"
                                    placeholder="Ex: 15 Gols ou 02:45.00">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top mt-4">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="openModal = false">Cancelar</button>
                            <button type="submit" class="btn btn-premium px-4">Salvar Resultado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>

<script>
    function carregarInscricoes(eventoId, inscricaoSelecionada = null) {
        let selectInscricao = document.getElementById('inscricao_id');
        selectInscricao.disabled = false;
        selectInscricao.innerHTML = '<option value="">Carregando participantes...</option>';

        fetch(`/api/eventos/${eventoId}/inscricoes`)
            .then(response => {
                if (!response.ok) throw new Error('Erro na requisição');
                return response.json();
            })
            .then(dados => {
                selectInscricao.innerHTML = '<option value="" selected disabled>Selecione o vencedor...</option>';

                if (dados.length === 0) {
                    selectInscricao.innerHTML =
                        '<option value="" disabled>Nenhum participante encontrado neste evento</option>';
                    return;
                }

                dados.forEach(inscricao => {
                    let nome = inscricao.atleta ? inscricao.atleta.nome : (inscricao.time ? inscricao.time
                        .nome : 'Desconhecido');
                    let isSelected = (inscricao.id == inscricaoSelecionada) ? 'selected' : '';
                    selectInscricao.innerHTML +=
                        `<option value="${inscricao.id}" ${isSelected}>${nome}</option>`;
                });
            })
            .catch(error => {
                console.error('Erro:', error);
                selectInscricao.innerHTML = '<option value="" disabled>Erro ao carregar</option>';
            });
    }

    function abrirModalCadastro(eventoId, eventoNome) {
        document.getElementById('modalTitle').innerText = 'Lançar Resultado';
        document.getElementById('formResultado').action = "{{ route('resultados.store') }}";
        document.getElementById('methodInput').value = 'POST';
        document.getElementById('formResultado').reset();

        document.getElementById('evento_nome_display').value = eventoNome;
        document.getElementById('evento_id_hidden').value = eventoId;

        carregarInscricoes(eventoId);

        window.dispatchEvent(new CustomEvent('abrir-modal'));
    }

    function abrirModalEdicao(resultadoId, eventoNome) {
        document.getElementById('modalTitle').innerText = 'Editar Resultado';
        document.getElementById('formResultado').action = `/resultados/${resultadoId}`;
        document.getElementById('methodInput').value = 'PUT';

        fetch(`/resultados/${resultadoId}/edit`)
            .then(response => response.json())
            .then(resultado => {
                document.getElementById('evento_nome_display').value = eventoNome;
                document.getElementById('evento_id_hidden').value = resultado.evento_id;

                document.querySelector('[name="posicao"]').value = resultado.posicao;
                document.querySelector('[name="marca_pontuacao"]').value = resultado.marca_pontuacao || '';

                carregarInscricoes(resultado.evento_id, resultado.inscricao_id);

                window.dispatchEvent(new CustomEvent('abrir-modal'));
            });
    }
</script>
