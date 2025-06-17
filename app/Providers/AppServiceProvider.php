<?php

namespace App\Providers;

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
        if (Schema::hasTable('users')) {
    View::composer('*', function ($view) {
        $user = Auth::user();
        $theme = $user?->equippedTheme();
        $view->with([
            'switchableUsers' => User::all(),
            'activeTheme' => $theme,
        ]);
    });
}
    }
}
