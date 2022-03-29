<?php

namespace App\Http\Livewire\Chart;

use Livewire\Component;

class Pie extends Component
{
    public string $api;

    public function render()
    {
        return view('livewire.chart.pie', [
            'api' => $this->api,
        ]);
    }
}
