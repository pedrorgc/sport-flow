<x-layouts.app>
    <main class="flex-grow-1" style="min-width: 0;" x-data="{ modal: null }" @open-modal-equipe.window="modal = 'equipe'"
        @open-modal-atletas.window="modal = 'atletas'" @open-modal-visualizar.window="modal = 'visualizar_elenco'">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Times</h2>
            <button type="button" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm"
                onclick="abrirNovaEquipe()">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Nova equipe</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Times" value="{{ $times->count() }}" subtitle="Cadastrados" icon="bi bi-shield"
                    color="primary" />
            </div>
        </div>

        <div class="card-premium mb-4 py-3 px-4">
            <form method="GET" action="{{ route('times.index') }}" class="d-flex flex-wrap gap-3 align-items-center">
                
                <div class="flex-grow-1" style="min-width:220px;">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-start-0 ps-0"
                            placeholder="Buscar por nome da equipe...">
                    </div>
                </div>

                <select name="modalidade_id" class="form-select bg-light shadow-sm" style="width:200px;">
                    <option value="">Todas modalidades</option>
                    @foreach ($modalidades as $id => $nome)
                        <option value="{{ $id }}" {{ request('modalidade_id') == $id ? 'selected' : '' }}>
                            {{ $nome }}
                        </option>
                    @endforeach
                </select>

                <select name="categoria" class="form-select bg-light shadow-sm" style="width:200px;">
                    <option value="">Todas categorias</option>
                    <option value="Sub-15" {{ request('categoria') == 'Sub-15' ? 'selected' : '' }}>Sub-15</option>
                    <option value="Sub-17" {{ request('categoria') == 'Sub-17' ? 'selected' : '' }}>Sub-17</option>
                    <option value="Sub-20" {{ request('categoria') == 'Sub-20' ? 'selected' : '' }}>Sub-20</option>
                    <option value="Adulto" {{ request('categoria') == 'Adulto' ? 'selected' : '' }}>Adulto</option>
                </select>

                <button type="submit" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>

                @if(request()->anyFilled(['search', 'modalidade_id', 'categoria']))
                    <a href="{{ route('times.index') }}" class="btn btn-light text-danger d-flex align-items-center gap-2 shadow-sm" title="Limpar Filtros">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0">Nome da equipe</th>
                            <th class="py-3 border-bottom-0">Modalidade</th>
                            <th class="py-3 border-bottom-0">Categoria</th>
                            <th class="py-3 border-bottom-0">Número de atletas</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="border-top-0">
                        @forelse ($times as $time)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($time->brasao)
                                            <img src="{{ asset('storage/' . $time->brasao) }}" width="40"
                                                height="40" class="rounded-circle object-fit-cover border"
                                                alt="Brasão do time">
                                        @else
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                                style="width: 40px; height: 40px;">
                                                {{ substr($time->nome, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold titulo-marca">{{ $time->nome }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-secondary">{{ $time->modalidade->nome ?? 'Não informado' }}</td>
                                <td class="py-3">
                                    <span
                                        class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-medium border border-success border-opacity-25">
                                        {{ $time->categoria }}
                                    </span>
                                </td>
                                <td class="py-3 text-secondary">
                                    {{ $time->atletas_count ?? 0 }} atletas
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-sm btn-light text-secondary hover-shadow"
                                            title="Visualizar Elenco" onclick="visualizarElenco({{ $time->id }})">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-light text-primary hover-shadow"
                                            title="Gerenciar Elenco" onclick="abrirElenco({{ $time->id }})">
                                            <i class="bi bi-person-plus"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-light text-primary hover-shadow"
                                            title="Editar" onclick="abrirEdicaoEquipe({{ $time->id }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn btn-sm btn-light text-danger hover-shadow" title="Excluir"
                                            @click="$dispatch('confirmar-exclusao', { 
                                                action: '/times/{{ $time->id }}',
                                                mensagem: 'Excluir a equipe {{ $time->nome }}? Os atletas não serão excluídos, apenas desvinculados.'
                                            })">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    Nenhuma equipe cadastrada ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="modal === 'equipe'" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="modal = null">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 700px;" x-show="modal === 'equipe'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="tituloModalEquipe">Nova equipe</h4>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="modal = null">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form id="formEquipe" action="{{ route('times.store') }}" method="POST"
                        enctype="multipart/form-data" class="p-4">
                        @csrf
                        <input type="hidden" name="_method" id="metodoFormEquipe" value="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome da equipe <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nome" id="inputNome" class="form-control bg-light"
                                required>
                        </div>

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
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Categoria <span
                                        class="text-danger">*</span></label>
                                <select name="categoria" id="inputCategoria" class="form-select bg-light" required>
                                    <option value="">Selecionar</option>
                                    <option value="Sub-15">Sub-15</option>
                                    <option value="Sub-17">Sub-17</option>
                                    <option value="Sub-20">Sub-20</option>
                                    <option value="Adulto">Adulto</option>
                                </select>
                            </div>
                        </div>
                        <div class = "mb-3">
                            <label class="form-label fw-semibold small text-secondary">
                                Brasão da equipe
                            </label>
                            <input type='file' name='brasao' class='form-control bg-light'
                                accept=".png, .jpg, .jpeg">
                        </div>
                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="modal = null">Cancelar</button>
                            <button type="submit" id="btnSalvarEquipe" class="btn btn-premium px-4">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="modal === 'atletas'" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;"
            @click.self="modal = null">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 750px;"
                    x-show="modal === 'atletas'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="tituloModalElenco">Adicionar atletas</h4>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="modal = null">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="p-4 border-bottom">
                        <input type="text" id="buscaAtleta" class="form-control form-control-lg bg-light"
                            placeholder="Buscar atleta na lista..." onkeyup="filtrarAtletas()">
                    </div>

                    <form id="formElenco" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="sync_atletas" value="1">

                        <div class="p-4" style="max-height: 400px; overflow-y: auto;">

                            @forelse($todosAtletas as $atleta)
                                <div class="linha-atleta d-flex align-items-center justify-content-between mb-3 p-3 rounded-3 border hover-shadow"
                                    data-nome="{{ strtolower($atleta->nome) }}">

                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                            style="width: 40px; height: 40px;">
                                            {{ substr($atleta->nome, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold"><label for="check_atleta_{{ $atleta->id }}"
                                                    style="cursor:pointer;">{{ $atleta->nome }}</label></div>
                                            <small
                                                class="text-muted">{{ $atleta->modalidade->nome ?? 'Não informado' }}
                                                •
                                                {{ $atleta->categoria }}</small>
                                        </div>
                                    </div>

                                    <input type="checkbox" name="atletas[]" value="{{ $atleta->id }}"
                                        id="check_atleta_{{ $atleta->id }}"
                                        class="check-atleta form-check-input border-secondary"
                                        style="width: 22px; height: 22px; cursor:pointer;">
                                </div>
                            @empty
                                <div class="text-center text-muted">Nenhum atleta cadastrado no sistema ainda.</div>
                            @endforelse

                        </div>

                        <div class="d-flex justify-content-end gap-3 p-4 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="modal = null">Cancelar</button>
                            <button type="submit" class="btn btn-premium px-4">Salvar Elenco</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div x-show="modal === 'visualizar_elenco'" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;"
            @click.self="modal = null" x-transition.opacity>
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 550px;"
                    x-show="modal === 'visualizar_elenco'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <div>
                            <h4 class="titulo-marca mb-0" id="tituloVisualizarTime">Elenco da Equipe</h4>
                            <small class="text-secondary" id="subtituloVisualizarTime"></small>
                        </div>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="modal = null">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="p-4" style="max-height: 450px; overflow-y: auto;">
                        <div id="listaAtletasTime" class="d-flex flex-column gap-2">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end p-4 border-top">
                        <button type="button" class="btn btn-premium px-4" @click="modal = null">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        const formEquipe = document.getElementById('formEquipe');
        const metodoFormEquipe = document.getElementById('metodoFormEquipe');
        const tituloModalEquipe = document.getElementById('tituloModalEquipe');
        const btnSalvarEquipe = document.getElementById('btnSalvarEquipe');
        const formElenco = document.getElementById('formElenco');

        // Abre modal limpo para Nova Equipe
        function abrirNovaEquipe() {
            formEquipe.reset();
            formEquipe.action = "{{ route('times.store') }}";
            metodoFormEquipe.value = "POST";
            tituloModalEquipe.innerText = "Nova Equipe";
            btnSalvarEquipe.innerText = "Salvar";
            window.dispatchEvent(new CustomEvent('open-modal-equipe'));
        }

        // Abre modal para Editar Equipe
        function abrirEdicaoEquipe(id) {
            fetch(`/times/${id}/edit`)
                .then(response => response.json())
                .then(dados => {
                    document.getElementById('inputNome').value = dados.nome;
                    document.getElementById('inputModalidade').value = dados.modalidade_id;
                    document.getElementById('inputCategoria').value = dados.categoria;

                    formEquipe.action = `/times/${id}`;
                    metodoFormEquipe.value = "PUT";
                    tituloModalEquipe.innerText = "Editar Equipe";
                    btnSalvarEquipe.innerText = "Atualizar";

                    window.dispatchEvent(new CustomEvent('open-modal-equipe'));
                });
        }

        // Abre modal para Gerenciar Elenco
        function abrirElenco(id) {
            document.querySelectorAll('.check-atleta').forEach(cb => cb.checked = false);
            document.getElementById('buscaAtleta').value = '';
            filtrarAtletas();

            fetch(`/times/${id}/edit`)
                .then(response => response.json())
                .then(dados => {
                    document.getElementById('tituloModalElenco').innerText = `Elenco: ${dados.nome}`;
                    formElenco.action = `/times/${id}`;

                    if (dados.atletas && dados.atletas.length > 0) {
                        dados.atletas.forEach(atleta => {
                            let checkbox = document.getElementById(`check_atleta_${atleta.id}`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }

                    window.dispatchEvent(new CustomEvent('open-modal-atletas'));
                });
        }

        // Função de Visualizar Elenco (Somente Leitura)
        function visualizarElenco(id) {
            const listaContainer = document.getElementById('listaAtletasTime');
            listaContainer.innerHTML =
                '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';

            fetch(`/times/${id}/edit`)
                .then(response => response.json())
                .then(dados => {
                    document.getElementById('tituloVisualizarTime').innerText = dados.nome;
                    document.getElementById('subtituloVisualizarTime').innerText =
                        `${dados.modalidade?.nome ?? 'Sem modalidade'} • ${dados.categoria}`;

                    listaContainer.innerHTML = '';

                    if (dados.atletas && dados.atletas.length > 0) {
                        dados.atletas.forEach(atleta => {
                            const iniciais = atleta.nome.substring(0, 2).toUpperCase();
                            listaContainer.innerHTML += `
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border border-opacity-10">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 0.8rem;">
                                        ${iniciais}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark">${atleta.nome}</div>
                                        <div class="text-secondary" style="font-size: 0.75rem;">Doc: ${atleta.cpf_rg || '---'}</div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        listaContainer.innerHTML =
                            '<div class="text-center py-4 text-secondary">Nenhum atleta vinculado a esta equipe.</div>';
                    }

                    window.dispatchEvent(new CustomEvent('open-modal-visualizar'));
                })
                .catch(error => {
                    console.error("Erro ao buscar elenco:", error);
                    listaContainer.innerHTML =
                        '<div class="text-center py-4 text-danger">Erro ao carregar os dados.</div>';
                });
        }

        // Filtro de busca de atletas no modal de gerenciar
        function filtrarAtletas() {
            const termo = document.getElementById('buscaAtleta').value.toLowerCase();
            document.querySelectorAll('.linha-atleta').forEach(linha => {
                const nome = linha.getAttribute('data-nome');
                linha.style.display = nome.includes(termo) ? 'flex' : 'none';
            });
        }
    </script>
</x-layouts.app>
