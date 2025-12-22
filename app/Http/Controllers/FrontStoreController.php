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
            ->take(10)
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
        $products = Product::all();
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
        $parent_categories = Category::whereNull('parent_id')->where('slug', $filter)->with('products')
            ->with(['children.children'])
            ->take(10)
            ->get();
        return ($parent_categories);
        // Get categories with product counts (optional)
        $categories = Category::withCount('products')->get();
        // Get products for the given category slug
        $productsSorted = Product::whereHas('category', function ($query) use ($filter) {
            $query->where('slug', $filter);
        })->get();
        return view('layouts.front-end.products.index', compact('productsSorted', 'categories'));
    }
}
