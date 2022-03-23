<?php

namespace App\Http\Livewire\Interfaces;

use App\Models\Address;
use Livewire\Component;

class Map extends Component
{
    public Address $address;

    public function mount($address)
    {
        $this->address = $address;
    }

    public function render()
    {
        return view('livewire.interfaces.map', [
            'address' => $this->address,
        ]);
    }
}
