<?php

namespace App\Http\Controllers;

use App\Models\Product;

class TrashController extends Controller
{
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(10);
        return view('dashboard.admin.products.trash', compact('products'));
    }
}
