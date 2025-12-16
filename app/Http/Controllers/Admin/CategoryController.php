<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10)->get();
        return view('dashboard.admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('dashboard.admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate base input (NOT unique here)
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'parent_category' => 'nullable|integer|',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // Split names by comma and clean them
        $names = collect(explode(',', $validated['name']))
            ->map(fn($name) => trim($name))
            ->filter()            // remove empty values
            ->unique();            // prevent duplicates in same request

        // Store image ONCE (shared)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products/categories', 'public');
        }

        foreach ($names as $name) {
            $slug = Str::slug($name);

            // Skip if category already exists
            if (Category::where('slug', $slug)->exists()) {
                continue;
            }

            Category::create([
                'parent_id' => $validated['parent_category'] ?? null,
                'name'      => ucfirst($name),
                'slug'      => $slug,
                'image'     => $imagePath,
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Categories created successfully.'
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $category = Category::where('id', $id)->first();
        return view('dashboard.admin.categories.edit', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
