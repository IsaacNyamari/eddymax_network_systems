<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FrontStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::all();
        $parent_categories = Category::whereNull('parent_id')->with('products')
            ->with(['children'])
            ->take(10)->orderBy('name', 'asc')
            ->get();
        return view('layouts.front-end.shop', compact('categories', 'products', 'parent_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * contact page
     */
    public function contact()
    {
        return view('layouts.front-end.contact');
    }

    /**
     * Display the specified resource.
     */
    public function returnRefund()
    {
        return view('layouts.front-end.return');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function shop()
    {
        $categories = Category::all();

        $seed = session()->get('product_seed');
        if (!$seed) {
            $seed = rand();
            session()->put('product_seed', $seed);
        }

        $products = Product::orderByRaw("RAND($seed)")->paginate(20);

        return view('layouts.front-end.products.index', compact('categories', 'products'));
    }
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart-page', compact('cart'));
    }
    public function checkout()
    {
        $cart = session()->get('cart', []);
        return view('layouts.front-end.checkout', compact('cart'));
    }
    public function orderConfirmation()
    {
        return view('layouts.front-end.order-confirmation');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function filterCategory(string $filter)
    {
        // Get the category by slug
        $category = Category::where('slug', $filter)->first();

        if (!$category) {
            abort(404);
        }

        // Collect all category IDs including current and descendants
        $categoryIds = collect([$category->id]);

        // Get child categories
        $childCategories = Category::where('parent_id', $category->id)->get();
        $categoryIds = $categoryIds->merge($childCategories->pluck('id'));

        // Get grandchild categories
        $grandchildCategories = Category::whereIn('parent_id', $childCategories->pluck('id'))->get();
        $categoryIds = $categoryIds->merge($grandchildCategories->pluck('id'));

        // Get all products from these categories
        $products = Product::whereIn('category_id', $categoryIds)
            ->with(['category'])
            ->paginate(12); // Adjust pagination as needed

        return view('layouts.front-end.products.show', compact('products'));
    }
}
