<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class Cart extends Component
{
    public $cart;
    public $productName;
    public function mount()
    {
        $this->productName = '';
        $this->cart = session()->get('cart', []);
    }
    public function removeItem($productId)
    {
        $this->productName = Product::find($productId)->name;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->dispatch('cart-updated');
    }
    public function increment($productId)
    {
        $this->cart[$productId]['quantity']++;
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated');
    }
    public function decrement($productId)
    {
        if ($this->cart[$productId]['quantity'] > 1) {
            $this->cart[$productId]['quantity']--;
            session()->put('cart', $this->cart);
            $this->dispatch('cart-updated');
        }
    }
    public function clearCart()
    {
        // Clear the cart from session
        session()->forget('cart');
        $this->dispatch('cart-updated');
    }
    public function render()
    {
        return view('livewire.cart');
    }
}
