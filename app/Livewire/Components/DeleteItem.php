<?php

namespace App\Livewire\Components;

use App\Models\Auditoria;
use App\Models\Bandeira;
use App\Models\Colaborador;
use App\Models\GrupoEconomico;
use App\Models\Unidade;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteItem extends Component
{

    protected $listeners = ['delete-item' => 'formDelete'];
    public $id;
    public $action;

    public function mount($id = null, $action = null) {
        $this->id = $id;
        $this->action = $action;
    }

    public function render() {
        return view('livewire.components.delete-item');
    }

    public function formDelete($itemId) {
        $this->id = $itemId;
    }

    public function delete() {
        $item = null;
        $response = [];

        switch($this->action) {
            case 'Grupos':
                $item = GrupoEconomico::find($this->id)->makeHidden(['id', 'update_by_id', 'created_at', 'updated_at']);
                $response['nome'] = 'grupo_economico';
                break;
            case 'Bandeiras':
                $item = Bandeira::find($this->id)->makeHidden(['id', 'grupo_economico_id', 'update_by_id','created_at', 'updated_at']);
                $response['nome'] = 'bandeira';
                break;
            case 'Unidades':
                $item = Unidade::find($this->id)->makeHidden(['id', 'bandeira_id', 'update_by_id','created_at', 'updated_at']);
                $response['nome'] = 'unidade';
                break;
            case 'Colaboradores':
                $item = Colaborador::find($this->id)->makeHidden(['id', 'unidade_id', 'update_by_id', 'created_at', 'updated_at']);
                $response['nome'] = 'colaborador';
                break;
            default:
                dd($item);
        }

        if ($item) {
            $item->delete();
            $this->funAuditoria($response['nome'], $item->id, json_encode($item->toArray()));
            return redirect(request()->header('Referer'));
        } else {
            session()->flash('error', 'Item não encontrado.');
        }
    }

    private function funAuditoria($tableName, $id, $valoresAnteriores) {
        Auditoria::create([
            'tabela' => $tableName,
            'registro_id' => $id,
            'acao' => 'deleted',
            'valores_anteriores' => $valoresAnteriores,
            'valores_novos' => null,
            'user_id' => Auth::id(),
        ]);
    }
}
