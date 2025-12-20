<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search results.
     */
    public function index(Request $request)
    {
        $query = $request->q;
        $category = $request->input('category', '');
        $brand = $request->input('brand', '');
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 1000000);
        $sortBy = $request->input('sort_by', 'relevance');

        // Perform search with Scout
        $products = Product::search($query)
            ->when($category, function ($search) use ($category) {
                $search->where('facets.category', $category);
            })
            ->when($brand, function ($search) use ($brand) {
                $search->where('facets.brand', $brand);
            })
            ->when(true, function ($search) use ($minPrice, $maxPrice) {
                $search->whereBetween('price', [$minPrice, $maxPrice]);
            })
            ->orderBy($this->getSortField($sortBy), $this->getSortDirection($sortBy))
            ->paginate(12);

        // Get facets for filters
        $facets = $this->getFacets();

        return view('search.results', compact('products', 'query', 'facets'));
    }

    /**
     * Quick search for navbar.
     */
    public function quickSearch(Request $request)
    {
        $query = $request->input('q', '');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Product::search($query)
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price, 2),
                    'image' => $product->image ? asset('storage/' . $product->image) : asset('images/default-product.jpg'),
                    'category' => $product->category ? $product->category->name : 'Uncategorized',
                    'url' => route('products.show', $product->slug),
                ];
            });

        return response()->json($results);
    }

    /**
     * Get sorting field.
     */
    private function getSortField($sortBy)
    {
        switch ($sortBy) {
            case 'price_asc':
                return 'price';
            case 'price_desc':
                return 'price';
            case 'name_asc':
                return 'name';
            case 'name_desc':
                return 'name';
            case 'newest':
                return 'created_at';
            default:
                return '_score'; // Relevance
        }
    }

    /**
     * Get sorting direction.
     */
    private function getSortDirection($sortBy)
    {
        if (in_array($sortBy, ['price_desc', 'name_desc'])) {
            return 'desc';
        }
        return 'asc';
    }

    /**
     * Get available facets for filtering.
     */
    private function getFacets()
    {
        return [
            'categories' => \App\Models\Category::whereHas('products')->pluck('name', 'id'),
            'brands' => \App\Models\Brands::whereHas('products')->pluck('name', 'id'),
            'price_ranges' => [
                '0-1000' => 'Under KES 1,000',
                '1000-5000' => 'KES 1,000 - 5,000',
                '5000-10000' => 'KES 5,000 - 10,000',
                '10000-50000' => 'KES 10,000 - 50,000',
                '50000-100000' => 'KES 50,000 - 100,000',
                '100000-' => 'Over KES 100,000',
            ],
        ];
    }
}
