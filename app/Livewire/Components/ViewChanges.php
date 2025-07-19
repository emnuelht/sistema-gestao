<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ViewChanges extends Component
{
    public $old;
    public $new;
    public $diffs = null;

    protected $listeners = [
        'changes' => 'viewChanges',
        'reset' => 'resetValues'
    ];

    public function mount($old = null, $new = null) {
        $this->old = $old;
        $this->new = $new;

        if (is_null($old) && is_null($new)) return;

        $this->diffs = [];
    }

    public function render() {
        return view('livewire.components.view-changes');
    }

    public function viewChanges($itemOld, $itemNew) {
        $this->old = is_array($itemOld) ? $itemOld : json_decode($itemOld, true);
        $this->new = is_array($itemNew) ? $itemNew : json_decode($itemNew, true);

        $this->diffs = [];

        $allKeys = array_unique(array_merge(
            array_keys($this->old ?? []),
            array_keys($this->new ?? [])
        ));

        foreach ($allKeys as $key) {
            $oldValue = $this->old[$key] ?? null;
            $newValue = $this->new[$key] ?? null;

            if ($oldValue != $newValue) {
                $this->diffs[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }
    }

    public function resetValues() {
        $this->diffs = null;
    }
}
