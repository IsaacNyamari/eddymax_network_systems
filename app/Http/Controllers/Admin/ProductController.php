<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('dashboard.admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.admin.products.edit', compact('product', 'categories'));
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
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with("success", 'Product moved to trash!');
    }
    /**
     * Trashed products
     */
    public function trash()
    {
        // Get trashed products
        $products = Product::onlyTrashed()->paginate(10);
        return view('dashboard.admin.products.trash', compact('products'));
    }
    public function trashForceDelete(string $id)
    {
        Product::withTrashed()->where('id', $id)->forceDelete();
        return back()->with('success', 'product deleted successfully!');
    }
    public function trashRestore(string $id)
    {
        Product::withTrashed()->where('id', $id)->restore();
        return back()->with('success', 'product restored successfully!');
    }
}
