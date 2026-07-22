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
        // Footer di layouts.app butuh data profil desa (alamat, telepon, jam pelayanan)
        // supaya isinya selalu sinkron dengan data yang diisi admin, bukan teks statis.
        View::composer('layouts.app', function ($view) {
            $view->with('footerProfil', ProfilDesa::first());
        });
    }
}
