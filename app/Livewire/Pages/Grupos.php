<?php

namespace App\Livewire\Pages;

use App\Models\GrupoEconomico;
use Livewire\Component;

class Grupos extends Component
{
    public $nome;
    public $grupos;
    public $showPopup = false;

    protected $listeners = [
        'grupoAdicionado' => 'atualizarGrupos',
        'fecharPopup' => 'fecharPopup'
    ];

    public function mount() {
        $this->atualizarGrupos();
    }

    public function atualizarGrupos()
    {
        $this->grupos = GrupoEconomico::withCount('bandeiras')->get();
    }

    public function render()
    {
        return view('livewire.pages.grupos');
    }

    public function clearMessage() {
        session()->forget('message');
    }

    public function abrirPopup()
    {
        $this->showPopup = true;
    }

    public function fecharPopup()
    {
        $this->showPopup = false;
    }

}
