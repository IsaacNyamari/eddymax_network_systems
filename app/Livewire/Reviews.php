<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Product;
use App\Models\ProductRating;

class Reviews extends Component
{
    public $product;
    
    #[Validate('required|integer|min:1|max:5', message: 'Please select a rating')]
    public $rateCount = 0;
    
    #[Validate('nullable|string|max:1000', message: 'Comment must be less than 1000 characters')]
    public $comment = '';
    
    public $showSuccessMessage = false;
    public $loading = false;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function setRating($rating)
    {
        $this->rateCount = $rating;
    }

    public function saveRating()
    {
        $this->validate();
        
        $this->loading = true;

        try {
            // Create new rating - no authentication required
            ProductRating::create([
                'product_id' => $this->product->id,
                'rate_count' => $this->rateCount,
                'comment' => $this->comment ?: null,
            ]);
            
            session()->flash('message', 'Thank you for your review!');
            
            // Reset form
            $this->reset(['rateCount', 'comment']);
            $this->showSuccessMessage = true;

            // Hide success message after 5 seconds
            $this->dispatch('review-saved');

        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. Please try again.');
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.reviews');
    }
}