<div class="container-login">
    <div class="container-login--content">
        <div class="content--content-icon">
            <div class="content-icon--icon">
                <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-600" />
            </div>
        </div>

        <p class="content--title">Bem-vindo de volta</p>
        <p class="content--text">Faça login para acessar o sistema de gestão</p>

        <form class="content--form" wire:submit.prevent="login">
            <div class="form--input-label">
                <label for="name">Nome de usuário<span class="obg">*</span></label>
                <div class="content-input">
                    <x-heroicon-o-user class="w-5 h-5 text-gray-600" />
                    <input type="text" id="name" wire:model="name" placeholder="Usuário" autocomplete="off" />
                </div>
                @error('name') <span class="text-error s">{{ $message }}</span> @enderror
            </div>
            <div class="form--input-label">
                <label for="password">Senha<span class="obg">*</span></label>
                <div class="content-input">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-gray-600" />
                    <input type="{{ $viewPassword ? 'password' : 'text' }}" id="password" wire:model="password" placeholder="Senha" />
                    @if ($viewPassword)
                        <x-heroicon-o-eye wire:click="toggleViewPassword" class="w-6 h-6 text-gray-600 icon-view" />
                    @else
                        <x-heroicon-o-eye-slash wire:click="toggleViewPassword" class="w-6 h-6 text-gray-600 icon-view" />
                    @endif
                </div>
                @error('password') <span class="text-error s">{{ $message }}</span> @enderror
            </div>
            <x-ui.button class="button-enter" type="submit">Entrar</x-ui.button>
            @error('login')
                <p class="text-error">{{ $message }}</p>
            @enderror
        </form>

    </div>
</div>
