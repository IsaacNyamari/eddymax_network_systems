<?php

namespace App\Livewire;

use Livewire\Component;

class SalesChart extends Component
{
    public $salesData;
    public function render()
    {
        return view('livewire.sales-chart');
    }
}
