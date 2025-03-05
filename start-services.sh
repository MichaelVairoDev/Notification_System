#!/bin/bash

# Iniciar el queue worker
php artisan queue:work &

# Iniciar el scheduler
php artisan schedule:work &

# Mantener el script ejecutándose
wait
