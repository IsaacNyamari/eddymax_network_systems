<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryEdit extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:3')]
    public $name = '';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp')]
    public $image;

    public $category;
    public $slug = '';

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->slug = $category->slug;
    }

public function saveCategory()
{
    // Validate using Livewire
    $this->validate();

    // Generate slug
    $this->slug = Str::slug($this->name);

    // Handle image upload
    if ($this->image) {
        $imagePath = $this->image->store('products/categories', 'public');
        $this->category->image = $imagePath;
    }

    // Update category
    $this->category->name = $this->name;
    $this->category->slug = $this->slug;
    $this->category->save();

    session()->flash('success', 'Category updated successfully.');
}


    public function render()
    {
        return view('livewire.category-edit');
    }
}
