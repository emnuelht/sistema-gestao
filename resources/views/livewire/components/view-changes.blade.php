<div class="container-popup-changes">
    <div class="container-popup-changes--content">
        <p class="content--title">Mudanças</p>

        @if (is_null($diffs))
            <p>Carregando...</p>
        @elseif (count($diffs) === 0)
            <p>Nenhuma alteração detectada.</p>
        @else
            @if (count($diffs) === 0)
                <p>Nenhuma alteração detectada.</p>
            @else
                <div class="content--view-changes">
                    @foreach ($diffs as $key => $change)
                        @php
                            $oldValue = $change['old'] ?? null;
                            $newValue = $change['new'] ?? null;

                            $title = match($key) {
                                'nome_fantasia' => 'Nome Fantasia',
                                'razao_social' => 'Razão Social',
                                default => ucfirst(str_replace('_', ' ', $key)),
                            };

                            $type = '';
                            if (is_null($oldValue)) {
                                $type = 'add';
                            } elseif (is_null($newValue)) {
                                $type = 'delete';
                            } elseif ($oldValue != $newValue) {
                                $type = 'update';
                            }
                        @endphp

                        <div class="item item--{{ $type }}">
                            <p class="item--title">
                                @if ($type === 'add') <div class="icon add"><x-heroicon-s-plus class="w-5 h-5 text-green-600" /></div>
                                @elseif ($type === 'delete') <div class="icon delete"><x-heroicon-s-minus class="w-5 h-5 text-green-600" /></div>
                                @elseif ($type === 'update') <div class="icon update"><x-heroicon-s-arrow-path class="w-5 h-5 text-green-600" /></div>
                                @endif
                                {{ $title }}
                            </p>

                            @if ($type === 'update' || $type === 'delete')
                                <span class="old">De: {{ $oldValue }}</span>
                            @endif

                            @if ($type === 'update' || $type === 'add')
                                <span class="new">Para: {{ $newValue }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        <x-ui.button @click="
            $dispatch('close-popup');
            setTimeout(() => $dispatch('reset'), 10);
        ">Fechar</x-ui.button>
    </div>
</div>
