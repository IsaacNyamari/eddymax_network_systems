<?php

namespace App\Livewire;

use App\Models\WishList;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishListBlade extends Component
{
    public $wishlists = [];
    public function render()
    {
        $wishlists = WishList::with('product')
            ->where('user_id', Auth::id())
            ->whereNull('deleted_at')
            ->latest()
            ->get();

        return view('livewire.wish-list-blade', compact('wishlists'));
    }
}
