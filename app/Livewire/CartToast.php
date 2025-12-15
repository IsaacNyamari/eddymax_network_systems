<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CartToast extends Component
{
    public $show = false;
    public $message = '';
    public $type = 'success'; // success, error, warning, info
    public $duration = 3000; // milliseconds
    public $productName = '';
    public $action = ''; // added, removed, updated

    protected $listeners = [
        'added-to-cart' => 'showAddedToCart',
        'removed-from-cart' => 'showRemovedFromCart',
        'cart-updated' => 'showCartUpdated',
        'show-toast' => 'showCustomToast',
        'hide-toast' => 'hideToast',
    ];
    public function mount()
    {
        $this->show = false;
        $this->message = '';
        $this->type = 'success';
        $this->duration = 3000;
        $this->productName = '';
        $this->action = '';
    }
    public function showAddedToCart($data = null)
    {
        $this->productName = $data['productName'] ?? 'Product';
        $this->action = 'added';
        $this->message = $data['message'] ?? "{$this->productName} added to cart!";
        $this->type = 'success';
        $this->show = true;

        $this->dispatchBrowserEvent('start-toast-timer', [
            'duration' => $this->duration
        ]);
    }

    public function showRemovedFromCart($data = null)
    {
        $this->productName = $data['productName'] ?? 'Item';
        $this->action = 'removed';
        $this->message = $data['message'] ?? "{$this->productName} removed from cart";
        $this->type = 'info';
        $this->show = true;

        $this->dispatchBrowserEvent('start-toast-timer', [
            'duration' => $this->duration
        ]);
    }

    public function showCartUpdated($data = null)
    {
        $this->action = 'updated';
        $this->message = $data['message'] ?? 'Cart updated successfully';
        $this->type = $data['type'] ?? 'success';
        $this->show = true;

        $this->dispatchBrowserEvent('start-toast-timer', [
            'duration' => $this->duration
        ]);
    }

    public function showCustomToast($data)
    {
        $this->message = $data['message'] ?? '';
        $this->type = $data['type'] ?? 'success';
        $this->duration = $data['duration'] ?? 3000;
        $this->productName = $data['productName'] ?? '';
        $this->action = $data['action'] ?? '';
        $this->show = true;

        $this->dispatchBrowserEvent('start-toast-timer', [
            'duration' => $this->duration
        ]);
    }

    public function hideToast()
    {
        $this->show = false;
        $this->reset(['message', 'type', 'productName', 'action']);
    }

    public function render()
    {
        return view('livewire.cart-toast');
    }
}
