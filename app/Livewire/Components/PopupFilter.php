<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;

class PopupFilter extends Component
{

    public $inputs;
    public $data;
    public $user_id_name;

    protected $listeners = ['reset-form' => 'resetForm'];

    public function mount($inputs = []) {
        $this->user_id_name = '';
        $this->inputs = $inputs;
        $this->data = [];

        foreach ($this->inputs as $input) {
            $this->data[$input['name']] = $input['value'] ?? '';
        }

        if (request()->has('filter')) {
            $request = base64_decode(request()->get('filter'));
            $json = json_decode($request, true)[0];
            $jsonFilter = $json['filter'];
            $resultJsonFilter = json_decode($jsonFilter, true);
            if (isset($resultJsonFilter['user_id']) && gettype($resultJsonFilter['user_id']) == 'integer') $resultJsonFilter['user_id'] = User::where('id', $resultJsonFilter['user_id'])->value('name');
            $this->data = $resultJsonFilter;
        }
    }

    public function render() {
        return view('livewire.components.popup-filter');
    }

    public function filter() {
        $this->user_id_name = $this->data['user_id'];
        if (isset($this->data['user_id'])) $this->data['user_id'] = User::where('name', $this->data['user_id'])->value('id') ?? $this->user_id_name;
        $json = json_encode($this->data);
        $this->dispatch('change-url', ['filter' => $json]);
    }

    public function resetForm() {
        $this->user_id_name = '';
        $this->dispatch('change-reset-url');
    }
}
