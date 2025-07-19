<div class="container-items--item" wire:key="grupo-{{ $id }}">
    <a href="{{ $url }}" class="item--click"></a>
    <div class="item--header">
        <div class="header--icon-text">
            <div class="icon-text--icon">
                @switch($iconHeader)
                    @case(0)
                        <x-heroicon-o-building-office class="w-5 h-5 text-blue-600" />
                        @break
                    @case(1)
                        <x-heroicon-o-flag class="w-5 h-5 text-blue-600" />
                        @break
                    @case(2)
                        <x-heroicon-o-building-storefront class="w-5 h-5 text-blue-600" />
                        @break
                    @default
                        <x-heroicon-o-users class="w-5 h-5 text-blue-600" />
                @endswitch
            </div>
            <p class="icon-text--text"> {{ $nome }} </p>
        </div>
        <div class="header--buttons">
            <div class="buttons--content">
                {{-- <div class="content--item edit" wire:click="$dispatch('editItem', [{{ $id }}])"> --}}
                {{-- <div class="content--item edit" wire:click="$dispatch('open-popup')"> --}}
                <div class="content--item edit" @click="
                        const id = {{ $id }};

                        $dispatch('open-popup');

                        setTimeout(() => {
                            $dispatch('edit-item', [id]);
                        }, 10);
                    ">
                    <x-heroicon-o-pencil-square class="w-5 h-5 text-blue-600" />
                </div>
                <div class="content--item delete" @click="
                        const id = {{ $id }};

                        $dispatch('open-popup-delete');

                        setTimeout(() => {
                            $dispatch('delete-item', [id]);
                        }, 10);
                    ">
                    <x-heroicon-o-trash class="w-5 h-5 text-red-600" />
                </div>
            </div>
        </div>
    </div>
    <div class="item--body">
        <div class="body--count">
            @switch($iconBody)
                @case(0)
                    <x-heroicon-o-building-office class="w-5 h-5 text-blue-600" />
                    @break
                @case(1)
                    <x-heroicon-o-flag class="w-5 h-5 text-blue-600" />
                    @break
                @case(2)
                    <x-heroicon-o-building-storefront class="w-5 h-5 text-blue-600" />
                    @break
                @default
                    <x-heroicon-o-users class="w-5 h-5 text-blue-600" />
            @endswitch
            <span>
                {{ $count == 1
                    ? $count." ".$countText
                    : $count." ".$countText."s" }}
            </span>
        </div>
        <p class="body--time"> {{ $updated_at != NULL ? $updated_at->format('d/m/Y H:i') : '' }} </p>
    </div>
</div>
