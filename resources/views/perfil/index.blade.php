<x-layouts.app>
    <main class="flex-grow-1 p-3 p-md-4" style="min-width: 0;">
        
        <div class="mx-auto w-100" style="max-width: 800px;">
            
            <div class="mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
                <h2 class="titulo-marca mb-1" style="font-size: 2.2rem;">Perfil do Usuário</h2>
                <div class="text-secondary small">Gerencie suas informações pessoais e configurações de segurança</div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card-premium mb-4">
                <div class="d-flex align-items-center gap-4 mb-4">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #6610f2, #8b5cf6);">
                        <i class="bi bi-person fs-1"></i>
                    </div>
                    
                    <div>
                        <h4 class="fw-bold text-dark mb-1">{{ auth()->user()->username }}</h4>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-medium">Administrador</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 d-flex align-items-center gap-3">
                            <i class="bi bi-person text-secondary fs-5"></i>
                            <div>
                                <div class="text-secondary small">ID do Usuário</div>
                                <div class="fw-semibold text-dark">{{ auth()->user()->id }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 d-flex align-items-center gap-3">
                            <i class="bi bi-lock text-secondary fs-5"></i>
                            <div>
                                <div class="text-secondary small">Nível de Acesso</div>
                                <div class="fw-semibold text-dark">Administrador</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-premium mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-person fs-5"></i>
                    <h5 class="fw-bold mb-0">Nome de Usuário</h5>
                </div>

                <form action="{{ route('perfil.username') }}" method="POST" class="d-flex gap-3">
                    @csrf
                    @method('PUT')
                    <div class="flex-grow-1">
                        <input type="text" name="username" class="form-control bg-light" value="{{ auth()->user()->username }}" required>
                        @error('username') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-secondary px-4 fw-medium text-white shadow-sm" style="background-color: #64748b; border: none;">
                        <i class="bi bi-save me-1"></i> Salvar
                    </button>
                </form>
            </div>

            <div class="card-premium">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-shield-lock fs-5"></i>
                    <h5 class="fw-bold mb-0">Segurança</h5>
                </div>

                <form action="{{ route('perfil.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4" x-data="{ show: false }">
                        <label class="form-label fw-semibold small text-secondary">Senha Atual</label>
                        <div class="input-group">
                            <input :type="show ? 'text' : 'password'" name="current_password" class="form-control bg-light border-end-0" placeholder="Digite sua senha atual" required>
                            <button class="btn bg-light border border-start-0 text-secondary" type="button" @click="show = !show">
                                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                        @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4" x-data="{ show: false }">
                        <label class="form-label fw-semibold small text-secondary">Nova Senha</label>
                        <div class="input-group">
                            <input :type="show ? 'text' : 'password'" name="password" class="form-control bg-light border-end-0" placeholder="Digite sua nova senha" required>
                            <button class="btn bg-light border border-start-0 text-secondary" type="button" @click="show = !show">
                                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                        <div class="form-text small">A senha deve ter pelo menos 6 caracteres</div>
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4" x-data="{ show: false }">
                        <label class="form-label fw-semibold small text-secondary">Confirmar Nova Senha</label>
                        <div class="input-group">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation" class="form-control bg-light border-end-0" placeholder="Confirme sua nova senha" required>
                            <button class="btn bg-light border border-start-0 text-secondary" type="button" @click="show = !show">
                                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary w-100 py-2 fw-medium text-white shadow-sm" style="background-color: #64748b; border: none;">
                        <i class="bi bi-lock me-2"></i> Alterar Senha
                    </button>
                </form>
            </div>
            
        </div>
    </main>
</x-layouts.app>