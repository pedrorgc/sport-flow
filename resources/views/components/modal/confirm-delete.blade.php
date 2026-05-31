<div x-data="{
        open: false,
        formAction: '',
        mensagem: '',
        init() {
            window.addEventListener('confirmar-exclusao', (e) => {
                this.formAction = e.detail.action;
                this.mensagem = e.detail.mensagem || 'Tem certeza que deseja excluir este item?';
                this.open = true;
            })
        }
    }"
    x-show="open"
    x-cloak
    class="position-fixed top-0 start-0 w-100 h-100"
    style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 9999;"
    x-transition.opacity>

    <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
        <div class="bg-white rounded-4 shadow-lg w-100"
            style="max-width: 420px;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">

            <div class="p-4 text-center">
                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10"
                        style="width: 56px; height: 56px;">
                        <i class="bi bi-trash3 fs-4 text-danger"></i>
                    </span>
                </div>

                <h5 class="fw-bold text-dark mb-2">Confirmar Exclusão</h5>
                <p class="text-secondary small mb-4" x-text="mensagem"></p>

                <div class="d-flex gap-3 justify-content-center">
                    <button type="button"
                        class="btn btn-light fw-medium px-4"
                        @click="open = false">
                        Cancelar
                    </button>

                    <form :action="formAction" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger fw-medium px-4">
                            Sim, excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>