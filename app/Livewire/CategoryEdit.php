<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\Request;
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

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|min:3|unique:categories,name',
            'parent_category' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // Generate slug
        $slug = Str::slug($validated['name']);

        // Prepare data
        $data = [
            'parent_id' => $validated['parent_category'] ?? null,
            'name' => $validated['name'],
            'slug' => $slug,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products/categories', 'public');
        }
        // Create category
        $category = Category::create($data);
        return $category;
        return redirect()->back()->with('success', 'Category created successfully.');
    }

    public function render()
    {
        return view('livewire.category-edit');
    }
}
