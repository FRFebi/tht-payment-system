<?php

namespace App\Livewire;

use Livewire\Component;

class Wallet extends Component
{
    public $wallet;

    public function render()
    {
        return view('livewire.wallet');
    }

    public function mount($wallet){
        $this->wallet = $wallet;
    }
}
