<?php

namespace App\Livewire\Components;

use Livewire\Component;

class BoxItem extends Component
{

    public $iconHeader;
    public $iconBody;
    public $id;
    public $nome;
    public $count;
    public $countText;
    public $updated_at;
    public $url;

    public function mount( $iconHeader = NULL, $iconBody = NULL, $id = NULL, $nome = NULL, $count = NULL, $countText = NULL, $updated_at = NULL, $url = "#") {
        $this->iconHeader = $iconHeader;
        $this->iconBody = $iconBody;
        $this->id = $id;
        $this->nome = $nome;
        $this->count = $count;
        $this->countText = $countText;
        $this->updated_at = $updated_at;
        $this->url = $url;
    }

    public function render()
    {
        return view('livewire.components.box-item');
    }
}
