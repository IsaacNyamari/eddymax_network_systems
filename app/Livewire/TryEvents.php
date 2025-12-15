<?php

namespace App\Livewire;

use Livewire\Component;

class TryEvents extends Component
{
    public $message = 'Hello, Livewire Events!';
    public function sendMessage()
    {
        $this->dispatch('messageSent', $this->message);
    }
    public function render()
    {
        return view('livewire.try-events');
    }
}
