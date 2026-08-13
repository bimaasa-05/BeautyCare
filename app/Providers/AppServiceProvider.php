<?php

namespace App\Providers;

use App\Models\Pengaturan;
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
        view()->composer('*', function ($view) {
            static $pengaturan = null;

            if ($pengaturan === null) {
                $pengaturan = Pengaturan::first();
            }

            $view->with('pengaturan', $pengaturan);
        });
    }
}
