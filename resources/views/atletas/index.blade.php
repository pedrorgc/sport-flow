<x-layouts.app>
    <main class="flex-grow-1" style="min-width: 0;" x-data="{ openModal: false }" @open-modal.window="openModal = true">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Atletas</h2>

            <button type="button" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm"
                onclick="abrirNovoCadastro()">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Novo Atleta</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Atletas" value="{{ $atletas->count() ?? 0 }}" subtitle="Cadastrados"
                    icon="bi bi-people" color="primary" />
            </div>
        </div>

        @if (session('success'))
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">

                <div id="toastSuccess" class="toast align-items-center text-bg-success border-0 show" role="alert"
                    style="min-width: 420px; font-size: 16px; border-radius: 12px;">

                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>

                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast">
                        </button>
                    </div>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastSuccess');

                    if (toast) {
                        toast.classList.remove('show');
                    }
                }, 5000);
            </script>
        @endif

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

        <div class="card-premium mb-4 py-3 px-4">
            <form method="GET" action="{{ route('atletas.index') }}"
                class="d-flex flex-wrap gap-3 align-items-center">

                <div class="flex-grow-1" style="min-width:220px;">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                class="bi bi-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control bg-light border-start-0 ps-0"
                            placeholder="Buscar por nome ou documento...">
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

                @if (request()->anyFilled(['search', 'modalidade_id', 'categoria']))
                    <a href="{{ route('atletas.index') }}"
                        class="btn btn-light text-danger d-flex align-items-center gap-2 shadow-sm"
                        title="Limpar Filtros">
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
                            <th class="ps-4 py-3 border-bottom-0">Nome</th>
                            <th class="py-3 border-bottom-0">Modalidade</th>
                            <th class="py-3 border-bottom-0">Categoria</th>
                            <th class="py-3 border-bottom-0">Nasc.</th>
                            <th class="py-3 border-bottom-0">Contato</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="border-top-0">
                        @forelse ($atletas as $atleta)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="alert alert-primary border-0 m-0 rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                            style="width: 40px; height: 40px; padding: 0;">
                                            {{ substr($atleta->nome, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold titulo-marca">{{ $atleta->nome }}</div>
                                            <div class="text-secondary small">Doc:
                                                {{ $atleta->cpf_rg ?? 'Não informado' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 text-secondary">{{ $atleta->modalidade->nome ?? 'Não informado' }}</td>
                                <td class="py-3">
                                    <span
                                        class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-medium border border-success border-opacity-25">
                                        {{ $atleta->categoria }}
                                    </span>
                                </td>
                                <td class="py-3 text-secondary">
                                    {{ \Carbon\Carbon::parse($atleta->data_nascimento)->format('d/m/Y') }}
                                </td>
                                <td class="py-3 text-secondary">{{ $atleta->contato ?? 'Sem contato' }}</td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex gap-2 justify-content-end">

                                        <button type="button" class="btn btn-sm btn-light text-primary hover-shadow"
                                            title="Editar" onclick="abrirEdicao({{ $atleta->id }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn btn-sm btn-light text-danger hover-shadow" title="Excluir"
                                            @click="$dispatch('confirmar-exclusao', {
                                                action: '/atletas/{{ $atleta->id }}',
                                                mensagem: 'Tem certeza que deseja excluir o atleta {{ $atleta->nome }}?'
                                            })">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">
                                    Nenhum atleta cadastrado ainda. Clique em "Novo Atleta" para começar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="openModal = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 700px;" x-show="openModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="tituloModal">Novo Atleta</h4>
                        <button type="button"
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form id="formAtleta" action="{{ route('atletas.store') }}" method="POST" class="p-4">
                        @csrf

                        <input type="hidden" name="_method" id="metodoForm" value="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome Completo <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nome" id="inputNome" class="form-control bg-light"
                                placeholder="Digite seu nome completo" required>

                            <div id="erroNome" class="text-danger small mt-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Documento (CPF/RG)</label>
                                <input type="text" name="cpf_rg" id="inputCpf" class="form-control bg-light"
                                    placeholder="Digite CPF ou RG">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Data de Nascimento <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="data_nascimento" id="inputDataNasc"
                                    class="form-control bg-light" max="{{ now()->subYears(10)->format('Y-m-d') }}"
                                    required>

                                <div id="erroData" class="text-danger small mt-1"></div>
                            </div>
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

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Contato
                                (Telefone/E-mail)</label>
                            <input type="text" name="contato" id="inputContato" class="form-control bg-light"
                                placeholder="(33) 99999-9999 ou email@exemplo.com">
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="openModal = false">Cancelar</button>
                            <button type="submit" id="btnSalvar" class="btn btn-premium px-4">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        function abrirNovoCadastro() {
            const formAtleta = document.getElementById('formAtleta');
            const metodoForm = document.getElementById('metodoForm');
            const tituloModal = document.getElementById('tituloModal');
            const btnSalvar = document.getElementById('btnSalvar');

            formAtleta.reset();

            formAtleta.action = "{{ route('atletas.store') }}";
            metodoForm.value = "POST";
            tituloModal.innerText = "Novo Atleta";
            btnSalvar.innerText = "Salvar";

            window.dispatchEvent(new CustomEvent('open-modal'));
        }

        function abrirEdicao(id) {
            const tituloModal = document.getElementById('tituloModal');

            tituloModal.innerText = "Carregando...";
            window.dispatchEvent(new CustomEvent('open-modal'));

            fetch(`/atletas/${id}/edit`)
                .then(response => {
                    if (!response.ok) throw new Error('Erro na requisição');
                    return response.json();
                })
                .then(dados => {
                    const formAtleta = document.getElementById('formAtleta');
                    const metodoForm = document.getElementById('metodoForm');
                    const btnSalvar = document.getElementById('btnSalvar');

                    document.getElementById('inputNome').value = dados.nome;
                    document.getElementById('inputCpf').value = dados.cpf_rg || '';

                    let dataNasc = dados.data_nascimento;
                    if (dataNasc && dataNasc.includes('T')) dataNasc = dataNasc.split('T')[0];
                    if (dataNasc && dataNasc.includes(' ')) dataNasc = dataNasc.split(' ')[0];
                    document.getElementById('inputDataNasc').value = dataNasc;

                    document.getElementById('inputModalidade').value = dados.modalidade_id;
                    document.getElementById('inputCategoria').value = dados.categoria;
                    document.getElementById('inputContato').value = dados.contato || '';

                    formAtleta.action = `/atletas/${id}`;
                    metodoForm.value = "PUT";
                    tituloModal.innerText = "Editar Atleta";
                    btnSalvar.innerText = "Atualizar";
                })
                .catch(error => {
                    console.error("Erro ao carregar dados:", error);
                    alert("Erro ao carregar os dados do atleta.");
                });
        }

        function configurarMascaraCpf() {
            const inputCpf = document.getElementById('inputCpf');
            if (!inputCpf) return;

            inputCpf.addEventListener('input', function() {
                if (/[a-zA-Z]/.test(this.value)) return;

                let valor = this.value.replace(/\D/g, '');
                valor = valor.replace(/^(\d{3})(\d)/, '$1.$2');
                valor = valor.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                valor = valor.replace(/\.(\d{3})(\d)/, '.$1-$2');

                this.value = valor.substring(0, 14);
            });
        }

        function configurarMascaraContato() {
            const inputContato = document.getElementById('inputContato');
            if (!inputContato) return;

            inputContato.addEventListener('input', function() {
                if (/[a-zA-Z@]/.test(this.value)) return;

                let valor = this.value.replace(/\D/g, '');

                if (valor.length <= 10) {
                    valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
                    valor = valor.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    valor = valor.replace(/^(\d{2})(\d)/, '($1) $2');
                    valor = valor.replace(/(\d{5})(\d)/, '$1-$2');
                }

                this.value = valor.substring(0, 15);
            });
        }

        function configurarValidacaoNomeAtleta() {
            const inputNome = document.getElementById('inputNome');
            if (!inputNome) return;

            inputNome.addEventListener('blur', function() {
                const erro = document.getElementById('erroNome');

                if (this.value.trim() === '') {
                    erro.textContent = 'O nome é obrigatório.';
                    this.classList.add('is-invalid');
                } else {
                    erro.textContent = '';
                    this.classList.remove('is-invalid');
                }
            });
        }

        document.addEventListener('turbo:load', configurarMascaraCpf);
        document.addEventListener('turbo:load', configurarMascaraContato);
        document.addEventListener('turbo:load', configurarValidacaoNomeAtleta);
    </script>
</x-layouts.app>
