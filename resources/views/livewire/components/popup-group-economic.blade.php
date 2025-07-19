<div
    class="container-popup"
    x-data="{ loading: true, visible: false }"
    x-on:open-popup.window="
        visible = true;
        loading = true;
        setTimeout(() => loading = false, 1500);
    "
    x-on:close-popup.window="
        visible = false;
    "
    x-show="visible"
    x-transition
>
    <div class="container-popup--content">
        <!-- LOADING -->
        <template x-if="loading">
            <div class="text-center py-4">
                <p>Carregando...</p>
            </div>
        </template>

        <!-- FORMULÁRIO -->
        <template x-if="!loading">
            <div>
                <p class="content--title">{{ $title }}</p>
                <form class="content--form" wire:submit.prevent="{{ $methodForm == null ? 'add' : $methodForm }}">
                    @if (!empty($dataEdit))
                        @foreach ($dataEdit as $input)
                            <div class="form--input-label">
                                @if (!empty($input['hidden']))
                                    <input type="hidden" wire:model="data.{{ $input['name'] }}">
                                @else
                                    <label for="{{ $input['name'] }}">
                                        {{ $input['label'] }}
                                        @if (!empty($input['required']))
                                            <span class="obg">*</span>
                                        @endif
                                    </label>
                                    <div class="input">
                                        <input
                                            x-mask="{{ $input['name'] === 'cnpj' ? '99.999.999/9999-99' : ($input['name'] === 'cpf' ? '999.999.999-99' : '') }}"
                                            class="it-input"
                                            id="{{ $input['name'] }}"
                                            type="text"
                                            wire:model="data.{{ $input['name'] }}"
                                            placeholder="{{ $input['placeholder'] ?? '' }}"
                                            {{ !empty($input['required']) ? 'required' : '' }}
                                        >
                                    </div>
                                    @error('data.' . $input['name'])
                                        <span class="text-error s">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        @endforeach
                    @else
                        @forelse ($inputs as $input)
                            <div class="form--input-label">
                                @if (!empty($input['hidden']))
                                    <input type="hidden" wire:model="data.{{ $input['name'] }}">
                                @else
                                    <label for="{{ $input['name'] }}">
                                        {{ $input['label'] }}
                                        @if (!empty($input['required']))
                                            <span class="obg">*</span>
                                        @endif
                                    </label>
                                    <div class="input">
                                        <input
                                            x-mask="{{ $input['name'] === 'cnpj' ? '99.999.999/9999-99' : ($input['name'] === 'cpf' ? '999.999.999-99' : '') }}"
                                            class="it-input"
                                            id="{{ $input['name'] }}"
                                            type="text"
                                            wire:model="data.{{ $input['name'] }}"
                                            placeholder="{{ $input['placeholder'] ?? '' }}"
                                            {{ !empty($input['required']) ? 'required' : '' }}
                                        >
                                    </div>
                                    @error('data.' . $input['name'])
                                        <span class="text-error s">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        @empty
                            <p>Vazio</p>
                        @endforelse
                    @endif

                    <div class="form--buttons">
                        <x-ui.button class="button-add" type="submit">Enviar</x-ui.button>
                        <x-ui.button
                            x-on:click="$dispatch('close-popup');" class="button-close"
                            type="button">
                            Fechar
                        </x-ui.button>
                    </div>
                </form>
            </div>
        </template>
    </div>
</div>
