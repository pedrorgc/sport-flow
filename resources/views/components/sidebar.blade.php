<div x-data="{ open: false }">
    <button
        class="btn d-md-none position-fixed top-0 start-0 m-3 z-3"
        @click="open = true">
        <i class="bi bi-list fs-4"></i>
    </button>

    <aside class="bg-white border-end d-none d-md-flex flex-column"
           style="width: 230px; min-height: 100vh;">
        
        <div class="p-4 border-bottom text-center">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Logo SportFlow"
                 class="img-fluid"
                 style="max-height: 80px;">
        </div>

        <div class="p-3">
            <x-sidebar-item icon="bi bi-grid"           label="Dashboard"  href="/dashboard" :active="request()->is('dashboard')" />
            <x-sidebar-item icon="bi bi-people"         label="Atletas"    href="/atletas"   :active="request()->is('atletas')" />
            <x-sidebar-item icon="bi bi-trophy"         label="Eventos"    href="#"          :active="false" />
            <x-sidebar-item icon="bi bi-journal-check"  label="Inscrições" href="#"          :active="false" />
            <x-sidebar-item icon="bi bi-award"          label="Resultados" href="#"          :active="false" />
            <x-sidebar-item icon="bi bi-geo-alt"        label="Espaços"    href="#"          :active="false" />
        </div>
    </aside>

    <div
        x-show="open"
        x-transition.opacity
        class="position-fixed top-0 start-0 w-100 h-100 d-md-none"
        style="background: rgba(0, 0, 0, 0.35); z-index: 1040;"
        @click="open = false">
    </div>

    <aside class="bg-white position-fixed top-0 start-0 h-100 d-md-none"
           :class="open ? 'translate-menu-open' : 'translate-menu-closed'"
           style="width: 280px; z-index: 1050; transition: 0.3s;">

        <div class="p-4 border-bottom">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo SportFlow"
                     class="img-fluid"
                     style="max-height: 50px; max-width: 170px;">

                <button class="btn p-0" @click="open = false">
                    <i class="bi bi-x-lg fs-5"></i>
                </button>
            </div>
        </div>

        <div class="p-3">
            <x-sidebar-item icon="bi bi-grid"           label="Dashboard"   href="/dashboard"   :active="request()->is('dashboard')" />
            <x-sidebar-item icon="bi bi-people"         label="Atletas"     href="/atletas"     :active="request()->is('atletas')" />
            <x-sidebar-item icon="bi bi-trophy"         label="Eventos"     href="#"            :active="false" />
            <x-sidebar-item icon="bi bi-journal-check"  label="Inscrições"  href="#"            :active="false" />
            <x-sidebar-item icon="bi bi-award"          label="Resultados"  href="#"            :active="false" />
            <x-sidebar-item icon="bi bi-geo-alt"        label="Espaços"     href="#"            :active="false" />
        </div>
    </aside>
</div>