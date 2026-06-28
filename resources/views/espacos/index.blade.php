<x-layouts.app>
    <div x-data='{ 
            openModal: {{ $errors->any() && old('_method') !== 'PUT' ? 'true' : 'false' }},
            openEdit: {{ $errors->any() && old('_method') === 'PUT' ? 'true' : 'false' }},
            espacoEdit: {
                id: @json(old('espaco_id')),
                nome: @json(old('nome')),
                tipo: @json(old('tipo')),
                capacidade: @json(old('capacidade')),
                endereco: @json(old('endereco'))
            },
            abrirEdicao(dados) {
                this.espacoEdit = { ...dados };
                this.openEdit = true;
            }
        }'
        class="w-100">

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

        @if (session('success'))
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div id="toastSuccessEspaco" class="toast align-items-center text-bg-success border-0 show shadow-lg"
                    role="alert" style="min-width: 420px; font-size: 16px; border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastSuccessEspaco');
                    if (toast) toast.classList.remove('show');
                }, 5000);
            </script>
        @endif

        @if ($errors->any())
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div id="toastErroEspaco" class="toast align-items-center text-bg-danger border-0 show shadow-lg"
                    role="alert" style="min-width: 420px; font-size: 16px; border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-exclamation-octagon me-2"></i> Verifique os campos destacados a vermelho.
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastErroEspaco');
                    if (toast) toast.classList.remove('show');
                }, 5000);
            </script>
        @endif

        <div class="row g-4">
            @forelse($espacos as $espaco)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card-premium h-100 border-0 overflow-hidden shadow-sm">
                        <div class="w-100 overflow-hidden" style="height: 160px;">
                            @if ($espaco->foto)
                                <img src="{{ asset('storage/' . $espaco->foto) }}" alt="Foto de {{ $espaco->nome }}"
                                    class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image fs-1"></i>
                                        <div class="small mt-1">Sem foto disponível</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 border-start border-primary border-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">{{ $espaco->nome }}</h5>
                                    <div class="badge badge-soft-primary fw-medium px-2 py-1">
                                        {{ $espaco->tipo }}</div>
                                </div>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light text-primary hover-shadow px-2 py-1"
                                        title="Editar" @click='abrirEdicao(@json($espaco))'>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button class="btn btn-sm btn-light text-danger hover-shadow px-2 py-1"
                                        title="Excluir"
                                        @click="$dispatch('confirmar-exclusao', {
                                            action: '{{ route('espacos.destroy', $espaco->id) }}',
                                            mensagem: 'Tem certeza que deseja excluir o espaço {{ addslashes($espaco->nome) }}?'
                                        })">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="text-secondary small d-flex flex-column gap-2 mt-3">
                                <div><i class="bi bi-map me-2 text-muted"></i> {{ $espaco->endereco }}</div>
                                <div><i class="bi bi-people me-2 text-muted"></i> Capacidade: {{ $espaco->capacidade }}
                                    pessoas</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-building fs-1"></i>
                        <p class="mt-3">Nenhum espaço cadastrado ainda.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="openModal = false">

            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 600px;" x-show="openModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Novo Espaço</h4>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form class="p-4" action="{{ route('espacos.store') }}" method="POST"
                        enctype="multipart/form-data" data-turbo="false">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nome" id="inputNomeEspaco"
                                class="form-control bg-light @error('nome') is-invalid @enderror"
                                value="{{ old('nome') }}" placeholder="Digite aqui o nome do espaço" required>
                            <div id="erroNomeEspaco" class="text-danger small mt-1" style="display:none;"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Tipo <span
                                        class="text-danger">*</span></label>
                                <select name="tipo" class="form-select bg-light" required>
                                    <option value="">Selecione o tipo</option>
                                    <option value="Poliesportivo/Clube"
                                        {{ old('tipo') == 'Poliesportivo/Clube' ? 'selected' : '' }}>
                                        Poliesportivo/Clube</option>
                                    <option value="Poliesportivo"
                                        {{ old('tipo') == 'Poliesportivo' ? 'selected' : '' }}>Poliesportivo</option>
                                    <option value="Quadra Coberta"
                                        {{ old('tipo') == 'Quadra Coberta' ? 'selected' : '' }}>Quadra Coberta</option>
                                    <option value="Campo Aberto"
                                        {{ old('tipo') == 'Campo Aberto' ? 'selected' : '' }}>Campo Aberto</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Capacidade <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="capacidade"
                                    class="form-control bg-light @error('capacidade') is-invalid @enderror"
                                    min="1" value="{{ old('capacidade') }}" required>
                                @error('capacidade')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Endereço / Localização <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="endereco"
                                class="form-control bg-light @error('endereco') is-invalid @enderror"
                                value="{{ old('endereco') }}" placeholder="Digite aqui o endereço" required>
                            @error('endereco')
                                <div class="invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Foto do Espaço</label>
                            <input type="file" name="foto" class="form-control bg-light" accept="image/*">
                            <div class="form-text">Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="openModal = false">Cancelar</button>
                            <button type="submit" class="btn btn-premium px-4">Salvar Espaço</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openEdit" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="openEdit = false">

            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 600px;" x-show="openEdit"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Editar Espaço</h4>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openEdit = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form :action="'{{ url('espacos') }}/' + (espacoEdit.id || '')" method="POST"
                        enctype="multipart/form-data" class="p-4" data-turbo="false">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="espaco_id" x-model="espacoEdit.id">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Nome <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nome" id="inputNomeEspacoEdit"
                                class="form-control bg-light @error('nome') is-invalid @enderror"
                                x-model="espacoEdit.nome" placeholder="Digite aqui o nome do espaço" required>
                            <div id="erroNomeEspacoEdit" class="text-danger small mt-1" style="display:none;"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Tipo <span
                                        class="text-danger">*</span></label>
                                <select name="tipo" class="form-select bg-light" x-model="espacoEdit.tipo"
                                    required>
                                    <option>Poliesportivo/Clube</option>
                                    <option>Poliesportivo</option>
                                    <option>Quadra Aberta</option>
                                    <option>Quadra Coberta</option>
                                    <option>Campo Aberto</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Capacidade <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="capacidade"
                                    class="form-control bg-light @error('capacidade') is-invalid @enderror"
                                    x-model="espacoEdit.capacidade" min="1" required>
                                @error('capacidade')
                                    <div class="invalid-feedback fw-medium">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Endereço / Localização <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="endereco"
                                class="form-control bg-light @error('endereco') is-invalid @enderror"
                                x-model="espacoEdit.endereco" placeholder="Digite aqui o endereço" required>
                            @error('endereco')
                                <div class="invalid-feedback fw-medium">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Foto do Espaço</label>
                            <input type="file" name="foto" class="form-control bg-light" accept="image/*">
                            <div class="form-text">Deixe em branco para manter a foto atual.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="openEdit = false">Cancelar</button>
                            <button type="submit" class="btn btn-premium px-4">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function configurarValidacaoNomeEspaco() {
            const pares = [
                ['inputNomeEspaco', 'erroNomeEspaco'],
                ['inputNomeEspacoEdit', 'erroNomeEspacoEdit'],
            ];

            pares.forEach(([inputId, erroId]) => {
                const input = document.getElementById(inputId);
                const erro = document.getElementById(erroId);
                if (!input || !erro) return;

                function validar() {
                    if (input.value.trim() === '') {
                        input.classList.add('is-invalid');
                        erro.style.display = 'block';
                        erro.innerText = 'O nome do espaço é obrigatório.';
                    } else {
                        input.classList.remove('is-invalid');
                        erro.style.display = 'none';
                    }
                }

                input.addEventListener('blur', validar);
                input.addEventListener('input', validar);
            });
        }

        document.addEventListener('turbo:load', configurarValidacaoNomeEspaco);
    </script>
</x-layouts.app>
