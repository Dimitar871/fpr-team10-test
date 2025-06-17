<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'all');

        // Get IDs of themes the user owns
        $ownedThemeIds = $user->themes->pluck('id')->toArray();

        // Filter themes based on the query parameter
        $themes = match ($filter) {
            'owned' => Theme::whereIn('id', $ownedThemeIds)->get(),
            'unowned' => Theme::whereNotIn('id', $ownedThemeIds)->get(),
            default => Theme::all(),
        };

        return view('shop.index', compact('themes', 'user', 'filter'));
    }

    public function buyTheme(Request $request, Theme $theme)
    {
        $user = Auth::user();

        // Check if user already owns the theme
        $alreadyOwned = $user->themes()->where('theme_id', $theme->id)->exists();

        if ($alreadyOwned) {
            return back()->with('success', 'You already own this theme.');
        }

        $cost = $theme->points;

        if ($user->points < $cost) {
            return back()->with('error', 'Not enough points to buy this theme.');
        }

        // Deduct points
        $user->points -= $cost;
        $user->save();

        // Attach theme with owned=true and equipped=false
        $user->themes()->attach($theme->id, [
            'owned' => true,
            'equipped' => false
        ]);

        return back()->with('success', 'Theme purchased successfully!');
    }
}
