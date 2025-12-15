<?php

namespace App\Livewire;

use Livewire\Component;

class AddToCartButton extends Component
{
    public $product;
    public function addToCart($productId)
    {
        $cart = session()->get('cart', []);

        $product = \App\Models\Product::find($productId)->toArray();
        $product['quantity'] = 1;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = $product;
        }

        session()->put('cart', $cart);
        $this->dispatch('added-to-cart', [
        'productName' => $this->product['name'],
        'message' => "{$this->product['name']} added to cart!",
    ]);
    
    $this->dispatch('cart-updated');
    }
    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
