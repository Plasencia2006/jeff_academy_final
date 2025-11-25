<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Compartir configuración de contacto con todas las vistas
        view()->composer('*', function ($view) {
            $config = \App\Models\ConfiguracionContacto::obtener();
            $view->with('config', $config);
        });


         // Forzar HTTPS en producción (Railway)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}