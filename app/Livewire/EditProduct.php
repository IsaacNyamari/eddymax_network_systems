<?php

namespace App\Livewire;

use App\Models\Brands;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public $product;
    public $brands = [];

    #[Validate('required|int')]
    public $brand;
    #[Validate('required|string|max:255|min:3')]
    public $name;

    #[Validate('required|numeric|min:0')]
    public $price;

    #[Validate('required|string|min:0')]
    public $model;

    // #[Validate('required|string|min:0')]
    // public $brand;

    #[Validate('required|numeric|min:0')]
    public $stock;

    #[Validate('required|string|in:in_stock,out_of_stock,backorder')]
    public $stock_status = 'in_stock'; // Default value already set

    public $existingImage;

    #[Validate('nullable|image|max:4096')]
    public $image;

    #[Validate('nullable|string|max:10000')]
    public $description;

    #[Validate('required|exists:categories,id')]
    public $category_id;

    public $categories = [];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->existingImage = $product->image;
        $this->description = $product->description;
        $this->category_id = $product->category_id;
        $this->brand = $product->brand;
        $this->model = $product->model;
        $this->stock = $product->stock_quantity;
        $this->stock_status = $product->stock_status ?? 'in_stock'; // Fallback to default
        $this->categories = Category::all();
        $this->brands = Brands::all();
    }

    public function saveProduct()
    {
        $this->validate();

        $imagePath = $this->existingImage;

        // If new image is uploaded, replace the old one
        if ($this->image) {
            // Delete old image if exists
            if ($this->existingImage && file_exists(storage_path('app/public/' . $this->existingImage))) {
                unlink(storage_path('app/public/' . $this->existingImage));
            }

            $imagePath = $this->image->store('products', 'public');
        }

        $this->product->update([
            'name' => $this->name,
            'price' => $this->price,
            'image' => $imagePath,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'model' => $this->model,
            'brand_id' => $this->brand,
            'stock_quantity' => $this->stock,
            'stock_status' => $this->stock_status,
            'slug' => Str::slug($this->name),
        ]);

        // Refresh existing image if new one was uploaded
        if ($this->image) {
            $this->existingImage = $imagePath;
            $this->image = null; // Clear the uploaded file
        }

        session()->flash('message', 'Product updated successfully.');
        $this->dispatch('product-edit', [
            "message" => "Product updated successfully!"
        ]);
    }

    public function deleteImage()
    {
        if ($this->existingImage && file_exists(storage_path('app/public/' . $this->existingImage))) {
            unlink(storage_path('app/public/' . $this->existingImage));
        }

        $this->product->update(['image' => null]);
        $this->existingImage = null;

        session()->flash('message', 'Product image removed.');
    }

    public function render()
    {
        return view('livewire.edit-product');
    }
}
