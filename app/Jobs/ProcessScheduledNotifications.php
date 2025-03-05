<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessScheduledNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        try {
            $notifications = Notification::query()
                ->whereNotNull('scheduled_for')
                ->whereNull('read_at')
                ->where('scheduled_for', '<=', now())
                ->get();

            foreach ($notifications as $notification) {
                // Marcar la notificación como enviada
                $notification->update(['scheduled_for' => null]);

                // Aquí podrías añadir lógica adicional como enviar un email
                // o una notificación push al usuario

                Log::info('Notificación programada procesada', [
                    'notification_id' => $notification->id,
                    'user_id' => $notification->user_id,
                    'title' => $notification->title
                ]);

                // Emitir evento para actualizar la interfaz en tiempo real
                event(new \App\Events\NotificationSent($notification));
            }
        } catch (\Exception $e) {
            Log::error('Error procesando notificaciones programadas: ' . $e->getMessage());
        }
    }
}
