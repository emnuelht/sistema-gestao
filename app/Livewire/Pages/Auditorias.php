<?php

namespace App\Livewire\Pages;

use App\Models\Auditoria;
use Livewire\Component;

class Auditorias extends Component
{
    public $auditorias;

    public function mount() {
        if (request()->has('filter')) {
            $request = base64_decode(request()->get('filter'));
            $json = json_decode($request, true)[0];
            $jsonFilter = $json['filter'];
            $resultJsonFilter = json_decode($jsonFilter, true);

            $query = Auditoria::query();

            foreach ($resultJsonFilter as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'like', "%{$value}%");
                }
            }

            $this->auditorias = $query->get();
        } else {
            $this->auditorias = Auditoria::with('user')->get();
        }
    }

    public function render() {
        return view('livewire.pages.auditorias');
    }
}
