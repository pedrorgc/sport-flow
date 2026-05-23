<x-layouts.app>
    <div x-data="{ openModal: false }" @abrir-modal.window="openModal = true" class="w-100">
        
        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Resultados</h2>
                <div class="text-secondary small mt-1">{{ $resultados->count() }} resultado(s) registrado(s)</div>
            </div>

            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" onclick="abrirModalCadastro()">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Lançar Resultado</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Resultados" value="{{ $resultados->count() }}" subtitle="Cadastrados" icon="bi bi-award" color="warning" />
            </div>
        </div>

        <div class="card-premium mb-4 py-3">
            <div class="d-flex flex-wrap gap-3 align-items-center">
                <select class="form-select bg-light border-0 shadow-none" style="width:250px;">
                    <option>Todos os Eventos</option>
                    @foreach($eventos as $evento)
                        <option value="{{ $evento->id }}">{{ $evento->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0" style="width: 100px;">Posição</th>
                            <th class="py-3 border-bottom-0">Vencedor</th>
                            <th class="py-3 border-bottom-0">Evento</th>
                            <th class="py-3 border-bottom-0">Marca / Pontos</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($resultados as $resultado)
                            @php
                                $nomeVencedor = $resultado->inscricao->atleta ? $resultado->inscricao->atleta->nome : ($resultado->inscricao->time ? $resultado->inscricao->time->nome : 'N/A');
                                $iniciais = strtoupper(substr($nomeVencedor, 0, 2));
                            @endphp
                            <tr>
                                <td class="ps-4 py-3">
                                    @if($resultado->posicao == 1)
                                        <span class="badge rounded-pill bg-warning bg-opacity-25 text-dark px-3 py-2 fw-bold border border-warning border-opacity-50 d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-trophy-fill text-warning"></i> 1º
                                        </span>
                                    @elseif($resultado->posicao == 2)
                                        <span class="badge rounded-pill bg-secondary bg-opacity-25 text-dark px-3 py-2 fw-bold border border-secondary border-opacity-50 d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-medal-fill text-secondary"></i> 2º
                                        </span>
                                    @elseif($resultado->posicao == 3)
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 fw-bold border border-danger border-opacity-50 d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-medal-fill" style="color: #cd7f32;"></i> 3º
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 fw-bold border d-inline-flex align-items-center gap-1">
                                            {{ $resultado->posicao }}º
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                            {{ $iniciais }}
                                        </div>
                                        <div><div class="fw-semibold titulo-marca">{{ $nomeVencedor }}</div></div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-medium titulo-marca">{{ $resultado->evento->nome }}</div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold titulo-marca">{{ $resultado->marca_pontuacao ?? '-' }}</div>
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-sm btn-light text-primary hover-shadow" title="Editar" onclick="abrirModalEdicao({{ $resultado->id }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        <form action="{{ route('resultados.destroy', $resultado->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este resultado?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger hover-shadow" title="Excluir">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-secondary">Nenhum resultado registrado ainda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" 
            x-transition.opacity
            @click.self="openModal = false">
            
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 650px;" 
                     x-show="openModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="modalTitle">Lançar Resultado</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form id="formResultado" action="{{ route('resultados.store') }}" method="POST" class="p-4">
                        @csrf
                        <input type="hidden" name="_method" id="methodInput" value="POST">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Evento <span class="text-danger">*</span></label>
                            <select name="evento_id" id="evento_id" class="form-select bg-light" required>
                                <option value="" selected disabled>Selecionar evento...</option>
                                @foreach($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Vencedor (Atleta/Time) <span class="text-danger">*</span></label>
                            <select name="inscricao_id" id="inscricao_id" class="form-select bg-light" required disabled>
                                <option value="">Selecione um evento primeiro...</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Posição <span class="text-danger">*</span></label>
                                <input type="number" name="posicao" class="form-control bg-light" placeholder="Ex: 1" required min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Marca / Pontuação</label>
                                <input type="text" name="marca_pontuacao" class="form-control bg-light" placeholder="Ex: 15 Gols ou 02:45.00">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top mt-4">
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">Cancelar</button>
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
                
                if(dados.length === 0) {
                    selectInscricao.innerHTML = '<option value="" disabled>Nenhum participante encontrado neste evento</option>';
                    return;
                }

                dados.forEach(inscricao => {
                    let nome = inscricao.atleta ? inscricao.atleta.nome : (inscricao.time ? inscricao.time.nome : 'Desconhecido');
                    let isSelected = (inscricao.id == inscricaoSelecionada) ? 'selected' : '';
                    selectInscricao.innerHTML += `<option value="${inscricao.id}" ${isSelected}>${nome}</option>`;
                });
            })
            .catch(error => {
                console.error('Erro:', error);
                selectInscricao.innerHTML = '<option value="" disabled>Erro ao carregar</option>';
            });
    }

    document.getElementById('evento_id').addEventListener('change', function() {
        carregarInscricoes(this.value);
    });

    function abrirModalCadastro() {
        document.getElementById('modalTitle').innerText = 'Lançar Resultado';
        document.getElementById('formResultado').action = "{{ route('resultados.store') }}";
        document.getElementById('methodInput').value = 'POST';
        
        document.getElementById('formResultado').reset();
        document.getElementById('inscricao_id').innerHTML = '<option value="">Selecione um evento primeiro...</option>';
        document.getElementById('inscricao_id').disabled = true;

        window.dispatchEvent(new CustomEvent('abrir-modal'));
    }

    function abrirModalEdicao(id) {
        document.getElementById('modalTitle').innerText = 'Editar Resultado';
        document.getElementById('formResultado').action = `/resultados/${id}`;
        document.getElementById('methodInput').value = 'PUT';

        fetch(`/resultados/${id}/edit`)
            .then(response => response.json())
            .then(resultado => {
                document.getElementById('evento_id').value = resultado.evento_id;
                document.querySelector('[name="posicao"]').value = resultado.posicao;
                document.querySelector('[name="marca_pontuacao"]').value = resultado.marca_pontuacao || '';

                carregarInscricoes(resultado.evento_id, resultado.inscricao_id);

                window.dispatchEvent(new CustomEvent('abrir-modal'));
            });
    }
</script>