<div class="grupos item-content">
    <div class="content-directors">
        <x-heroicon-o-home class="w-5 h-5 text-green-600 f" />
        <a href="{{ route('grupos') }}"><span>Grupos Econômicos</span></a>
        <div class="icon"><x-heroicon-o-chevron-right class="w-5 h-5 text-green-600" /></div>
        <a href="{{ route('bandeira', [$dataGrupo->id]) }}"><span>{{ $dataGrupo->nome }}</span></a>
        <div class="icon"><x-heroicon-o-chevron-right class="w-5 h-5 text-green-600" /></div>
        <a href="{{ route('unidade', [$dataGrupo->id, $dataBandeira->id]) }}"><span>{{ $dataBandeira->nome }}</span></a>
        <div class="icon"><x-heroicon-o-chevron-right class="w-5 h-5 text-green-600" /></div>
        <span class="active"> {{ $dataUnidade->nome_fantasia }} </span>
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

    <h1 class="title">Colaboradores - {{ $dataUnidade->nome_fantasia }} </h1>
    <p class="text">Gerencie sua equipe e recursos humanos</p>

    <div class="container-buttons-top">
        <div
            x-data="{ openAdd: false }"
            x-on:open-popup.window="openAdd = true"
            x-on:close-popup.window="openAdd = false"
            @keydown.escape.window="openAdd = false"
        >
            <x-ui.button @click="
                $dispatch('open-popup');
                setTimeout(() => $dispatch('reset-to-create', {
                    hiddenInputs: [{ hidden: true, value: {{ $unidade }}, name: 'unidade_id' }]
                }), 10);
            " class="button-add">
                <x-heroicon-s-plus class="w-5 h-5 text-green-600" />
                <span>Novo Colaborador</span>
            </x-ui.button>

            <div x-show="openAdd" x-cloak class="popup-overlay">
                <livewire:components.popup-group-economic
                    :title="'Colaborador'"
                    :action="'Colaboradores'"
                    :inputs="[
                        ['hidden' => true, 'value' => $unidade, 'name' => 'unidade_id'],
                        [
                            'label' => 'Nome',
                            'name' => 'nome',
                            'required' => true,
                            'placeholder' => 'Digite o nome'
                        ],
                        [
                            'label' => 'Email',
                            'name' => 'email',
                            'required' => true,
                            'placeholder' => 'Digite o email'
                        ],
                        [
                            'label' => 'CPF',
                            'name' => 'cpf',
                            'required' => true,
                            'placeholder' => '123.456.789-01'
                        ],
                    ]"
                    wire:key="popup-colaboradores"
                />
            </div>
        </div>

        <div
            class="container-filter"
            x-data="{ openFilter: false }"
            x-on:open-popup-filter.window="openFilter = true"
            x-on:close-popup-filter.window="openFilter = false"
            @keydown.escape.window="openFilter = false"
        >
            <x-ui.button @click="
                $dispatch('open-popup-filter');
            " class="button-add">
                <span>Filtrar</span>
            </x-ui.button>

            <div x-show="openFilter" x-cloak class="popup-overlay">
                <livewire:components.popup-filter
                    :inputs="[
                        [
                            'label' => 'Nome',
                            'name' => 'nome',
                            'placeholder' => 'Digite o nome'
                        ],
                        [
                            'label' => 'Email',
                            'name' => 'email',
                            'placeholder' => 'Digite o email'
                        ],
                        [
                            'label' => 'CPF',
                            'name' => 'cpf',
                            'placeholder' => '123.456.789-01'
                        ],
                        [
                            'label' => 'Atualizado em',
                            'name' => 'updated_at',
                            'type' => 'date'
                        ],
                    ]"
                    wire:key="popup-filter"
                />
            </div>
        </div>
    </div>

    <div
        x-data="{ open: false }"
        x-on:open-popup-delete.window="open = true"
        x-on:close-popup-delete.window="open = false"
        @keydown.escape.window="open = false"
    >
        <div x-show="open" x-cloak class="popup-overlay">
            @livewire('components.delete-item', ['action' => 'Colaboradores'], key('popup-delete'))
        </div>
    </div>

    @if (isset($colaboradores) && count($colaboradores) > 0)
        <div class="container-table">
            <table>
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>EMAIL</th>
                        <th>CPF</th>
                        <th>Atualizado em</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colaboradores as $colaborador)
                        <tr>
                            <td> {{ $colaborador->nome }} </td>
                            <td> {{ $colaborador->email }} </td>
                            <td> {{ $colaborador->cpf }} </td>
                            <td> {{ $colaborador->updated_at != NULL ? $colaborador->updated_at->format('d/m/Y H:i') : '' }} </td>
                            <td>
                                <span class="btn editar" @click="
                                    $dispatch('open-popup');
                                    setTimeout(() => {
                                        $dispatch('edit-item', [{{ $colaborador->id }}]);
                                    }, 10);
                                ">Editar</span>
                            </td>
                            <td>
                                <span class="btn deletar" @click="
                                    $dispatch('open-popup-delete');
                                    setTimeout(() => {
                                        $dispatch('delete-item', [{{ $colaborador->id }}]);
                                    }, 10);
                                ">Deletar</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @elseif (request()->has('filter'))
        <div class="content-empty">
            <x-heroicon-o-users class="w-5 h-5 text-green-600" />
            <p class="content-empty--title">Nenhum resultado encontrado</p>
            <p class="content-empty--text">Não encontramos nenhum colaborador que corresponda aos critérios informados. Por favor, verifique os filtros e tente novamente.</p>
        </div>
    @else
        <div class="content-empty">
            <x-heroicon-o-users class="w-5 h-5 text-green-600" />
            <p class="content-empty--title">Sem Colaboradores</p>
            <p class="content-empty--text">Ainda não existem colaboradores cadastrados. Adicione membros para expandir sua equipe.</p>
        </div>
    @endif

</div>
