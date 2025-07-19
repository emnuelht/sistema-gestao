<div
    class="container-popup-delete"
    x-data="{ loading: true, visible: false }"
    x-on:open-popup-delete.window="
        visible = true;
        loading = true;
        setTimeout(() => loading = false, 1500);
    "
    x-on:close-popup-delete.window="
        visible = false;
    "
    x-show="visible"
    x-transition
>
    <div class="container-popup-delete--content">
        <!-- LOADING -->
        <template x-if="loading">
            <div class="text-center py-4">
                <p>Carregando...</p>
            </div>
        </template>

        <!-- FORMULÁRIO -->
        <template x-if="!loading">
            <form class="content--form-delete" wire:submit.prevent="delete">
                <p class="form-delete--title">Excluir item</p>
                <p class="form-delete--text">Essa ação vai remover o item permanentemente. <br>Deseja continuar?</p>
                <div class="form-delete--buttons">
                    <x-ui.button type="submit">
                        Deletar
                    </x-ui.button>
                    <x-ui.button x-on:click="$dispatch('close-popup-delete');" type="button">
                        Fechar
                    </x-ui.button>
                </div>
            </form>
        </template>
    </div>
</div>
