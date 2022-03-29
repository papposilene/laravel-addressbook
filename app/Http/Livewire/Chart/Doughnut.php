<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;

class Doughnut extends Component
{
    public string $api;

    public function render()
    {
        return view('livewire.chart.doughnut', [
            'api' => $this->api,
        ]);
    }
}
