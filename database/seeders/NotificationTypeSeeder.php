<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Información General',
                'description' => 'Notificaciones informativas generales',
                'icon' => 'ℹ️',
                'color' => '#3498DB',
            ],
            [
                'name' => 'Alerta',
                'description' => 'Notificaciones que requieren atención inmediata',
                'icon' => '⚠️',
                'color' => '#E74C3C',
            ],
            [
                'name' => 'Éxito',
                'description' => 'Notificaciones de acciones completadas exitosamente',
                'icon' => '✅',
                'color' => '#27AE60',
            ],
            [
                'name' => 'Recordatorio',
                'description' => 'Recordatorios y notificaciones programadas',
                'icon' => '⏰',
                'color' => '#F1C40F',
            ],
            [
                'name' => 'Sistema',
                'description' => 'Notificaciones del sistema y mantenimiento',
                'icon' => '⚙️',
                'color' => '#95A5A6',
            ],
            [
                'name' => 'Actualización',
                'description' => 'Notificaciones sobre actualizaciones y cambios',
                'icon' => '🔄',
                'color' => '#8E44AD',
            ],
            [
                'name' => 'Mensaje',
                'description' => 'Notificaciones de mensajes y comunicaciones',
                'icon' => '💬',
                'color' => '#2980B9',
            ],
            [
                'name' => 'Evento',
                'description' => 'Notificaciones sobre eventos y actividades',
                'icon' => '📅',
                'color' => '#D35400',
            ],
        ];

        foreach ($types as $type) {
            NotificationType::create($type);
        }
    }
}
