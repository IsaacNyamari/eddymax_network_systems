<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The login user data
     */
    public $user;
    public $message;
    public $loginData;

    /**
     * Create a new event instance.
     */
    public function __construct(User $loggedInUser, $message = '')
    {
        $this->user = $loggedInUser;
        $this->message = $message ?: $loggedInUser->name . ' has logged in.';
        $this->loginData = [
            'user_id' => $loggedInUser->id,
            'user_name' => $loggedInUser->name,
            'user_email' => $loggedInUser->email,
            'login_time' => now()->toDateTimeString(),
            'ip_address' => request()->ip(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('admin.notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'user.login';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'login_data' => $this->loginData,
            'timestamp' => now()->toDateTimeString(),
        ];
    }
}