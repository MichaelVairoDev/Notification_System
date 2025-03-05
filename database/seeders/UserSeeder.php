<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $notificationTypes = NotificationType::all();
        $now = now();

        // Crear algunas notificaciones leídas
        foreach ($notificationTypes as $type) {
            for ($i = 1; $i <= 3; $i++) {
                Notification::create([
                    'user_id' => $user->id,
                    'notification_type_id' => $type->id,
                    'title' => "Notificación {$i} de {$type->name}",
                    'content' => "Esta es una notificación de ejemplo tipo {$type->name}. Incluye contenido de muestra para mostrar cómo se verían las notificaciones en la interfaz.",
                    'created_at' => $now->copy()->subDays(rand(1, 30)),
                    'read_at' => $now->copy()->subDays(rand(1, 29)),
                ]);
            }
        }

        // Crear algunas notificaciones no leídas
        foreach ($notificationTypes as $type) {
            for ($i = 1; $i <= 2; $i++) {
                Notification::create([
                    'user_id' => $user->id,
                    'notification_type_id' => $type->id,
                    'title' => "Nueva notificación {$i} de {$type->name}",
                    'content' => "¡Esta es una notificación no leída de tipo {$type->name}! Requiere tu atención para ser marcada como leída.",
                    'created_at' => $now->copy()->subHours(rand(1, 24)),
                ]);
            }
        }

        // Crear algunas notificaciones programadas
        foreach ($notificationTypes as $type) {
            Notification::create([
                'user_id' => $user->id,
                'notification_type_id' => $type->id,
                'title' => "Notificación programada de {$type->name}",
                'content' => "Esta notificación está programada para ser mostrada en el futuro. Tipo: {$type->name}.",
                'created_at' => $now,
                'scheduled_for' => $now->copy()->addDays(rand(1, 7)),
            ]);
        }
    }
}
