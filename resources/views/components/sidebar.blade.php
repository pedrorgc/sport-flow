<div x-data="{ open: false }">
    <button class="btn shadow-sm d-md-none position-fixed top-0 start-0 m-3 z-3 rounded-3"
        style="background-color: var(--bg-cards);" @click="open = true">
        <i class="bi bi-list fs-4 text-primary"></i>
    </button>

    <aside class="sidebar-premium d-none d-md-flex flex-column position-sticky top-0" style="width: 250px; height: 100vh;">

        <div class="p-4 text-center mt-2">
            <img :src="theme === 'dark' ? '{{ asset('images/SportFlow_Logo_Branca.png') }}' :
                '{{ asset('images/SportFlow_Logo_Preta.png') }}'"
                alt="Logo SportFlow" class="img-fluid" style="max-height: 80px; transition: all 0.3s ease;">
        </div>

        <div class="p-2 mt-0">
            <x-sidebar-item icon="bi bi-grid" label="Dashboard" href="/dashboard" :active="request()->is('dashboard')" />
            <x-sidebar-item icon="bi bi-person" label="Atletas" href="/atletas" :active="request()->is('atletas')" />
            <x-sidebar-item icon="bi bi-people" label="Times" href="/times" :active="request()->is('times')" />
            <x-sidebar-item icon="bi bi-trophy" label="Eventos" href="/eventos" :active="request()->is('eventos')" />
            <x-sidebar-item icon="bi bi-journal-check" label="Inscrições" href="/inscricoes" :active="request()->is('inscricoes')" />
            <x-sidebar-item icon="bi bi-award" label="Resultados" href="/resultados" :active="request()->is('resultados')" />
            <x-sidebar-item icon="bi bi-geo-alt" label="Espaços" href="/espacos" :active="request()->is('espacos')" />
            <x-sidebar-item icon="bi bi-calendar-check" label="Reservas" href="/reservas" :active="request()->is('reservas')" />
            @can('administrar')
                <x-sidebar-item icon="bi bi-person-gear" label="Usuários" href="/usuarios" :active="request()->is('usuarios')" />
            @endcan
        </div>

        <div class="p-2 mt-auto border-top">
            <button @click="theme = (theme === 'light' ? 'dark' : 'light')"
                class="btn w-100 text-start d-flex align-items-center gap-3 px-3 py-2 rounded-3 mb-2 item-hover"
                style="color: var(--cor-texto-corpo);">
                <i class="bi" :class="theme === 'light' ? 'bi-moon-stars' : 'bi-sun'"
                    style="font-size: 1.15rem; width: 20px; text-align: center;"></i>
                <span style="font-weight: 500; font-size: 0.95rem;"
                    x-text="theme === 'light' ? 'Modo Escuro' : 'Modo Claro'"></span>
            </button>

            <x-sidebar-item icon="bi bi-person-circle" label="Meu Perfil" href="/perfil" :active="request()->is('perfil')" />

            <form method="POST" action="/logout" class="mt-1">
                @csrf
                <button type="submit"
                    class="btn btn-light w-100 text-start text-danger hover-shadow d-flex align-items-center gap-3 px-3 py-2 rounded-3">
                    <i class="bi bi-box-arrow-right" style="font-size: 1.15rem; width: 20px; text-align: center;"></i>
                    <span style="font-weight: 500; font-size: 0.95rem;">Sair</span>
                </button>
            </form>
        </div>
    </aside>

    <div x-show="open" x-transition.opacity class="position-fixed top-0 start-0 w-100 h-100 d-md-none"
        style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 1040;" @click="open = false">
    </div>

    <aside class="position-fixed top-0 start-0 h-100 d-md-none sidebar-premium d-flex flex-column"
        :class="open ? 'translate-menu-open' : 'translate-menu-closed'"
        style="width: 280px; z-index: 1050; transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);">

        <div class="p-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <img :src="theme === 'dark' ? '{{ asset('images/SportFlow_Logo_Branca.png') }}' :
                    '{{ asset('images/SportFlow_Logo_Preta.png') }}'"
                    alt="Logo SportFlow" class="img-fluid" style="max-height: 80px; transition: all 0.3s ease;">

                <button class="btn btn-light rounded-circle p-2" @click="open = false"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        <div class="p-3">
            <x-sidebar-item icon="bi bi-grid" label="Dashboard" href="/dashboard" :active="request()->is('dashboard')" />
            <x-sidebar-item icon="bi bi-people" label="Atletas" href="/atletas" :active="request()->is('atletas')" />
            <x-sidebar-item icon="bi bi-people" label="Times" href="/times" :active="request()->is('times')" />
            <x-sidebar-item icon="bi bi-trophy" label="Eventos" href="/eventos" :active="request()->is('eventos')" />
            <x-sidebar-item icon="bi bi-journal-check" label="Inscrições" href="/inscricoes" :active="request()->is('inscricoes')" />
            <x-sidebar-item icon="bi bi-award" label="Resultados" href="/resultados" :active="request()->is('resultados')" />
            <x-sidebar-item icon="bi bi-geo-alt" label="Espaços" href="/espacos" :active="request()->is('espacos')" />
            <x-sidebar-item icon="bi bi-calendar-check" label="Reservas" href="/reservas" :active="request()->is('reservas')" />
            @can('administrar')
                <x-sidebar-item icon="bi bi-person-gear" label="Usuários" href="/usuarios" :active="request()->is('usuarios')" />
            @endcan
        </div>

        <div class="p-3 mt-auto border-top">
            <button @click="theme = (theme === 'light' ? 'dark' : 'light')"
                class="btn w-100 text-start d-flex align-items-center gap-3 px-3 py-2 rounded-3 mb-2 item-hover"
                style="color: var(--cor-texto-corpo);">
                <i class="bi" :class="theme === 'light' ? 'bi-moon-stars' : 'bi-sun'"
                    style="font-size: 1.15rem; width: 20px; text-align: center;"></i>
                <span style="font-weight: 500; font-size: 0.95rem;"
                    x-text="theme === 'light' ? 'Modo Escuro' : 'Modo Claro'"></span>
            </button>

            <x-sidebar-item icon="bi bi-person-circle" label="Meu Perfil" href="/perfil" :active="request()->is('perfil')" />

            <form method="POST" action="/logout" class="mt-1">
                @csrf
                <button type="submit"
                    class="btn btn-light w-100 text-start text-danger hover-shadow d-flex align-items-center gap-3 px-3 py-2 rounded-3">
                    <i class="bi bi-box-arrow-right" style="font-size: 1.15rem; width: 20px; text-align: center;"></i>
                    <span style="font-weight: 500; font-size: 0.95rem;">Sair</span>
                </button>
            </form>
        </div>
    </aside>
</div>
