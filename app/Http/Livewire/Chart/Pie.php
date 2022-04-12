<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;

class Pie extends Component
{
    public string $api;
    public string $name;

    public function render()
    {
        return view('livewire.chart.pie', [
            'name' => $this->name,
            'api' => $this->api,
        ]);
    }
}
