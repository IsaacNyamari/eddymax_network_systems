<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:3|unique:categories,name')]
    public string $name = '';

    // parent category ID (nullable)
    #[Validate('nullable|integer|exists:categories,id')]
    public ?int $parent_category = null;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:4096')]
    public $image;

    public string $slug = '';

    public $categories;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function saveCategory()
    {
        $this->validate();
        $this->slug = Str::slug($this->name);

        $data = [
            'parent_id' => $this->parent_category !== null && $this->parent_category !== ''
                ? (int) $this->parent_category
                : null,
            'name'      => $this->name,
            'slug'      => $this->slug,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('products/categories', 'public');
        }

        Category::create($data);

        $this->reset(['name', 'image', 'parent_category']);

        session()->flash('success', 'Category created successfully.');
    }


    public function render()
    {
        return view('livewire.category-create');
    }
}
