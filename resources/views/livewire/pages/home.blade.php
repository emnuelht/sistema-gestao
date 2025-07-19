<div class="home">
    <h1 class="title">Sistema de Gestão</h1>
    <p class="subtitle">Gerencie seus grupos econômicos, bandeiras, unidades e colaboradores de forma integrada e eficiente.</p>

    <div class="container-grupos">
        <div class="container-grupos--content">
            <div class="content--item">
                <div class="item--icon">
                    <x-heroicon-s-building-office class="w-5 h-5 text-gray-600" />
                </div>
                <p class="item--title">Grupos Econômicos</p>
                <p class="item--text">Organize e gerencie seus grupos econômicos</p>
            </div>
            <div class="content--item">
                <div class="item--icon">
                    <x-heroicon-s-flag class="w-5 h-5 text-blue-600" />
                </div>
                <p class="item--title">Bandeiras</p>
                <p class="item--text">Controle suas bandeiras e marcas</p>
            </div>
            <div class="content--item">
                <div class="item--icon">
                    <x-heroicon-s-building-storefront class="w-5 h-5 text-green-600" />
                </div>
                <p class="item--title">Unidades</p>
                <p class="item--text">Administre suas unidades operacionais</p>
            </div>
            <div class="content--item">
                <div class="item--icon">
                    <x-heroicon-s-users class="w-5 h-5 text-purple-600" />
                </div>
                <p class="item--title">Colaboradores</p>
                <p class="item--text">Gerencie sua equipe e recursos humanos</p>
            </div>
        </div>
    </div>

    <div class="content-button">
        <a href="{{ route('grupos') }}"><x-ui.button class="button-enter">Começar Agora</x-ui.button></a>
    </div>
</div>
