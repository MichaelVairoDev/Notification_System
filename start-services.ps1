# Iniciar el queue worker en una nueva ventana
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php artisan queue:work"

# Iniciar el scheduler en una nueva ventana
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php artisan schedule:work"

Write-Host "Servicios iniciados. Cierra esta ventana para detener los servicios."
pause
