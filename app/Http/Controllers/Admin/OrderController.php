<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderUpdate;
use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use App\Models\OrderReturns;
use App\OrderStatus;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public $sms;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->sms = new SmsService();
    }
    public function index()
    {
        $recentOrders = Order::latest()->with('payments')->paginate(5);
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
    public function showReturn(string $order)
    {
        $return = OrderReturns::with(['images', 'order'])
            ->findOrFail($order);;
        return view('dashboard.admin.returns.show', compact('return'));
    }
    public function markOrderReturnCancelled(OrderReturns $order)
    {
        return $order;
    }
    /**
     * Deliver an order
     */
    public function deliverOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $order->status = OrderStatus::DELIVERED->value;
        $order->save();

        Mail::to($order->user->email)
            ->send(new OrderStatusUpdated($order, 'DELIVERED', 'Order Delivered'));
        $userName = $order->user->name;
        $userPhone = $order->user->addresses->first()->phone;
        $smsMessage = "Hi $userName, your order: #$order_number has been delivered.\n Track your order at:" . route('customer.orders.show', $order_number);
        $eventMessage = "Hi $userName, your order: #$order_number has been delivered.";
        // broadcast(new OrderUpdate($order, $eventMessage));
        $order->user->notifications()->create([
            "type" => "order",
            'message' => $eventMessage,
        ]);
        $this->sms->send($userPhone, $smsMessage);
        return back()->with('success', "Order #{$order_number} marked as delivered! Email sent to customer.");
    }

    /**
     * Ship an order
     */
    public function shipOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $order->status = OrderStatus::SHIPPED->value;
        $order->save();
        $userName = $order->user->name;
        $userPhone = $order->user->addresses->first()->phone;
        $smsMessage = "Hi $userName, your order: #$order_number has been shipped.\n Track your order at:" . route('customer.orders.show', $order_number);
        $this->sms->send($userPhone, $smsMessage);
        $eventMessage = "Hi $userName, your order: #$order_number has been shipped.";
        // broadcast(new OrderUpdate($order, $eventMessage));
        $order->user->notifications()->create([
            "type" => "order",
            'message' => $eventMessage,
        ]);
        Mail::to($order->user->email)
            ->send(new OrderStatusUpdated($order, 'SHIPPED', 'Order Shipped'));
        return back()->with('success', "Order #{$order_number} marked as shipped! Email sent to customer.");
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $order->status = OrderStatus::CANCELLED->value;
        $order->save();

        Mail::to($order->user->email)
            ->send(new OrderStatusUpdated($order, 'CANCELLED', 'Order Cancelled'));
        return back()->with('success', "Order #{$order_number} cancelled! Email sent to customer.");
    }

    /**
     * Start processing an order
     */
    public function processOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $order->status = OrderStatus::PROCESSING->value;
        $order->save();
        $smsMessage = "Hi " . $order->user->name . ", your order: #$order_number is being processed.\n Track your order at:" . route('customer.orders.show', $order_number);
        Mail::to($order->user->email)
        ->send(new OrderStatusUpdated($order, 'PROCESSING', 'Order Processing Started'));
        $eventMessage = "Hi " . $order->user->name . ", your order: #$order_number is now processing!";
        // broadcast(new OrderUpdate($order, $eventMessage));
        $order->user->notifications()->create([
            "type" => "order",
            'message' => $eventMessage,
        ]);
        return back()->with('success', "Order #{$order_number} is now processing! Email sent to customer.");
    }

    /**
     * Mark order as pending
     */
    public function pendingOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $order->status = OrderStatus::PENDING->value;
        $order->save();

        Mail::to($order->user->email)
            ->send(new OrderStatusUpdated($order, 'PENDING', 'Order Marked as Pending'));
        $eventMessage = "Hi " . $order->user->name . ", your order: #$order_number is pending!.";
        $order->user->notifications()->create([
            "type" => "order",
            'message' => $eventMessage,
        ]);
        // broadcast(new OrderUpdate($order, $eventMessage));
        return back()->with('success', "Order #{$order_number} marked as pending! Email sent to customer.");
    }

    /**
     * Mark order as confirmed
     */
    // public function confirmOrder(string $order_number)
    // {
    //     $order = Order::where('order_number', $order_number)->firstOrFail();

    //     $order->status = OrderStatus::CONFIRMED->value;
    //     $order->save();

    // Mail::to($order->user->email)
    // ->send(new OrderStatusUpdated($order, 'CONFIRMED', 'Order Confirmed'));

    //     return back()->with('success', "Order #{$order_number} confirmed! Email sent to customer.");
    // }

    // /**
    //  * Mark order as ready for pickup
    //  */
    // public function readyForPickupOrder(string $order_number)
    // {
    //     $order = Order::where('order_number', $order_number)->firstOrFail();

    //     $order->status = OrderStatus::READY_FOR_PICKUP->value;
    //     $order->save();

    // Mail::to($order->user->email)
    // ->send(new OrderStatusUpdated($order, 'READY FOR PICKUP', 'Order Ready for Pickup'));

    //     return back()->with('success', "Order #{$order_number} ready for pickup! Email sent to customer.");
    // }

    /**
     * Mark order as returned
     */
    public function returnOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $order->status = OrderStatus::RETURNED->value;
        $order->save();

        Mail::to($order->user->email)
            ->send(new OrderStatusUpdated($order, 'RETURNED', 'Order Returned'));
        $userName = $order->user->name;
        $userPhone = $order->user->addresses->first()->phone;
        $smsMessage = "Hi $userName, your order: #$order_number has been returned.\n Track your order at:" . route('customer.orders.show', $order_number);
        $this->sms->send($userPhone, $smsMessage);
        $eventMessage = "Hi " . $order->user->name . ", your order: #$order_number has been returned.";
        $order->user->notifications()->create([
            "type" => "order",
            'message' => $eventMessage,
        ]);
        // broadcast(new OrderUpdate($order, $eventMessage));
        return back()->with('success', "Order #{$order_number} marked as returned! Email sent to customer.");
    }

    /**
     * Mark order as refunded
     */
    // public function refundOrder(string $order_number)
    // {
    //     $order = Order::where('order_number', $order_number)->firstOrFail();

    //     $order->status = OrderStatus::REFUNDED->value;
    //     $order->save();

    // Mail::to($order->user->email)
    // ->send(new OrderStatusUpdated($order, 'REFUNDED', 'Order Refunded'));

    //     return back()->with('success', "Order #{$order_number} refunded! Email sent to customer.");
    // }

    // /**
    //  * Mark order as on hold
    //  */
    // public function holdOrder(string $order_number)
    // {
    //     $order = Order::where('order_number', $order_number)->firstOrFail();

    //     $order->status = OrderStatus::ON_HOLD->value;
    //     $order->save();

    // Mail::to($order->user->email)
    // ->send(new OrderStatusUpdated($order, 'ON HOLD', 'Order Placed on Hold'));

    //     return back()->with('success', "Order #{$order_number} placed on hold! Email sent to customer.");
    // }

    // /**
    //  * Mark order as failed
    //  */
    // public function deleteReturnOrder(OrderReturns $order)
    // {
    //     return $order;
    // }
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
