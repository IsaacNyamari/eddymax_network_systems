<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NotificationsWidget extends Component
{
    public $notifications = [];
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notifications-widget');
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = Notifications::findOrFail($notificationId);

        // Check if the notification belongs to the current user
        if (
            $notification->notifiable_id === $this->user->id &&
            $notification->notifiable_type === get_class($this->user)
        ) {
            $notification->read_at = now();
            $notification->update();

            // Re-fetch notifications after update
            $this->loadNotifications();
            $this->dispatch('update-notification-badge');
            // Dispatch browser event if needed
            $this->dispatch('notification-marked-read');
        }
    }

    public function deleteNotification($notificationId)
    {
        $notification = Notifications::findOrFail($notificationId);

        // Check if the notification belongs to the current user
        if (
            $notification->notifiable_id === $this->user->id &&
            $notification->notifiable_type === get_class($this->user)
        ) {

            $notification->delete();

            // Re-fetch notifications after deletion
            $this->loadNotifications();
            $this->dispatch('update-notification-badge');
            // Show success message
            session()->flash('message', 'Notification deleted successfully.');
        }
    }

    public function markAllAsRead()
    {
        $this->user->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->loadNotifications();
        $this->dispatch('update-notification-badge');
        session()->flash('message', 'All notifications marked as read.');
    }
    #[On('update-notification-badge')]
    public function loadNotifications()
    {
        // Load unread notifications first, then read ones
        $this->notifications = $this->user->notifications()
            // ->whereNull('read_at')  // NULL values will come first when sorting DESC
            ->orderBy('read_at', 'asc')  // NULL values will come first when sorting DESC
            ->latest()                // Then by latest created
            ->take(5)
            ->get();
    }
}
