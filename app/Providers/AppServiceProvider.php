<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;



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
    if (app()->environment('production')) {
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }

    // Skip this logic if database connection is SQLite and file does not exist
    try {
        if (\Schema::hasTable('users')) {
            \View::composer('*', function ($view) {
                $user = \Auth::user();
                $theme = $user?->equippedTheme();
                $view->with([
                    'switchableUsers' => \App\Models\User::all(),
                    'activeTheme' => $theme,
                ]);
            });
        }
    } catch (\Throwable $e) {
        // Silently fail during build (no DB yet)
    }
}

}
