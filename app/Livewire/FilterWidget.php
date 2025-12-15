<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;


class FilterWidget extends Component
{
    public $categories;
    public $selectedCategory = null; // null = All Categories
    public $min_price;
    public $max_price;
    public $products;
    public $fixedMaxPrice;
    public $fixedMinPrice;
    public function mount($categories)
    {

        $this->min_price = Product::min('price');
        $this->max_price = Product::max('price');
        $this->categories = $categories;
        $this->fixedMaxPrice = Product::max('price');
        $this->fixedMinPrice = Product::min('price');
    }
    public function search()
    {
        if (empty($this->selectedCategory)) {
            // All products
            $this->products = Product::query()
                ->when($this->min_price, fn($q) => $q->where('price', '>=', $this->min_price))
                ->when($this->max_price, fn($q) => $q->where('price', '<=', $this->max_price))
                ->get();
        } else {
            // Products by category
            $category = Category::where('slug', $this->selectedCategory)->first();

            $this->products = $category
                ? $category->products()
                ->when($this->min_price, fn($q) => $q->where('price', '>=', $this->min_price))
                ->when($this->max_price, fn($q) => $q->where('price', '<=', $this->max_price))
                ->get()
                : collect();
        }

        $this->dispatch(
            'filter-result',
            view('partials.filter-results', ['products' => $this->products])->render()
        );
    }

    public function render()
    {
        return view('livewire.filter-widget');
    }
}
