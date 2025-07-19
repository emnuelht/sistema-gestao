<?php

namespace App\Livewire\Components;

use App\Models\Auditoria;
use App\Models\Bandeira;
use App\Models\Colaborador;
use App\Models\GrupoEconomico;
use App\Models\Unidade;
use App\Rules\Cpf;
use App\Rules\Cpnj;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PopupGroupEconomic extends Component
{
    public $title;
    public $label;
    public $action;
    public $inputs = [];
    public $data = [];
    public $dataEdit = [];
    public $baseInputs = [];
    public $methodForm;

    protected $listeners = [
        'edit-item' => 'edit',
        'reset-to-create' => 'resetToCreate',
    ];

    public function mount($title = '', $action = '', $label = '', $inputs = [], $methodForm = null) {
        $this->title = $title;
        $this->label = $label;
        $this->action = $action;
        $this->inputs = $inputs;
        $this->baseInputs = $inputs;
        $this->dataEdit = [];
        $this->methodForm = $methodForm;

        $this->data = [];

        foreach ($this->inputs as $input) {
            if (!empty($input['hidden']) && isset($input['value'])) {
                $this->data[$input['name']] = $input['value'];
            } else {
                $this->data[$input['name']] = $input['value'] ?? '';
            }
        }

        $this->resetDataFromInputs($this->inputs);
    }

    private function resetDataFromInputs($inputs) {
        $this->data = [];
        foreach ($inputs as $input) {
            $this->data[$input['name']] = $input['value'] ?? '';
        }
    }

    public function render()
    {
        return view('livewire.components.popup-group-economic');
    }

    public function add() {
        $this->data['update_by_id'] = Auth::id();
        $valores = $this->data;
        $id = $valores['id'] ?? null;

        $rules = [];

        foreach ($this->data as $key => $value) {
            if ($key == 'cnpj') {
                $rules["data.$key"] = ['required', new Cpnj(), Rule::unique('unidade', 'cnpj')->ignore($this->data['id'] ?? null)];
            } else if ($key == 'cpf') {
                $rules["data.$key"] = ['required', new Cpf(), Rule::unique('colaborador', 'cpf')->ignore($this->data['id'] ?? null)];
            } else if ($key == 'email') {
                $rules["data.$key"] = [Rule::unique('colaborador', 'email')->ignore($this->data['id'] ?? null)];
            }
        }

        $messages = [
            'data.cnpj.unique' => 'O CNPJ informado já está cadastrado.',
            'data.cnpj.required' => 'O CNPJ é obrigatório.',
            'data.cpf.required' => 'O CPF é obrigatório.',
            'data.cpf.unique' => 'O CPF informado já está cadastrado.',
            'data.email.unique' => 'O Email informado já está cadastrado.',
        ];

        if (!empty($rules)) $this->validate($rules, $messages);

        switch ($this->action) {
            case 'Grupos':
                if ($id) {
                    $itemAntigo = GrupoEconomico::find($id)->makeHidden(['created_at', 'updated_at']);
                    GrupoEconomico::where('id', $id)->update($valores);
                    $this->funAuditoria('grupo_economico', $id, 'updated', json_encode($itemAntigo->toArray()), json_encode($valores));
                } else {
                    $created = GrupoEconomico::create($valores);
                    $novoArray = Arr::except($valores, ['update_by_id']);
                    $this->funAuditoria('grupo_economico', $created->id, 'created', null, json_encode($novoArray));
                }
                break;
            case 'Bandeiras':
                if ($id) {
                    $itemAntigo = Bandeira::find($id)->makeHidden(['created_at', 'updated_at']);
                    Bandeira::where('id', $id)->update($valores);
                    $this->funAuditoria('bandeira', $id, 'updated', json_encode($itemAntigo->toArray()), json_encode($valores));
                } else {
                    $created = Bandeira::create($valores);
                    $novoArray = Arr::except($valores, ['update_by_id', 'grupo_economico_id']);
                    $this->funAuditoria('bandeira', $created->id, 'created', null, json_encode($novoArray));
                }
                break;
            case 'Unidades':
                if ($id) {
                    $itemAntigo = Unidade::find($id)->makeHidden(['created_at', 'updated_at']);
                    Unidade::where('id', $id)->update($valores);
                    $this->funAuditoria('unidade', $id, 'updated', json_encode($itemAntigo->toArray()), json_encode($valores));
                } else {
                    $created = Unidade::create($valores);
                    $novoArray = Arr::except($valores, ['update_by_id', 'bandeira_id']);
                    $this->funAuditoria('unidade', $created->id, 'created', null, json_encode($novoArray));
                }
                break;
            case 'Colaboradores':
                if ($id) {
                    $itemAntigo = Colaborador::find($id)->makeHidden(['created_at', 'updated_at']);
                    Colaborador::where('id', $id)->update($valores);
                    $this->funAuditoria('colaborador', $id, 'updated', json_encode($itemAntigo->toArray()), json_encode($valores));
                } else {
                    $created = Colaborador::create($valores);
                    $novoArray = Arr::except($valores, ['update_by_id', 'unidade_id']);
                    $this->funAuditoria('colaborador', $created->id, 'created', null, json_encode($novoArray));
                }
                break;
            default:
                dd([$this->action, $valores]);
        }

        $this->dispatch('close-popup');
        return redirect(request()->header('Referer'));
    }

    private function funAuditoria($nameTable, $id, $action, $valoresAnterior, $valoresNovos) {
        Auditoria::create([
            'tabela' => $nameTable,
            'registro_id' => $id,
            'acao' => $action,
            'valores_anteriores' => $valoresAnterior,
            'valores_novos' => $valoresNovos,
            'user_id' => Auth::id(),
        ]);
    }

    public function resetToCreate($hiddenInputs = []) {
        $this->inputs = array_merge(
            $hiddenInputs,
            array_filter($this->baseInputs, fn($input) => empty($input['hidden']) || $input['name'] === 'nome') // ajustável
        );

        $this->resetDataFromInputs($this->inputs);

        $this->data = [];

        foreach ($this->inputs as $input) {
            if (!empty($input['hidden']) && isset($input['value'])) {
                $this->data[$input['name']] = $input['value'];
            } else {
                $this->data[$input['name']] = $input['value'] ?? '';
            }
        }

        $this->dataEdit = [];
    }

    public function edit($itemId) {
        if ($itemId == null) {
            $this->resetToCreate();
            return;
        }

        $item = false;
        switch($this->action) {
            case 'Grupos':
                $item = GrupoEconomico::find($itemId);
                break;
            case 'Bandeiras':
                $item = Bandeira::find($itemId);
                break;
            case 'Unidades':
                $item = Unidade::find($itemId);
                break;
            case 'Colaboradores':
                $item = Colaborador::find($itemId);
                break;
            default:
                dd($item);
        }

        if (!$item) {
            $this->resetToCreate();
            return;
        }

        $this->data = ["id" => $item->id];
        $this->dataEdit = [
            ['hidden' => true, 'value' => $item->id, 'name' => 'id']
        ];

        foreach ($this->inputs as $input) {
            $name = $input['name'];

            if (isset($item->$name)) {
                $input['value'] = $item->$name;
                $this->data[$name] = $item->$name;
            }

            $this->dataEdit[] = $input;
        }
        // dd($this->data);
    }

}
