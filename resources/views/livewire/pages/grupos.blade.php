<div class="grupos item-content">
    <h1 class="title">Grupos Econômicos</h1>
    <p class="text">Gerencie seus grupos econômicos e suas respectivas bandeiras</p>

    <div class="item-content--profile-options">
        <div class="profile-options--content">
            <a href="{{ route('logout') }}">Sair da Conta</a>
            <a href="{{ route('auditorias') }}">Auditorias</a>
            <a href="{{ route('export') }}">Exportar Planilha</a>
            <div class="content--profile">
                <span> {{ Auth::user()->name }} </span>
                <x-heroicon-s-user class="w-5 h-5 text-green-600" />
            </div>
        </div>
    </div>

    <div
        x-data="{ open: false }"
        x-on:open-popup.window="open = true"
        x-on:close-popup.window="open = false"
        @keydown.escape.window="open = false"
    >
        <x-ui.button @click="
            $dispatch('open-popup');
            setTimeout(() => $dispatch('reset-to-create'), 10);
        " class="button-add">
            <x-heroicon-s-plus class="w-5 h-5 text-green-600" />
            <span>Novo Grupo Econômico</span>
        </x-ui.button>

        <div x-show="open" x-cloak class="popup-overlay">
            <livewire:components.popup-group-economic
                :title="'Grupo Econômico'"
                :action="'Grupos'"
                :inputs="[
                    [
                        'label' => 'Nome do Grupo',
                        'name' => 'nome',
                        'required' => true,
                        'placeholder' => 'Digite o nome do grupo econômico'
                    ]
                ]"
                wire:key="popup-economico"
            />
        </div>
    </div>

    <div
        x-data="{ open: false }"
        x-on:open-popup-delete.window="open = true"
        x-on:close-popup-delete.window="open = false"
        @keydown.escape.window="open = false"
    >
        <div x-show="open" x-cloak class="popup-overlay">
            @livewire('components.delete-item', ['action' => 'Grupos'], key('popup-delete'))
        </div>
    </div>

    @if (count($grupos) > 0)
        <div class="container-items">
            @foreach ($grupos as $grupo)
                @livewire('components.box-item',
                    [
                        'iconHeader' => 0,
                        'iconBody' => 1,
                        'id' => $grupo->id,
                        'nome' => $grupo->nome,
                        'count' => $grupo->bandeiras_count,
                        'countText' => "Bandeira",
                        'updated_at' => $grupo->updated_at,
                        'url' => route('bandeira', [$grupo->id])
                    ],
                    key($grupo->id)
                )
            @endforeach
        </div>
    @else
        <div class="content-empty">
            <x-heroicon-o-building-office class="w-5 h-5 text-green-600" />
            <p class="content-empty--title">Sem Grupos Econômicos</p>
            <p class="content-empty--text">Nenhum grupo econômico cadastrado até o momento. Comece criando um novo grupo para organizar seus dados.</p>
        </div>
    @endif

</div>
