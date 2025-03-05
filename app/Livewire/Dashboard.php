<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Notification;
use App\Models\NotificationType;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class Dashboard extends Component
{
    public $totalNotifications;
    public $unreadNotifications;
    public $notificationsByType;
    public $recentNotifications;
    public $notificationTrend;

    public function mount()
    {
        $this->loadStatistics();
    }

    #[On('notification-received')]
    public function handleNewNotification()
    {
        $this->loadStatistics();
        $this->dispatch('statisticsUpdated', [
            'trend' => $this->notificationTrend,
            'byType' => $this->notificationsByType
        ]);
    }

    #[On('notification-read')]
    public function handleNotificationRead()
    {
        $this->loadStatistics();
        $this->dispatch('statisticsUpdated', [
            'trend' => $this->notificationTrend,
            'byType' => $this->notificationsByType
        ]);
    }

    #[On('refresh-statistics')]
    public function refreshStatistics()
    {
        $this->loadStatistics();
        $this->dispatch('statisticsUpdated', [
            'trend' => $this->notificationTrend,
            'byType' => $this->notificationsByType
        ]);
    }

    public function loadStatistics()
    {
        // Total y no leídas
        $this->totalNotifications = auth()->user()->notifications()->count();
        $this->unreadNotifications = auth()->user()->notifications()->whereNull('read_at')->count();

        // Notificaciones por tipo
        $this->notificationsByType = NotificationType::select('notification_types.*')
            ->leftJoin('notifications', 'notification_types.id', '=', 'notifications.notification_type_id')
            ->where('notifications.user_id', auth()->id())
            ->groupBy('notification_types.id', 'notification_types.name', 'notification_types.icon', 'notification_types.color')
            ->selectRaw('COUNT(notifications.id) as count')
            ->get();

        // Notificaciones recientes
        $this->recentNotifications = auth()->user()
            ->notifications()
            ->with('type')
            ->latest()
            ->take(5)
            ->get();

        // Tendencia de notificaciones (últimos 7 días)
        $this->notificationTrend = auth()->user()
            ->notifications()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [now()->subDays(7), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count,
                ];
            });
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->with([
                'pollingInterval' => 30000 // 30 seconds
            ]);
    }
}
