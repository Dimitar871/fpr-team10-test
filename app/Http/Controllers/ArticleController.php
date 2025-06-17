<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::query();
        $sort = $request->get('sort', 'newest');
        $selectedLabels = $request->get('labels', []);
        $search = $request->get('search', '');

        // Apply search if search term is provided
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Apply label filters if any are selected
        if (!empty($selectedLabels)) {
            foreach ($selectedLabels as $labelId) {
                $query->whereHas('labels', function ($q) use ($labelId) {
                    $q->where('labels.id', $labelId);
                });
            }
        }

        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'a-z':
                $query->orderBy('title', 'asc');
                break;
            case 'z-a':
                $query->orderBy('title', 'desc');
                break;
            case 'most_reads':
                $query->withCount(['readers as read_count' => function($q) {
                    $q->where('read', true);
                }])->orderBy('read_count', 'desc');
                break;
            case 'least_reads':
                $query->withCount(['readers as read_count' => function($q) {
                    $q->where('read', true);
                }])->orderBy('read_count', 'asc');
                break;
            case 'favourites':
                if (Auth::check()) {
                    $query->withCount(['likers as is_favourite' => function($q) {
                        $q->where('user_id', Auth::id())
                          ->where('favourite', true);
                    }])
                    ->orderBy('is_favourite', 'desc')
                    ->orderBy('created_at', 'desc');
                } else {
                    $query->orderBy('created_at', 'desc');
                }
                break;
            default: // 'newest'
                $query->orderBy('created_at', 'desc');
                break;
        }

        $articles = $query->get();
        $labels = Label::all();
        return view('articles.index', compact('articles', 'sort', 'labels', 'selectedLabels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->name !== 'HR member') {
            abort(403, 'Unauthorized access');
        }

        $labels = Label::all();
        return view('articles.create', compact('labels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // First run the basic validation
        $request->validate([
            'title' => 'required|string|max:50|unique:articles,title',
            'excerpt' => 'required',
            'content' => 'required',
            'author' => 'required|string|max:30',
            'labels' => 'required_without:other_label|array',
            'labels.*' => 'exists:labels,id',
            'other_label' => 'nullable|required_without:labels|string|max:50',
        ], [
            'labels.required_without' => 'Please select at least one label or enter a custom label.',
            'other_label.required_without' => 'Please enter a custom label or select a label.',
        ]);

        // Custom manual check for duplicate label name
        if ($request->filled('other_label')) {
            $name = trim($request->input('other_label'));

            $exists = Label::whereRaw('LOWER(name) = ?', [strtolower($name)])->exists();

            if ($exists) {
                return back()
                    ->withErrors(['other_label' => 'The label "' . e($name) . '" already exists. Please select it from the list.'])
                    ->withInput();
            }
        }

        $data = $request->only(['title', 'excerpt', 'content', 'author']);
        $article = Article::create($data);

        $labelIds = $request->input('labels', []);

        if ($request->filled('other_label')) {
            $newLabel = Label::create(['name' => $name]);
            $labelIds[] = $newLabel->id;
        }

        $article->labels()->attach($labelIds);

        return redirect()->route('articles.index')
            ->with('success', 'Article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load('labels');
        $next = Article::where('id', '>', $article->id)->orderBy('id')->first();
        $previous = Article::where('id', '<', $article->id)->orderBy('id', 'desc')->first();

        if (!$previous) {
            $previous = Article::orderBy('id', 'desc')->first();
        }

        if (!$next) {
            $next = Article::orderBy('id')->first();
        }
        return view('articles.show', compact('article', 'next', 'previous'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if (auth()->user()->name !== 'HR member') {
            abort(403, 'Unauthorized access');
        }

        $labels = Label::all();
        return view('articles.edit', [
            'article' => $article,
            'labels' => $labels,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:50|unique:articles,title,' . $article->id,
            'excerpt' => 'required',
            'content' => 'required',
            'author' => 'required|string|max:30',
            'labels' => 'required_without:other_label|array',
            'labels.*' => 'exists:labels,id',
            'other_label' => 'nullable|required_without:labels|string|max:50',
        ], [
            'labels.required_without' => 'Please select at least one label or enter a custom label.',
            'other_label.required_without' => 'Please enter a custom label or select a label.',
        ]);

        // Custom manual check for duplicate label name
        if ($request->filled('other_label')) {
            $name = trim($request->input('other_label'));

            $exists = Label::whereRaw('LOWER(name) = ?', [strtolower($name)])->exists();

            if ($exists) {
                return back()
                    ->withErrors(['other_label' => 'The label "' . e($name) . '" already exists. Please select it from the list.'])
                    ->withInput();
            }
        }

        $data = $request->only(['title', 'excerpt', 'content', 'author']);
        $article->update($data);

        $labelIds = $request->input('labels', []);

        if ($request->filled('other_label')) {
            $newLabel = Label::create(['name' => $name]);
            $labelIds[] = $newLabel->id;
        }

        $article->labels()->sync($labelIds);

        return redirect()->route('articles.show', $article)
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
