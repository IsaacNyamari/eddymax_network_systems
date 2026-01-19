<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $order;
    public $message;
    public function __construct($order)
    {
        $this->order = $order;
        $this->message = "You have a new order from, " . $order->user->name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $adminIds = User::role('admin')->pluck('id');
        $channels = [];

        foreach ($adminIds as $adminId) {
            $channels[] = new PrivateChannel('admin.orders.' . $adminId);
        }

        return $channels;
    }
    public function broadcastAs()
    {
        return 'new.order';
    }
}
