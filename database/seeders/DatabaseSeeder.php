<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            NotificationTypeSeeder::class, // Primero los tipos de notificaciones
            UserSeeder::class, // Luego el usuario demo con sus notificaciones
        ]);
    }
}
