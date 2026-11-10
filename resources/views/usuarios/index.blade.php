<x-layouts.app>
    @php
        $coresPapel = ['admin' => 'danger', 'gestor' => 'primary', 'monitor' => 'success'];
        $erroNoCadastro = $errors->any() && old('_method') !== 'PUT' && old('name') !== null;
        $erroNaEdicao = $errors->any() && old('_method') === 'PUT';
    @endphp

    <main class="flex-grow-1" style="min-width: 0;"
        x-data='{
            modalNovo: @json($erroNoCadastro),
            modalEditar: @json($erroNaEdicao),
            usuarioEdit: {
                id: @json(old('usuario_id')),
                name: @json(old('name')),
                username: @json(old('username')),
                role: @json(old('role', 'monitor')),
                proprio: false
            },
            confirmacao: { aberta: false, acao: "", titulo: "", mensagem: "", botao: "", cor: "danger" },
            abrirEdicao(dados) {
                this.usuarioEdit = { ...dados };
                this.modalEditar = true;
            },
            confirmar(dados) {
                this.confirmacao = { ...dados, aberta: true };
            }
        }'>

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Usuários</h2>
                <div class="text-secondary small mt-1">Cadastre pessoas e controle quem pode acessar o sistema</div>
            </div>

            <button type="button" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm"
                @click="modalNovo = true">
                <i class="bi bi-person-plus"></i>
                <span class="d-none d-md-inline">Novo Usuário</span>
            </button>
        </div>

        @if (session('success'))
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div id="toastSuccessUsuario" class="toast align-items-center text-bg-success border-0 show shadow-lg"
                    role="alert" style="min-width: 320px; font-size: 16px; border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body">{{ session('success') }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastSuccessUsuario');
                    if (toast) toast.classList.remove('show');
                }, 5000);
            </script>
        @endif

        @if ($errors->any())
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div id="toastErroUsuario" class="toast align-items-center text-bg-danger border-0 show shadow-lg"
                    role="alert" style="min-width: 320px; font-size: 16px; border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-exclamation-octagon me-2"></i>{{ $errors->first() }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastErroUsuario');
                    if (toast) toast.classList.remove('show');
                }, 6000);
            </script>
        @endif

        @if (session('senha_temporaria'))
            @php $temp = session('senha_temporaria'); @endphp
            <div class="card-premium mb-4 border-start border-warning border-4" x-data="{ copiado: false }">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <div class="fw-bold text-dark mb-1">
                            <i class="bi bi-key me-2 text-warning"></i>Senha temporária de {{ $temp['usuario'] }}
                        </div>
                        <div class="text-secondary small">
                            Repasse esta senha à pessoa. Ela aparece só agora e precisará ser trocada no primeiro acesso.
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <code class="fs-5 px-3 py-2 bg-light rounded-3 user-select-all" id="senhaTemporaria">{{ $temp['senha'] }}</code>
                        <button type="button" class="btn btn-light border"
                            @click="navigator.clipboard.writeText(document.getElementById('senhaTemporaria').innerText); copiado = true; setTimeout(() => copiado = false, 2000)">
                            <i class="bi" :class="copiado ? 'bi-check2 text-success' : 'bi-clipboard'"></i>
                            <span x-text="copiado ? 'Copiada' : 'Copiar'"></span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <x-stat-card title="Usuários" value="{{ $totais['total'] }}" subtitle="Cadastrados"
                    icon="bi bi-people" color="primary" />
            </div>
            <div class="col-6 col-md-3">
                <x-stat-card title="Gestores" value="{{ $totais['gestores'] }}" subtitle="Secretaria"
                    icon="bi bi-briefcase" color="primary" />
            </div>
            <div class="col-6 col-md-3">
                <x-stat-card title="Monitores" value="{{ $totais['monitores'] }}" subtitle="Atividades"
                    icon="bi bi-person-badge" color="success" />
            </div>
            <div class="col-6 col-md-3">
                <x-stat-card title="Bloqueados" value="{{ $totais['bloqueados'] }}" subtitle="Sem acesso"
                    icon="bi bi-lock" color="danger" />
            </div>
        </div>

        <div class="card-premium mb-4 py-3 px-4">
            <form method="GET" action="{{ route('usuarios.index') }}" class="d-flex flex-wrap gap-3 align-items-center">
                <div class="flex-grow-1" style="min-width:220px;">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="busca" value="{{ request('busca') }}"
                            class="form-control bg-light border-start-0 ps-0" placeholder="Buscar por nome ou usuário...">
                    </div>
                </div>

                <select name="papel" class="form-select bg-light shadow-sm" style="width:200px;">
                    <option value="">Todos os papéis</option>
                    @foreach ($papeis as $papel)
                        <option value="{{ $papel->value }}" @selected(request('papel') === $papel->value)>
                            {{ $papel->rotulo() }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="form-select bg-light shadow-sm" style="width:180px;">
                    <option value="">Todos os status</option>
                    <option value="ativos" @selected(request('status') === 'ativos')>Ativos</option>
                    <option value="bloqueados" @selected(request('status') === 'bloqueados')>Bloqueados</option>
                </select>

                <button type="submit" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>

                @if (request()->anyFilled(['busca', 'papel', 'status']))
                    <a href="{{ route('usuarios.index') }}"
                        class="btn btn-light text-danger d-flex align-items-center gap-2 shadow-sm">
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
                            <th class="py-3 border-bottom-0">Papel</th>
                            <th class="py-3 border-bottom-0">Status</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($usuarios as $usuario)
                            @php
                                $proprio = $usuario->is(auth()->user());
                                $cor = $coresPapel[$usuario->role->value] ?? 'secondary';
                                $dadosEdicao = [
                                    'id' => $usuario->id,
                                    'name' => $usuario->name,
                                    'username' => $usuario->username,
                                    'role' => $usuario->role->value,
                                    'proprio' => $proprio,
                                ];
                            @endphp
                            <tr class="{{ $usuario->ativo ? '' : 'opacity-75' }}">
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="alert alert-{{ $cor }} border-0 m-0 rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                            style="width: 40px; height: 40px; padding: 0;">
                                            {{ mb_substr($usuario->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold titulo-marca">
                                                {{ $usuario->name }}
                                                @if ($proprio)
                                                    <span class="text-secondary small fw-normal">(você)</span>
                                                @endif
                                            </div>
                                            <div class="text-secondary small">{{ $usuario->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge rounded-pill bg-{{ $cor }} bg-opacity-10 text-{{ $cor }} px-3 py-2 fw-medium border border-{{ $cor }} border-opacity-25">
                                        {{ $usuario->role->rotulo() }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if ($usuario->ativo)
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-medium">
                                            <i class="bi bi-unlock me-1"></i>Ativo
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary px-3 py-2 fw-medium">
                                            <i class="bi bi-lock me-1"></i>Bloqueado
                                        </span>
                                    @endif
                                    @if ($usuario->must_change_password)
                                        <div class="small text-warning-emphasis mt-1">
                                            <i class="bi bi-hourglass-split me-1"></i>Aguardando troca de senha
                                        </div>
                                    @endif
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-sm btn-light text-primary hover-shadow"
                                            title="Editar"
                                            @click='abrirEdicao(@json($dadosEdicao))'>
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        @unless ($proprio)
                                            @php
                                                $confirmarSenha = [
                                                    'acao' => route('usuarios.senha', $usuario),
                                                    'titulo' => 'Redefinir senha',
                                                    'mensagem' => "Gerar uma nova senha temporária para {$usuario->username}? A senha atual deixa de funcionar.",
                                                    'botao' => 'Gerar nova senha',
                                                    'cor' => 'warning',
                                                ];
                                                $confirmarAcesso = $usuario->ativo
                                                    ? [
                                                        'acao' => route('usuarios.acesso', $usuario),
                                                        'titulo' => 'Bloquear acesso',
                                                        'mensagem' => "{$usuario->username} não conseguirá mais entrar no sistema e será desconectado. Os registros dele são mantidos.",
                                                        'botao' => 'Bloquear',
                                                        'cor' => 'danger',
                                                    ]
                                                    : [
                                                        'acao' => route('usuarios.acesso', $usuario),
                                                        'titulo' => 'Liberar acesso',
                                                        'mensagem' => "Permitir que {$usuario->username} volte a entrar no sistema?",
                                                        'botao' => 'Liberar',
                                                        'cor' => 'success',
                                                    ];
                                            @endphp

                                            <button type="button" class="btn btn-sm btn-light text-warning hover-shadow"
                                                title="Redefinir senha" @click='confirmar(@json($confirmarSenha))'>
                                                <i class="bi bi-key"></i>
                                            </button>

                                            <button type="button"
                                                class="btn btn-sm btn-light hover-shadow {{ $usuario->ativo ? 'text-danger' : 'text-success' }}"
                                                title="{{ $usuario->ativo ? 'Bloquear acesso' : 'Liberar acesso' }}"
                                                @click='confirmar(@json($confirmarAcesso))'>
                                                <i class="bi {{ $usuario->ativo ? 'bi-lock' : 'bi-unlock' }}"></i>
                                            </button>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-secondary">
                                    Nenhum usuário encontrado com esses filtros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal: novo usuário --}}
        <div x-show="modalNovo" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="modalNovo = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 520px;">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Novo Usuário</h4>
                        <button type="button" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="modalNovo = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('usuarios.store') }}" class="p-4" data-turbo="false">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ $erroNoCadastro ? old('name') : '' }}"
                                class="form-control bg-light @if ($erroNoCadastro) @error('name') is-invalid @enderror @endif" required maxlength="255">
                            @if ($erroNoCadastro)
                                @error('name') <div class="invalid-feedback fw-medium">{{ $message }}</div> @enderror
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome de usuário (login) <span class="text-danger">*</span></label>
                            <input type="text" name="username" value="{{ $erroNoCadastro ? old('username') : '' }}"
                                class="form-control bg-light text-uppercase @if ($erroNoCadastro) @error('username') is-invalid @enderror @endif"
                                required minlength="3" maxlength="50" placeholder="ex.: JOAO.SILVA">
                            <div class="form-text">Letras, números, ponto, hífen ou sublinhado. Sem espaços.</div>
                            @if ($erroNoCadastro)
                                @error('username') <div class="invalid-feedback fw-medium d-block">{{ $message }}</div> @enderror
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Papel <span class="text-danger">*</span></label>
                            <select name="role" class="form-select bg-light" required>
                                @foreach ($papeis as $papel)
                                    <option value="{{ $papel->value }}"
                                        @selected(($erroNoCadastro ? old('role') : 'monitor') === $papel->value)>
                                        {{ $papel->rotulo() }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <strong>Gestor:</strong> consulta e altera dados do sistema.
                                <strong>Monitor:</strong> consulta e acompanha o quadro de reservas.
                                <strong>Administrador:</strong> acesso total, inclusive a esta página.
                            </div>
                        </div>

                        <div class="alert alert-light border small mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            Uma senha temporária será gerada e exibida após salvar. A pessoa deverá trocá-la no primeiro acesso.
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="modalNovo = false">Cancelar</button>
                            <button type="submit" class="btn btn-premium px-4">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal: editar usuário --}}
        <div x-show="modalEditar" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="modalEditar = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 520px;">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Editar Usuário</h4>
                        <button type="button" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="modalEditar = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form method="POST" :action="'{{ url('usuarios') }}/' + (usuarioEdit.id || '')" class="p-4" data-turbo="false">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="usuario_id" x-model="usuarioEdit.id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome completo <span class="text-danger">*</span></label>
                            <input type="text" name="name" x-model="usuarioEdit.name"
                                class="form-control bg-light @if ($erroNaEdicao) @error('name') is-invalid @enderror @endif" required maxlength="255">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome de usuário (login) <span class="text-danger">*</span></label>
                            <input type="text" name="username" x-model="usuarioEdit.username"
                                class="form-control bg-light text-uppercase @if ($erroNaEdicao) @error('username') is-invalid @enderror @endif"
                                required minlength="3" maxlength="50">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Papel <span class="text-danger">*</span></label>
                            <select name="role" class="form-select bg-light" x-model="usuarioEdit.role" :disabled="usuarioEdit.proprio" required>
                                @foreach ($papeis as $papel)
                                    <option value="{{ $papel->value }}">{{ $papel->rotulo() }}</option>
                                @endforeach
                            </select>
                            {{-- Campo desabilitado não é enviado; manda o valor atual para não falhar na validação. --}}
                            <template x-if="usuarioEdit.proprio">
                                <input type="hidden" name="role" :value="usuarioEdit.role">
                            </template>
                            <div class="form-text" x-show="usuarioEdit.proprio">Você não pode alterar o seu próprio papel.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="modalEditar = false">Cancelar</button>
                            <button type="submit" class="btn btn-premium px-4">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal: confirmação (bloquear, liberar, redefinir senha) --}}
        <div x-show="confirmacao.aberta" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2100;" x-transition.opacity
            @click.self="confirmacao.aberta = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100 p-4 text-center" style="max-width: 420px;">
                    <h5 class="fw-bold text-dark mb-2" x-text="confirmacao.titulo"></h5>
                    <p class="text-secondary small mb-4" x-text="confirmacao.mensagem"></p>
                    <div class="d-flex gap-3 justify-content-center">
                        <button type="button" class="btn btn-light fw-medium px-4" @click="confirmacao.aberta = false">Cancelar</button>
                        <form :action="confirmacao.acao" method="POST" data-turbo="false">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn fw-medium px-4" :class="'btn-' + confirmacao.cor"
                                x-text="confirmacao.botao"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
