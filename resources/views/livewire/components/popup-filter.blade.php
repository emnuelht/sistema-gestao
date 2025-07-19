<div class="container-popup-filter">
    <div class="container-popup-filter--fnd" @click="$dispatch('close-popup-filter')"></div>
    <div class="container-popup-filter--content">
        <p class="content--title">Filtrar</p>
        <form class="content--form" wire:submit.prevent="filter">
            @if (count($inputs) > 0)
                @foreach ($inputs as $input)
                    <div class="form--input-label">
                        <label for="{{ $input['name'] }}">
                            {{ $input['label'] }}
                        </label>
                        <div class="input">
                            @if (isset($input['type']) && $input['type'] == 'date')
                                <input
                                    class="it-input"
                                    id="{{ $input['name'] }}"
                                    type="date"
                                    wire:model="data.{{ $input['name'] }}"
                                >
                            @else
                                <input
                                    x-mask="{{ $input['name'] === 'cnpj' ? '99.999.999/9999-99' : ($input['name'] === 'cpf' ? '999.999.999-99' : '') }}"
                                    class="it-input"
                                    id="{{ $input['name'] }}"
                                    type="text"
                                    wire:model="data.{{ $input['name'] }}"
                                    placeholder="{{ $input['placeholder'] ?? '' }}"
                                >
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p>Carregando...</p>
            @endif
            <div class="form--buttons">
                <x-ui.button class="button-add" type="submit">
                    Filtrar
                </x-ui.button>
                <x-ui.button type="button" @click="
                    $dispatch('close-popup-filter');
                    setTimeout(() => $dispatch('reset-form'), 10);
                ">
                    Restaurar
                </x-ui.button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('change-url', (filtro) => {
                const params = new URLSearchParams(window.location.search);
                params.set('filter', btoa(JSON.stringify(filtro)));

                const novaUrl = `${window.location.pathname}?${params.toString()}`;
                history.pushState({}, '', novaUrl);

                location.reload();
            });
            Livewire.on('change-reset-url', () => {
                const params = new URLSearchParams(window.location.search);
                params.delete('filter');

                const novaUrl = `${window.location.pathname}` + (params.toString() ? `?${params.toString()}` : '');
                history.pushState({}, '', novaUrl);

                location.reload();
            });
        });
    </script>
</div>
