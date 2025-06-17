<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleMarkController extends Controller
{
    public function toggleRead(Request $request, Article $article)
    {
        $user = Auth::user();
        $today = now()->startOfDay();

        // Check if user already marked the article
        $existing = $user->readArticles()->where('article_id', $article->id)->first();

        if ($existing) {
            $currentRead = $existing->pivot->read;
            $user->readArticles()->updateExistingPivot($article->id, ['read' => !$currentRead]);
        } else {
            // Count how many points the user has earned today via reading
            $pointsToday = $user->readArticles()
                    ->wherePivot('created_at', '>=', $today)
                    ->wherePivot('read', true)
                    ->count() * 5;

            if ($pointsToday < 15) {
                $user->readArticles()->attach($article->id, ['read' => true]);
                $user->points += 5;
                $user->save();
                return back()->with('points', 'Gained 5 points for reading');
            } else {
                $user->readArticles()->attach($article->id, ['read' => true]);
                // Do not add points since user hit the limit
            }
        }

        return back()->with('status', 'Toggled read status');
    }

    public function toggleFavourite(Request $request, Article $article)
    {
        $user = Auth::user();

        // Check if user already liked the article
        $existing = $user->likedArticles()->where('article_id', $article->id)->first();

        if ($existing) {
            $currentRead = $existing->pivot->favourite;
            $user->likedArticles()->updateExistingPivot($article->id, ['favourite' => !$currentRead]);
        } else {
            $user->likedArticles()->attach($article->id, ['favourite' => true]);
        }

        return back()->with('status', 'Toggled favourite status');
    }
}
