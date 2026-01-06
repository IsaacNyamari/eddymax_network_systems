<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactPage extends Component
{
    #[Validate("string|required|min:3")]
    public $name;
    #[Validate("email|required|min:3")]
    public $email;
    #[Validate("string|required|min:10")]
    public $phone;
    #[Validate("string|required|min:10")]
    public $message;

    public function submit()
    {
        $data = $this->validate();
        Message::create($data);
        $this->dispatch('message-sent', ['message' => 'Your Message has been sent successfully!']);
    }
    public function render()
    {
        return view('livewire.contact-page');
    }
    // clear form

}
