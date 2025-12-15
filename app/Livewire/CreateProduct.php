<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255|min:3')]
    public $name;

    #[Validate('required|numeric|min:0')]
    public $price;

    #[Validate('nullable|image|max:1024')]
    public $image;

    #[Validate('nullable|string|max:2000')]
    public $description;

    #[Validate('required|exists:categories,id')]
    public $category_id;

    public $categories = [];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
        }

        Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'slug' => Str::slug($this->name),
        ]);

        // Reset form
        $this->reset();
        $this->reset('image'); // Reset file upload separately

        session()->flash('message', 'Product created successfully.');
    }

    public function render()
    {
        return view('livewire.create-product');
    }
}
