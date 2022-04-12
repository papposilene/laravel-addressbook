<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;

class Bar extends Component
{
    public string $api;
    public string $name;

    public function render()
    {
        return view('livewire.chart.bar', [
            'name' => $this->name,
            'api' => $this->api,
        ]);
    }
}
