<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function equip(Request $request, $themeId)
    {
        $user = Auth::user();

        // Ensure the user owns this theme
        $owned = $user->ownedThemes()->where('themes.id', $themeId)->first();

        if (!$owned) {
            return response()->json(['error' => 'Theme not owned by user.'], 403);
        }

        // Unequip all themes
        $user->themes()->updateExistingPivot($user->themes->pluck('id'), ['equipped' => false]);

        // Equip the selected theme
        $user->themes()->updateExistingPivot($owned->id, ['equipped' => true]);

        // Return full theme data to update frontend dynamically
        return response()->json([
            'success' => true,
            'themeId' => $owned->id,
            'title' => $owned->title,
            'main_color' => $owned->main_color,
            'sub_color' => $owned->sub_color,
            'accent_color' => $owned->accent_color,
            'edit_color' => $owned->edit_color,
            'delete_color' => $owned->delete_color,
            'create_color' => $owned->create_color,
            'background_color' => $owned->background_color,
            'extra_color' => $owned->extra_color,
            'text_color' => $owned->text_color,
        ]);
    }
}
