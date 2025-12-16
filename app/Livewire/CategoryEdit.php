<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CategoryEdit extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:3')]
    public $name = '';

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:4096')]
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
        $this->validate();

        // Update slug based on new name
        $this->slug = Str::slug($this->name);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
        ];

        // Handle image upload
        if ($this->image) {
            // Delete old image if it exists
            if ($this->category->image && Storage::disk('public')->exists($this->category->image)) {
                Storage::disk('public')->delete($this->category->image);
            }

            // Store new image
            $data['image'] = $this->image->store('products/categories', 'public');
        }

        $this->category->update($data);
        session()->flash('success', 'Category updated successfully.');
    }

    public function render()
    {
        return view('livewire.category-edit');
    }
}
