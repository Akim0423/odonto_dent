<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\Ajustes;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Solo si ya está creada la tabla y hay datos
        if (Schema::hasTable('ajustes') && Ajustes::find(1)) {
            $zona = Ajustes::find(1)->zona_horaria;

            // Cambia la zona horaria del sistema Laravel
            Config::set('app.timezone', $zona);
            date_default_timezone_set($zona); // para funciones nativas de PHP
        }
    }
}
