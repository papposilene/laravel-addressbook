<?php

namespace App\Http\Livewire\Interfaces;

use Livewire\Component;

class ChartDoughnut extends Component
{
    public string $api;

    public function render()
    {
        return view('livewire.interfaces.chart-doughnut', [
            'api' => $this->api,
        ]);
    }
}
