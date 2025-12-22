<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImages;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255|min:3')]
    public $brand;
    #[Validate('required|string|max:255|min:3')]
    public $model;
    #[Validate('required|string|max:255|min:3')]
    public $name;

    #[Validate('required|numeric|min:0')]
    public $price;

    #[Validate('nullable|image|max:1024')]
    public $image;

    public $images = [];

    #[Validate('nullable|string|max:10000|min:10')]
    public $description;
    #[Validate('nullable|string|max:2000|min:10')]
    public $short_description;

    #[Validate('required|exists:categories,id')]
    public $category_id;

    public $categories = [];

    // In your Livewire component
    // In your Livewire component
    public function mount()
    {
        $this->categories = $this->getNestedCategories();
    }

    private function getNestedCategories()
    {
        return Category::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->with(['children' => function ($query) {
                    $query->with(['children']);
                }]);
            }])
            ->orderBy('name')
            ->get();
    }

    // Method to remove a specific image from the array
    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            // Re-index the array to maintain proper order
            $this->images = array_values($this->images);
        }
    }

    public function save()
    {
        $this->validate();

        // Handle main image upload
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
        }

        // Create product
        $product = Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'model' => $this->model,
            'brand' => $this->brand,
            'category_id' => $this->category_id,
            'slug' => Str::slug($this->name),
        ]);

        // Handle multiple images upload
        if (!empty($this->images)) {
            foreach ($this->images as $uploadedImage) {
                $path = $uploadedImage->store('product-images', 'public');

                ProductImages::create([
                    'path' => $path,
                    'imageable_id' => $product->id,
                    'imageable_type' => Product::class,
                ]);
            }
        }

        // Reset form
        $this->reset();
        $this->reset('image', 'images'); // Reset file uploads separately

        session()->flash('message', 'Product created successfully.');
    }

    public function render()
    {
        return view('livewire.create-product');
    }
}
