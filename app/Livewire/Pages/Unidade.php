<?php

namespace App\Livewire\Pages;

use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use App\Models\Unidade as ModelsUnidade;
use Livewire\Component;

class Unidade extends Component
{
    public $grupo;
    public $bandeira;
    public $unidades;
    public $dataGrupo;
    public $dataBandeira;

    public function mount($grupo, $bandeira) {
        $this->grupo = $grupo;
        $this->bandeira = $bandeira;
        $this->atualizarUnidades();
        $this->dataBandeira = Bandeira::where('id', $this->bandeira)->first();
        $this->dataGrupo = GrupoEconomico::where('id', $this->grupo)->first();
    }

    public function render()
    {
        return view('livewire.pages.unidade');
    }

    public function atualizarUnidades() {
        $this->unidades = ModelsUnidade::where('bandeira_id', $this->bandeira)->withCount('colaboradores')->get();
    }
}
