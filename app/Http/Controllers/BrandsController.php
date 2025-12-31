<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // In your controller
        $brands = Brands::withCount('products')->paginate(10);
        return view('dashboard.admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HttpRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2',
            'slug' => 'required|min:2'
        ]);
        Brands::create($data);
        return back()->with('success', $data['name'] . " created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Brands $brand)
    {
        // Load product count and recent products
        $brand->loadCount('products');

        $recentProducts = $brand->products()
            ->with('category')
            ->latest()
            ->take(10)
            ->get();

        // Get stock statistics (optional)
        $inStockCount = $brand->products()->where('stock_quantity', '>', 0)->count();
        $outOfStockCount = $brand->products()->where('stock_quantity', '<=', 0)->count();

        return view('dashboard.admin.brands.show', compact(
            'brand',
            'recentProducts',
            'inStockCount',
            'outOfStockCount'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $brandData)
    {
        $brand = Brands::where('id', $brandData)->with('products')->get()->first();
        return view('dashboard.admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HttpRequest $request, Brands $brand)
    {
        $data = $request->validate([
            'name' => 'required|min:2',
            'slug' => 'required|min:2'
        ]);
        $brand->update($data);
        return back()->with('success', $data['name'] . " updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brands $brand)
    {
        $brand->delete();
        return back()->with('success', "Brand deleted successfully!");
    }
}
