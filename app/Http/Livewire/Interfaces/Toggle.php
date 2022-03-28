<?php

namespace App\Http\Livewire\Interfaces;

use Livewire\Component;

class Toggle extends Component
{
    public bool $withAddresses;

    public function mount(bool $withAddresses = false)
    {
        $this->withAddresses = $withAddresses;
    }

    public function render()
    {
        return view('livewire.interfaces.toggle-button', [
            'withAddresses' => $this->withAddresses
        ]);
    }
}
