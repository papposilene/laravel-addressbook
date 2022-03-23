<?php

namespace App\Http\Livewire\Interfaces;

use App\Models\Address;
use Livewire\Component;

class Map extends Component
{
    public string $classes;
    public string $styles;
    public Address $address;

    public function mount($address, $classes, $styles)
    {
        $this->classes = $classes;
        $this->styles = $styles;
        $this->address = $address;
    }

    public function render()
    {
        return view('livewire.interfaces.map', [
            'address' => $this->address,
            'classes' => $this->classes,
            'styles' => $this->styles,
        ]);
    }
}
