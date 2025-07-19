<div class="auditorias item-content">
    <div class="content-directors">
        <x-heroicon-o-home class="w-5 h-5 text-green-600 f" />
        <a href="{{ route('grupos') }}"><span>Grupos Econômicos</span></a>
        <div class="icon"><x-heroicon-o-chevron-right class="w-5 h-5 text-green-600" /></div>
        <span class="active"> Auditorias </span>
    </div>

    <h1 class="title">Auditorias</h1>
    <p class="text">Acompanhe as alterações realizadas no sistema, incluindo mudanças em registros, responsáveis e datas das ações.</p>

    <div class="item-content--profile-options">
        <div class="profile-options--content">
            <a href="{{ route('logout') }}">Sair da Conta</a>
            <span>Auditorias</span>
            <div class="content--profile">
                <span> {{ Auth::user()->name }} </span>
                <x-heroicon-s-user class="w-5 h-5 text-green-600" />
            </div>
        </div>
    </div>

    <div class="container-button-top">
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
                            'label' => 'Nome da Tabela',
                            'name' => 'tabela',
                            'placeholder' => 'Digite o nome da tabela'
                        ],
                        [
                            'label' => 'Id do Registro',
                            'name' => 'registro_id',
                            'placeholder' => 'Digite o id do registro'
                        ],
                        [
                            'label' => 'Ação Realizada',
                            'name' => 'acao',
                            'placeholder' => 'Ex: created, updated, deleted'
                        ],
                        [
                            'label' => 'Modificado por',
                            'name' => 'user_id',
                            'placeholder' => 'Nome do usuário'
                        ],
                        [
                            'label' => 'Modificado em',
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
        x-on:open-popup.window="open = true"
        x-on:close-popup.window="open = false"
        @keydown.escape.window="open = false"
    >
        <div x-show="open" x-cloak class="popup-overlay">
            <livewire:components.view-changes
                wire:key="popup-changes"
            />
        </div>
    </div>

    <div class="container-table">
        <table>
            <thead>
                <tr>
                    <th>TABELA</th>
                    <th>ID REGISTRADO</th>
                    <th>AÇÃO</th>
                    <th>MODIFICADO POR</th>
                    <th>MODIFICADO EM</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($auditorias as $auditoria)
                    <tr>
                        <td> {{ $auditoria->tabela }} </td>
                        <td> {{ $auditoria->registro_id }} </td>
                        <td> {{ $auditoria->acao }} </td>
                        <td> {{ $auditoria->user->name }} </td>
                        <td> {{ $auditoria->updated_at != NULL ? $auditoria->updated_at->format('d/m/Y H:i') : '##/##/## ##:##' }} </td>
                        <td>
                            <span
                                class="btn editar"
                                @click="
                                    $dispatch('open-popup');
                                    setTimeout(() => $dispatch('changes',[{{ $auditoria->valores_anteriores }}, {{ $auditoria->valores_novos ?? 'null' }}]), 10);
                                ">
                                Ver Mudanças
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
