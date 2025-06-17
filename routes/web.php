<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleMarkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\EnsureUserIsEmployee;
 use Illuminate\Support\Facades\Artisan;
// Guest: Show login
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

// Guest: Handle login form submission
Route::post('/login', function (Request $request) {
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'access_code' => 'required',
    ]);

    $ACCESS_CODE = 'team10';

    if ($request->access_code !== $ACCESS_CODE) {
        return redirect()->back()->with('error', 'Invalid access code');
    }

    Auth::loginUsingId($request->input('user_id'));
    return redirect('/');
})->name('login.submit');

// Authenticated: Switch user
Route::post('/switch-user', function (Request $request) {
    $userId = $request->input('user_id');

    if (Auth::id() !== (int) $userId && User::find($userId)) {
        Auth::logout();
        Auth::loginUsingId($userId);
    }

    return redirect('/');
})->name('switch-user');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
  
    Route::view('/support/404', 'errors.404-help');

    Route::resource('articles', ArticleController::class);
    Route::resource('goals', GoalController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('settings', SettingsController::class);
    Route::resource('shop', ShopController::class);

    // Diaries for employees only
    Route::middleware([EnsureUserIsEmployee::class])->group(function () {
        Route::resource('diaries', DiaryController::class);
    });
   

Route::get('/run-migrations', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migrations ran successfully!';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});


    // Task-specific routes
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::get('/tasks/{task}/confirm-delete', [TaskController::class, 'confirmDelete'])->name('tasks.confirm-delete');

    // Article marks
    Route::post('/articles/{article}/toggle-read', [ArticleMarkController::class, 'toggleRead'])->name('articles.toggleRead');
    Route::post('/articles/{article}/toggle-favourite', [ArticleMarkController::class, 'toggleFavourite'])->name('articles.toggleFavourite');

    // Labels
    Route::patch('/labels/{label}', [LabelController::class, 'update'])->name('labels.update');
    Route::delete('/labels/{label}', [LabelController::class, 'destroy'])->name('labels.destroy');

    // Themes & Shop
    Route::post('/theme/equip/{themeId}', [ThemeController::class, 'equip'])->name('theme.equip');
    Route::post('/shop/buy-theme/{theme}', [ShopController::class, 'buyTheme'])->name('shop.buyTheme');
});
