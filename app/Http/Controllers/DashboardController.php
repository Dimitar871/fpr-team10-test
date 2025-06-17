<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Goal;
use App\Models\Task;
use App\Services\QuoteService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $quoteService;

    // Inject the QuoteService into the controller
    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }

    public function index()
    {
        $user = auth()->user();
        $earnedPointsToday = 0;
        $articles = Article::latest()->take(3)->get();
        // get all goals for user
        $goals = Goal::where('user_id', $user->id)->latest()->take(3)->get();

        $tasks = Task::latest()->take(3)->get();

        // Fetch the daily quote
        $quote = $this->quoteService->getDailyQuote();

        if ($user) {
            // Get today's articles with readers
            $todaysArticles = Article::with('readers')
                ->whereDate('created_at', Carbon::today())
                ->get();

            // Filter articles read today by this user
            $readToday = $todaysArticles->filter(function ($article) use ($user) {
                $pivot = $article->readers->find($user->id)?->pivot;
                return $pivot && $pivot->read && $pivot->updated_at && $pivot->updated_at->isToday();
            });

            // Cap at 15 points max
            $earnedPointsToday = min($readToday->count(), 3) * 5;
        }

        return view('dashboard.index', compact('articles', 'quote', 'goals', 'tasks', 'earnedPointsToday'));
    }
}
