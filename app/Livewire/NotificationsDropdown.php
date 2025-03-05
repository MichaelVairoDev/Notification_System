<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationsDropdown extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showDropdown = false;
    public $filter = 'all'; // 'all', 'unread', 'read'

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $query = Auth::user()->notifications()->with('type')->latest();

        $this->unreadCount = $query->whereNull('read_at')->count();

        // Aplicar filtros
        if ($this->filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($this->filter === 'read') {
            $query->whereNotNull('read_at');
        }

        $this->notifications = $query->take(5)->get();
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->loadNotifications();
    }

    #[On('notification-received')]
    public function handleNewNotification()
    {
        $this->showDropdown = true;
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->user_id === Auth::id()) {
            $notification->markAsRead();
            $this->loadNotifications();
            $this->dispatch('notification-read');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        $this->loadNotifications();
        $this->dispatch('notification-read');
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
        if ($this->showDropdown) {
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.notifications-dropdown');
    }
}
