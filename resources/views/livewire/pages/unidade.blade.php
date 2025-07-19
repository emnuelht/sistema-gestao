<div class="unidades item-content">
    <div class="content-directors">
        <x-heroicon-o-home class="w-5 h-5 text-green-600 f" />
        <a href="{{ route('grupos') }}"><span>Grupos Econômicos</span></a>
        <div class="icon"><x-heroicon-o-chevron-right class="w-5 h-5 text-green-600" /></div>
        <a href="{{ route('bandeira', [$dataGrupo->id]) }}"><span>{{ $dataGrupo->nome }}</span></a>
        <div class="icon"><x-heroicon-o-chevron-right class="w-5 h-5 text-green-600" /></div>
        <span class="active"> {{ $dataBandeira->nome }} </span>
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

    <h1 class="title">Unidades - {{ $dataBandeira->nome }} </h1>
    <p class="text">Administre suas unidades operacionais</p>

    <div
        x-data="{ open: false }"
        x-on:open-popup.window="open = true"
        x-on:close-popup.window="open = false"
        @keydown.escape.window="open = false"
    >
        <x-ui.button @click="
            $dispatch('open-popup');
            setTimeout(() => $dispatch('reset-to-create', {
                hiddenInputs: [{ hidden: true, value: {{ $bandeira }}, name: 'bandeira_id' }]
            }), 10);
        " class="button-add">
            <x-heroicon-s-plus class="w-5 h-5 text-green-600" />
            <span>Nova Unidade</span>
        </x-ui.button>

        <div x-show="open" x-cloak class="popup-overlay">
            <livewire:components.popup-group-economic
                :title="'Unidade'"
                :action="'Unidades'"
                :inputs="[
                    ['hidden' => true, 'value' => $bandeira, 'name' => 'bandeira_id'],
                    [
                        'label' => 'Nome Fantasia',
                        'name' => 'nome_fantasia',
                        'required' => true,
                        'placeholder' => 'Digite o nome fantasia'
                    ],
                    [
                        'label' => 'Razão Social',
                        'name' => 'razao_social',
                        'required' => true,
                        'placeholder' => 'Digite a razão social'
                    ],
                    [
                        'label' => 'CNPJ',
                        'name' => 'cnpj',
                        'required' => true,
                        'placeholder' => '12.345.678/0001-95'
                    ],
                ]"
                wire:key="popup-unidade"
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
            @livewire('components.delete-item', ['action' => 'Unidades'], key('popup-delete'))
        </div>
    </div>

    @if (count($unidades) > 0)
        <div class="container-items">
            @foreach ($unidades as $unidade)
                @livewire('components.box-item',
                    [
                        'iconHeader' => 2,
                        'iconBody' => 3,
                        'id' => $unidade->id,
                        'nome' => $unidade->nome_fantasia,
                        'count' => $unidade->colaboradores_count,
                        'countText' => "Colaborador",
                        'updated_at' => $unidade->updated_at,
                        'url' => route('colaborador', [$grupo, $bandeira, $unidade->id])
                    ],
                    key($unidade->id)
                )
            @endforeach
        </div>
    @else
        <div class="content-empty">
            <x-heroicon-o-building-storefront class="w-5 h-5 text-green-600" />
            <p class="content-empty--title">Sem Unidades</p>
            <p class="content-empty--text">Nenhuma unidade registrada para esta bandeira. Crie unidades para facilitar o gerenciamento.</p>
        </div>
    @endif
</div>
