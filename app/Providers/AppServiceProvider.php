<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

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
            URL::forceScheme('https');
        }

        // Prevent errors if DB is not migrated yet
        if (Schema::hasTable('users')) {
            try {
                View::composer('*', function ($view) {
                    $user = Auth::user();
                    $theme = $user?->equippedTheme();
                    $view->with([
                        'switchableUsers' => User::all(),
                        'activeTheme' => $theme,
                    ]);
                });
            } catch (\Exception $e) {
                // Log or ignore exception during view setup
            }
        }
    }
}
