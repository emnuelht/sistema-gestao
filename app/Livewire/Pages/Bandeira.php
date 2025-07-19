<?php

namespace App\Livewire\Pages;

use App\Models\Bandeira as ModelsBandeira;
use App\Models\GrupoEconomico;
use Livewire\Component;

class Bandeira extends Component
{

    public $grupo;
    public $bandeiras;
    public $dataGrupo;
    public $showEdit = false;
    // protected $listeners = ['edit-item' => 'edit'];

    public function mount($grupo) {
        $this->grupo = $grupo;
        $this->atualizarBandeiras();
        $this->dataGrupo = GrupoEconomico::where('id', $this->grupo)->first();
    }

    public function render()
    {
        return view('livewire.pages.bandeira');
    }

    public function atualizarBandeiras()
    {
        $this->bandeiras = ModelsBandeira::where('grupo_economico_id', $this->grupo)->withCount('unidades')->get();
    }

    public function handleClickItem($id) {
        redirect()->route('unidade', ['grupo' => $this->grupo ,'bandeira' => $id]);
    }

    // public function edit($item) {
    //     dd($item);
    // }
}
