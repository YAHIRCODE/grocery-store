<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Verificar stock bajo todos los días a las 8:00 AM
Schedule::command('stock:check-low')
    ->everyMinute() // cambia  a las 10:00 PM para tu prueba de hoy
    ->appendOutputTo(storage_path('logs/inventory_schedule.log')); // Guarda un registro de que se ejecutó

// (Opcional para tu prueba de hoy) 
// Puedes ponerlo cada minuto para ver que Mailtrap se llena solo:
// Schedule::command('stock:check-low')->everyMinute();