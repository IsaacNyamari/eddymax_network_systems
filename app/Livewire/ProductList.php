<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductList extends Component
{
    public $cart = [];
    public $products = [];

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->products = Product::all();
    }

    public function addToCart($productId)
    {
        $cart = session()->get('cart', []);

        $product = Product::find($productId)->toArray();
        $product['quantity'] = 1;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = $product;
        }

        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->dispatch('added-to-cart', [
            'productName' => $product['name'],
            'message' => "{$product['name']} added to cart!",
        ]);
    }

    public function removeItem($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->dispatch('removed-from-cart', [
            'productName' => Product::find($productId)->name,
            'message' => "Item removed from cart",
        ]);
    }

    public function increment($productId)
    {
        $this->cart[$productId]['quantity']++;
        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated', [
            'message' => "Quantity updated",
            'type' => 'info'
        ]);
    }

    public function decrement($productId)
    {
        if ($this->cart[$productId]['quantity'] > 1) {
            $this->cart[$productId]['quantity']--;
        }

        session()->put('cart', $this->cart);
        $this->dispatch('cart-updated', [
            'message' => "Quantity updated",
            'type' => 'info'
        ]);
    }

    public function render()
    {
        return view('livewire.product-list');
    }
}
