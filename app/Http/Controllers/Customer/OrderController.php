<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $recentOrders = $user->orders()
            ->with(['items', 'payments']) // eager load relationships
            ->orderBy('created_at', 'desc') // show newest first
            ->paginate(5);
        return view('dashboard.customer.orders.index', compact('recentOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        return view('dashboard.customer.orders.show', compact("order"));
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
    public function filterOrders(string $filter)
    {
        $user = Auth::user();
        $recentOrders = $user->orders()
            ->with(['items', 'payments']) // eager load relationships
            ->orderBy('created_at', 'desc') // show newest first
            ->paginate(5);
        return view('dashboard.customer.orders.index', compact('recentOrders'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
