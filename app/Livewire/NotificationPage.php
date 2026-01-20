<?php

namespace App\Livewire;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationPage extends Component
{
    use WithPagination;
    public $notifications = [];
    public $user;
    public function mount()
    {
        $this->user = Auth::user();
        $this->loadNotifications();
    }
    public function render()
    {
        return view('livewire.notification-page');
    }
    #[On('update-notification-badge')]
    public function loadNotifications()
    {
        $this->notifications = $this->user->notifications()
            // ->whereNull('read_at')  // NULL values will come first when sorting DESC
            ->orderBy('read_at', 'asc')  // NULL values will come first when sorting DESC
            ->latest()
            ->get();
    }
    public function markNotificationAsRead($notificationId)
    {
        $notification = $this->user->notifications()->where('id', $notificationId)->first();
        $notification->read_at = now();
        $notification->save();
        $this->loadNotifications();
        $this->dispatch('update-notification-badge');
    }
    public function deleteNotification($notificationId)
    {
        $notification = $this->user->notifications()->where('id', $notificationId)->first();
        $notification->delete();
        $this->dispatch('update-notification-badge');
        $this->loadNotifications();
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
}
