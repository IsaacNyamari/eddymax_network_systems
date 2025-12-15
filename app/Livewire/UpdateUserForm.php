<?php

namespace App\Livewire;

use App\Models\Adresses;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UpdateUserForm extends Component
{
    public $user;
    public   $roles;

    #[Validate('required|min:5|string')]
    public $name;
    #[Validate('required|min:5|email')]
    public $email;
    #[Validate('required|min:5|string')]
    public $phone;
    #[Validate('required|min:5|string')]
    public $address;
    public $userAddress;
    public function mount()
    {
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->addresses->first()->phone;
        $this->address = $this->user->addresses->first()->address;
        $this->roles = Role::all();
    }
    public function save()
    {
        $this->validate();
        $this->userAddress = Adresses::where('user_id', $this->user->id)->first();
        
        $this->user->update([
            "name" => $this->name,
            "email" => $this->email,
        ]);

        $this->userAddress->update([
            "phone" => $this->phone,
            "address" => $this->address
        ]);
    }
    public function render()
    {
        return view('livewire.update-user-form');
    }
}
