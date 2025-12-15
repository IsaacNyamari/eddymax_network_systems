<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CustomerProfile extends Component
{
    public $user;
    #[Validate('required|min:3')]
    public $name = '';
    #[Validate('required|email')]
    public $email = '';
    #[Validate('required|string|min:10')]
    public $phone = '';
    #[Validate('required|string|min:3')]
    public $address = '';
    public $userAddress;
    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->addresses->first()->phone;
        $this->userAddress = $this->user->addresses->first();
        $this->address = $this->userAddress->address;
    }
    // update the user details
    public function updateProfileInformation()
    {
        // dd($this->address);
        $this->user->update([
            'name' => $this->name,
            'email' => $this->email
        ]);

        $add =  $this->userAddress->update([
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->dispatch('profile-updated', $this->user->name);
    }
    public function render()
    {
        return view('livewire.customer-profile');
    }
}
