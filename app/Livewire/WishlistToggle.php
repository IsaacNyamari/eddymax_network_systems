<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\WishList as WishListModel;
use Illuminate\Support\Facades\Auth;

class WishlistToggle extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function toggleWishList()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $wishlist = WishListModel::withTrashed()
            ->where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($wishlist && !$wishlist->trashed()) {
            // ✅ remove (soft delete)
            $wishlist->delete();
        } else {
            // ✅ add or restore
            $wishlist = WishListModel::withTrashed()
                ->where('user_id', Auth::id())
                ->where('product_id', $this->product->id)
                ->first();

            if ($wishlist) {
                if ($wishlist->trashed()) {
                    $wishlist->restore(); // ✅ proper restore
                }
            } else {
                WishListModel::create([
                    'user_id' => Auth::id(),
                    'product_id' => $this->product->id,
                ]);
            }
        }

        // 🔄 refresh state
        $this->product->refresh();
    }

    public function render()
    {
        return view('livewire.wishlist-toggle');
    }
}
