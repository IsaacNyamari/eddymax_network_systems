<?php

namespace App\Livewire;

use Livewire\Component;

class AdmminReturnsPageRefresh extends Component
{
    public $return;
    public function render()
    {
        return view('livewire.admmin-returns-page-refresh');
    }
}
