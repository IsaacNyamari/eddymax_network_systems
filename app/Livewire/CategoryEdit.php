<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryEdit extends Component
{
    use WithFileUploads;
    #[Validate('required|string|min:3')]
    public $name = '';
    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:4096')]
    public $image;
    public $slug = '';
    public $category;
    public function mount()
    {
        $this->category = '';
        $this->slug = Str::slug($this->name);
    }
    public function saveCategory()
    {

        $this->validate();

        // Ensure slug exists
        $this->slug = Str::slug($this->name);

        $category = Category::where('slug', $this->slug)->first();

        if (! $category) {
            return;
        }

        $data = ['name' => $this->name];

        if ($this->image) {
            $data['image'] = $this->image->store('products/categories', 'public');
        }

        $category->update($data);
    }

    public function render()
    {
        return view('livewire.category-edit');
    }
}
