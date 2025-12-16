<?php
// app/Http/Livewire/Navigation.php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category; // Make sure to import your Category model

class Navigation extends Component
{
    public $parents = [];

    public function mount()
    {
        $this->parents = Category::with(['children.children'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.navigation');
    }
}
