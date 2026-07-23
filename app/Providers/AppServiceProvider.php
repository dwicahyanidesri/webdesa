<?php

namespace App\Providers;

use App\Models\ProfilDesa;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Header & footer di layouts.app butuh data profil desa (logo desa) di semua
        // halaman publik, bukan cuma Beranda, jadi disediakan lewat composer.
        View::composer('layouts.app', function ($view) {
            $view->with('profilGlobal', ProfilDesa::first());
        });
    }
}
