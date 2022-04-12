<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;

class Doughnut extends Component
{
    public string $api;
    public string $name;

    public function render()
    {
        return view('livewire.chart.doughnut', [
            'name' => $this->name,
            'api' => $this->api,
        ]);
    }
}
