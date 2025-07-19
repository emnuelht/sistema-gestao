<?php

namespace App\Livewire\Pages;

use App\Models\Bandeira;
use App\Models\Colaborador;
use App\Models\GrupoEconomico;
use App\Models\Unidade;
use Livewire\Component;

class Colaboradores extends Component
{

    public $grupo;
    public $bandeira;
    public $unidade;
    public $colaboradores;
    public $dataGrupo;
    public $dataBandeira;
    public $dataUnidade;

    public function mount($grupo, $bandeira, $unidade) {
        $this->grupo = $grupo;
        $this->bandeira = $bandeira;
        $this->unidade = $unidade;
        $this->dataUnidade = Unidade::where('id', $this->unidade)->first();
        $this->dataBandeira = Bandeira::where('id', $this->bandeira)->first();
        $this->dataGrupo = GrupoEconomico::where('id', $this->grupo)->first();

        if (request()->has('filter')) {
            $request = base64_decode(request()->get('filter'));
            $json = json_decode($request, true)[0];
            $jsonFilter = $json['filter'];
            $resultJsonFilter = json_decode($jsonFilter, true);

            $query = Colaborador::query();

            foreach ($resultJsonFilter as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            $this->colaboradores = $query->get();
        } else {
            $this->atualizarColaboradores();
        }
    }

    public function render() {
        return view('livewire.pages.colaboradores');
    }

    public function atualizarColaboradores() {
        $this->colaboradores = Colaborador::where('unidade_id', $this->unidade)->get();
    }
}
