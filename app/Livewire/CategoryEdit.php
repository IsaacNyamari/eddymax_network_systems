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
    public $categories;

    #[Validate('required|string|min:3')]
    public $name = '';

    #[Validate('nullable|exists:categories,id')]
    public $parent_id = null;

    public $selectedParentCategory = '';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp')]
    public $image;

    public $category;
    public $slug = '';

    public function mount(Category $category)
    {
        $this->categories = Category::all();
        $this->category = $category;
        $this->name = $category->name;
        // Fix: Check if parent exists before accessing id
        $this->parent_id = $category->parent ? $category->parent->id : null;
        $this->slug = $category->slug;
    }

    public function saveCategory()
    {

        // Validate using Livewire
        $this->validate();
        $this->selectedParentCategory == "" ? $this->selectedParentCategory = null : "";

        // Generate slug
        $this->slug = Str::slug($this->name);

        // Handle image upload
        if ($this->image) {
            $imagePath = $this->image->store('products/categories', 'public');
            $this->category->image = $imagePath;
        }

        // Update category
        $this->category->name = $this->name;
        $this->category->parent_id = $this->selectedParentCategory;
        $this->category->slug = $this->slug;
        $this->category->save();

        session()->flash('success', 'Category updated successfully.');
    }


    public function render()
    {
        return view('livewire.category-edit');
    }
}
