<?php

namespace App\Livewire;

use Livewire\Component;

class Table extends Component
{

    public $orders;
    public function render()
    {
        return view('livewire.table');
    }

    public function mount($orders){
            $this->orders = $orders;
    }
}
