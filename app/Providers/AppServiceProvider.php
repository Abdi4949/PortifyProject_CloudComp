<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- JANGAN LUPA TAMBAHKAN INI

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
        // Paksa semua URL jadi HTTPS (Wajib buat Ngrok)
        if (config('app.env') !== 'local') {
             URL::forceScheme('https');
        }
        
        // Atau kalau mau simpel (hajar semua environment termasuk localhost):
        // URL::forceScheme('https'); 
        
        // TAPI SAYA SARANKAN PAKA I LOGIKA INI SAJA BIAR AMAN DI NGROK:
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https') {
            URL::forceScheme('https');
        }
    }
}