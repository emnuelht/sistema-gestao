<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public $name;
    public $password;
    public $viewPassword = true;

    public function mount()
    {
        if (Auth::check()) {
            redirect()->route('grupos');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function login()
    {
        $this->validate(
            [
                'name' => 'required',
                'password' => 'required|min:3',
            ],
            [
                'name.required' => 'O campo usuário é obrigatório.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A senha deve ter no mínimo 3 caracteres.',
            ]
        );

        $user = User::where('name', $this->name)->first();

        if (!$user || !Hash::check($this->password, $user->password)) {
            $this->addError('login', 'Usuário ou senha inválidos.');
            return;
        }

        Auth::login($user);

        return redirect()->route('home');
    }

    public function toggleViewPassword() {
        $this->viewPassword = !$this->viewPassword;
    }
}
