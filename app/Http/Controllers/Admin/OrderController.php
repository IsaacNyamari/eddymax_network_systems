<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReturns;
use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recentOrders = Order::latest()->paginate(5);
        return view('dashboard.admin.orders.index', compact('recentOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function return()
    {
        $orders = OrderReturns::with(['order.user'])->get();
        return view('dashboard.admin.orders.returns', compact('orders'));
    }
    public function deliverOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $order->status = OrderStatus::DELIVERED->value;
        $order->update();
        return back()->with('status', "Order '$order_number' updated successfully!");
    }
    public function cancelOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $order->status = OrderStatus::CANCELLED->value;
        $order->update();
        return back()->with('status', "Order '$order_number' updated successfully!");
    }
    public function shipOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $order->status = OrderStatus::SHIPPED->value;
        $order->update();
        return back()->with('status', "Order '$order_number' updated successfully!");
    }
    public function processOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        $order->status = OrderStatus::PROCESSING->value;
        $order->update();
        return back()->with('status', "Order '$order_number' updated successfully!");
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
    public function show(string $number)
    {
        $order = Order::where('order_number', $number)->first();
        return view('dashboard.admin.orders.show', compact("order"));
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
