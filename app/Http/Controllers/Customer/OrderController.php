<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReturns;
use App\Models\ReturnImages;
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
            ->with(['items', 'payments', 'orderReturns']) // eager load relationships
            ->orderBy('created_at', 'desc') // show newest first
            ->paginate(5);
        return view('dashboard.customer.orders.index', compact('recentOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function return()
    {
        $orders = OrderReturns::with('order')
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();
        return view('dashboard.customer.orders.returns', compact('orders'));
    }
    public function cancel(Request $request, Order $order)
    {
        $data = $request->validate([
            'reason' => 'required|min:20',
            'proof_image' => 'required',
        ]);
        $data['order_id'] = $order->id;

        $request_exists = OrderReturns::where('order_id', $data['order_id'])->get()->count();
        if ($request_exists > 0) {
            return back()->with('error', 'Your ' . $request['type'] . ' request exists for this order.');
        }
        // ReturnImages::create();
        $order_return = OrderReturns::create($data);

        foreach ($data['proof_image'] as $image) {
            $image_path = $image->store('proofs', 'public');
            $order_return->images()->create([
                'path' => $image_path
            ]);
        }
        return back()->with('success', 'Your order ' . $request['type'] . ' request has been made successfully! Awaits confirmation.');
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
