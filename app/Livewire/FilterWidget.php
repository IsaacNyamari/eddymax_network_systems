<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

class FilterWidget extends Component
{
    public $categories;
    public $selectedCategory = null;
    public $min_price;
    public $max_price;
    public $products;
    public $fixedMaxPrice;
    public $fixedMinPrice;
    public $is_parent_category;

    // New properties
    public $priceRange = [0, 0];
    public $selectedBrands = [];
    public $selectedRatings = [];
    public $sortBy = 'default';
    public $inStockOnly = false;
    public $onSaleOnly = false;
    public $showAdvancedFilters = false;
    public $brands = [];
    public $searchQuery = '';
    public $loading = false;
    public $resultCount = 0;

    public function mount($categories)
    {
        $this->categories = $categories;
        $this->fixedMinPrice = Product::min('price') ?? 0;
        $this->fixedMaxPrice = Product::max('price') ?? 10000;
        $this->min_price = $this->fixedMinPrice;
        $this->max_price = $this->fixedMaxPrice;
        $this->priceRange = [$this->fixedMinPrice, $this->fixedMaxPrice];

        // Get unique brands from products
        $this->brands = Product::select('brand')
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand')
            ->filter()
            ->values()
            ->toArray();
    }

    #[On('reset-filters')]
    public function resetFilters()
    {
        $this->selectedCategory = null;
        $this->min_price = $this->fixedMinPrice;
        $this->max_price = $this->fixedMaxPrice;
        $this->priceRange = [$this->fixedMinPrice, $this->fixedMaxPrice];
        $this->selectedBrands = [];
        $this->selectedRatings = [];
        $this->sortBy = 'default';
        $this->inStockOnly = false;
        $this->onSaleOnly = false;
        $this->searchQuery = '';

        // $this->search();
    }

    public function updated()
    {
        // Debounced search (auto-search on filter change)
        $this->dispatch('search-debounced');
    }

    #[On('search-debounced')]
   public function search()
{
    $this->loading = true;
    
    // Build query
    $query = Product::query();

    // Category filter (including children)
    if (!empty($this->selectedCategory)) {
        $category = Category::where('slug', $this->selectedCategory)->first();

        if ($category) {
            $categoryIds = $this->getAllCategoryIds($category);
            $query->whereHas('category', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            });
        }
    }

    // Price range
    $query->whereBetween('price', [$this->min_price, $this->max_price]);

    // Brand filter
    if (!empty($this->selectedBrands)) {
        $query->whereIn('brand', $this->selectedBrands);
    }

    // Rating filter
    if (!empty($this->selectedRatings)) {
        $query->where(function ($q) {
            foreach ($this->selectedRatings as $rating) {
                $minRating = $rating - 0.5;
                $maxRating = $rating + 0.5;
                $q->orWhereBetween('rating', [$minRating, $maxRating]);
            }
        });
    }

    // Stock filter
    if ($this->inStockOnly) {
        $query->where('stock_quantity', '>', 0);
    }

    // Sale filter
    if ($this->onSaleOnly) {
        $query->where('discount_percent', '>', 0)
            ->orWhere('is_on_sale', true);
    }

    // Search query
    if (!empty($this->searchQuery)) {
        $query->where(function ($q) {
            $q->where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('description', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('brand', 'like', '%' . $this->searchQuery . '%');
        });
    }

    // Sorting
    switch ($this->sortBy) {
        case 'price_low':
            $query->orderBy('price', 'asc');
            break;
        case 'price_high':
            $query->orderBy('price', 'desc');
            break;
        case 'popular':
            $query->orderBy('views', 'desc');
            break;
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'rating':
            $query->orderBy('rating', 'desc');
            break;
        default:
            $query->orderBy('created_at', 'desc');
    }

    $this->products = $query->get();
    $this->resultCount = $this->products->count();
    
    $this->loading = false;

    // Dispatch with both HTML and data separately
    $this->dispatch(
        'filter-result',
        html: view('partials.filter-results', [
            'products' => $this->products,
            'resultCount' => $this->resultCount
        ])->render(),
        resultCount: $this->resultCount // Send resultCount as separate parameter
    );
}

    public function updatedPriceRange($value)
    {
        $this->min_price = $value[0];
        $this->max_price = $value[1];
    }

    public function toggleBrand($brand)
    {
        if (in_array($brand, $this->selectedBrands)) {
            $this->selectedBrands = array_diff($this->selectedBrands, [$brand]);
        } else {
            $this->selectedBrands[] = $brand;
        }
    }

    public function toggleRating($rating)
    {
        if (in_array($rating, $this->selectedRatings)) {
            $this->selectedRatings = array_diff($this->selectedRatings, [$rating]);
        } else {
            $this->selectedRatings[] = $rating;
        }
    }

    #[Computed]
    public function activeFilterCount()
    {
        $count = 0;
        if ($this->selectedCategory) $count++;
        if ($this->min_price != $this->fixedMinPrice || $this->max_price != $this->fixedMaxPrice) $count++;
        if (!empty($this->selectedBrands)) $count += count($this->selectedBrands);
        if (!empty($this->selectedRatings)) $count += count($this->selectedRatings);
        if ($this->inStockOnly) $count++;
        if ($this->onSaleOnly) $count++;
        if ($this->sortBy !== 'default') $count++;
        return $count;
    }

    private function getAllCategoryIds($category)
    {
        $categoryIds = [$category->id];
        $this->getChildrenCategoryIds($category, $categoryIds);
        return $categoryIds;
    }

    private function getChildrenCategoryIds($category, &$categoryIds)
    {
        if ($category->children && $category->children->isNotEmpty()) {
            foreach ($category->children as $child) {
                $categoryIds[] = $child->id;
                $this->getChildrenCategoryIds($child, $categoryIds);
            }
        }
    }

    public function render()
    {
        return view('livewire.filter-widget');
    }
}
