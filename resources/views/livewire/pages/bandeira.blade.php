<div class="bandeira item-content">
    <div class="content-directors">
        <x-heroicon-o-home class="w-5 h-5 text-green-600 f" />
        <a href="{{ route('grupos') }}"><span>Grupos Econômicos</span></a>
        <div class="icon"><x-heroicon-o-chevron-right class="w-5 h-5 text-green-600" /></div>
        <span class="active"> {{ $dataGrupo->nome }} </span>
    </div>

    <div class="item-content--profile-options">
        <div class="profile-options--content">
            <a href="{{ route('logout') }}">Sair da Conta</a>
            <div class="content--profile">
                <span> {{ Auth::user()->name }} </span>
                <x-heroicon-s-user class="w-5 h-5 text-green-600" />
            </div>
        </div>
    </div>

    <h1 class="title">Bandeiras - {{ $dataGrupo->nome }} </h1>
    <p class="text">Gerencie as bandeiras do seu grupo econômico</p>

    <div
        x-data="{ open: false }"
        x-on:open-popup.window="open = true"
        x-on:close-popup.window="open = false"
        @keydown.escape.window="open = false"
    >
        <x-ui.button @click="
            $dispatch('open-popup');
            setTimeout(() => $dispatch('reset-to-create', {
                hiddenInputs: [{ hidden: true, value: {{ $grupo }}, name: 'grupo_economico_id' }]
            }), 10);
        " class="button-add">
            <x-heroicon-s-plus class="w-5 h-5 text-green-600" />
            <span>Nova Bandeira</span>
        </x-ui-button>

        <div x-show="open" x-cloak class="popup-overlay">
            <livewire:components.popup-group-economic
                :title="'Bandeira'"
                :action="'Bandeiras'"
                :inputs="[
                    ['hidden' => true, 'value' => $grupo, 'name' => 'grupo_economico_id'],
                    [
                        'label' => 'Nome da Bandeira',
                        'name' => 'nome',
                        'required' => true,
                        'placeholder' => 'Digite o nome da bandeira'
                    ]
                ]"
                wire:key="popup-bandeira-create"
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
            @livewire('components.delete-item', ['action' => 'Bandeiras'], key('popup-delete'))
        </div>
    </div>

    @if (count($bandeiras) > 0)
        <div class="container-items">
            @foreach ($bandeiras as $bandeira)
                @livewire('components.box-item',
                    [
                        'iconHeader' => 1,
                        'iconBody' => 2,
                        'id' => $bandeira->id,
                        'nome' => $bandeira->nome,
                        'count' => $bandeira->unidades_count,
                        'countText' => "Unidade",
                        'updated_at' => $bandeira->updated_at,
                        'url' => route('unidade', [$grupo, $bandeira->id])
                    ],
                    key($bandeira->id)
                )
            @endforeach
        </div>
    @else
        <div class="content-empty">
            <x-heroicon-o-flag class="w-5 h-5 text-green-600" />
            <p class="content-empty--title">Sem Bandeiras</p>
            <p class="content-empty--text">Ainda não há bandeiras cadastradas para este grupo econômico. Adicione uma nova bandeira para começar.</p>
        </div>
    @endif

</div>
