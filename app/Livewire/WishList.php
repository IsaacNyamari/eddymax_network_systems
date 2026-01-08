<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishList extends Component
{
    public $product;
    public $user;
    public function mount(Product $product)
    {
        $this->product = $product;
        $this->user = Auth::user();
    }

    public function addToWishList()
    {
        if ($this->user) {
            $createWhishList =  $this->user->wishlists()->create(["user_id" => $this->user->id, 'product_id' => $this->product->id]);
            dd($createWhishList);
        }
    }
    public function toggleWishList($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlist = WishList::withTrashed()
            ->where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist && !$wishlist->trashed()) {
            // ✅ remove (soft delete)
            $wishlist->delete();
        } else {
            // ✅ add or restore
            WishList::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                ],
                ['deleted_at' => null]
            );
        }
    }
    public function render()
    {
        return view('livewire.wish-list');
    }
}
