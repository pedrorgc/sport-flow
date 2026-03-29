<div x-data="{ open: false }">
    <button
        class="btn bg-white shadow-sm d-md-none position-fixed top-0 start-0 m-3 z-3 rounded-3"
        @click="open = true">
        <i class="bi bi-list fs-4 text-primary"></i>
    </button>

    <aside class="bg-white sidebar-premium d-none d-md-flex flex-column"
           style="width: 250px; min-height: 100vh;">
        
        <div class="p-4 text-center mt-2">
            <img src="{{ asset('images/SportFlow_Logo_Preta.png') }}"
                 alt="Logo SportFlow"
                 class="img-fluid"
                 style="max-height: 80px;">
        </div>

        <div class="p-3 mt-2">
            <x-sidebar-item icon="bi bi-grid"           label="Dashboard"  href="/dashboard" :active="request()->is('dashboard')" />
            <x-sidebar-item icon="bi bi-people"         label="Atletas"    href="/atletas"   :active="request()->is('atletas')" />
            <x-sidebar-item icon="bi bi-trophy"         label="Eventos"    href="/eventos"   :active="request()->is('eventos')" />
            <x-sidebar-item icon="bi bi-journal-check"  label="Inscrições" href="/inscricoes"          :active="request()->is('inscricoes')" />
            <x-sidebar-item icon="bi bi-award"          label="Resultados" href="/resultados"          :active="request()->is('resultados')" />
            <x-sidebar-item icon="bi bi-geo-alt"        label="Espaços"    href="/espacos"          :active="request()->is('espacos')" />
        </div>
    </aside>

    <div
        x-show="open"
        x-transition.opacity
        class="position-fixed top-0 start-0 w-100 h-100 d-md-none"
        style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 1040;"
        @click="open = false">
    </div>

    <aside class="bg-white position-fixed top-0 start-0 h-100 d-md-none sidebar-premium"
           :class="open ? 'translate-menu-open' : 'translate-menu-closed'"
           style="width: 280px; z-index: 1050; transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);">

        <div class="p-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <img src="{{ asset('images/SportFlow_Logo_Preta.png') }}"
                     alt="Logo SportFlow"
                     class="img-fluid"
                     style="max-height: 50px; max-width: 170px;">

                <button class="btn btn-light rounded-circle p-2" @click="open = false" style="width: 40px; height: 40px;">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        <div class="p-3">
            <x-sidebar-item icon="bi bi-grid"           label="Dashboard"   href="/dashboard"   :active="request()->is('dashboard')" />
            <x-sidebar-item icon="bi bi-people"         label="Atletas"     href="/atletas"     :active="request()->is('atletas')" />
            <x-sidebar-item icon="bi bi-trophy"         label="Eventos"     href="#"            :active="false" />
            <x-sidebar-item icon="bi bi-journal-check"  label="Inscrições"  href="/inscricoes"            :active="request()->is('inscricoes')" />
            <x-sidebar-item icon="bi bi-award"          label="Resultados"  href="#"            :active="false" />
            <x-sidebar-item icon="bi bi-geo-alt"        label="Espaços"     href="#"            :active="false" />
        </div>
    </aside>
</div>