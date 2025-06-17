<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    public function __construct()
{
   $this->middleware('auth');
}

    public function index(Request $request)
    {
       $query = DiaryEntry::where('user_id', auth()->id());


    if ($request->filled('mood')) {
        $query->where('mood', $request->mood);
    }

    if ($request->filled('energy')) {
        $query->where('energy', $request->energy);
    }

    if ($request->filled('stress')) {
        $query->where('stress', $request->stress);
    }

    $entries = $query->orderBy('created_at', 'desc')->get();

    return view('diaries.index', [
        'entries' => $entries,
        'filters' => $request->only(['mood', 'energy', 'stress']),
    ]);
    }
    public function create()
    {
        return view('diaries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entry_date' => 'required|date',
            'mood' => 'required|in:Poor,Below Average,Average,Good,Excellent',
            'energy' => 'required|in:Poor,Below Average,Average,Good,Excellent',
            'stress' => 'required|in:Poor,Below Average,Average,Good,Excellent',
            'highlights' => 'required|string',
            'challenges' => 'required|string',
            'gratitude' => 'required|string',
            'improvements' => 'required|string',
        ], [
            'highlights.required' => 'Highlight field is required',
            'challenges.required' => 'Challenges field is required',
            'gratitude.required' => 'Please type what are you grateful for today',
            'improvements.required' => 'Please type what you would like to improve in the future',
            'mood.required' => 'Please select your mood',
            'energy.required' => 'Please select your energy level',
            'stress.required' => 'Please select your stress level',
            'entry_date.required' => 'Entry date is required',
        ]);

        // Check if user already has an entry for that particuilar date
        if (DiaryEntry::hasEntryForDate(Auth::id(), $validated['entry_date'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['entry_date' => 'You\'ve already created an entry today.']);
        }

        // Add user_id to the validated data
        $validated['user_id'] = Auth::id();
        $validated['user_id'] = auth()->id();

        DiaryEntry::create($validated);

        return redirect()->route('diaries.index')
            ->with('success', 'Diary entry is successfully created!');
    }

    public function edit(DiaryEntry $diary)
    {
        // Check if the entry can be edited
        if (!$diary->canBeEdited()) {
            return redirect()->route('diaries.show', $diary)
                ->with('error', 'This entry cannot be edited as it is older than 24 hours.');
        }

        if ($diary->user_id !== auth()->id()) {
        abort(403);
    }
        return view('diaries.edit', compact('diary'));
    }

    public function update(Request $request, DiaryEntry $diary)
    {
// Checking if entry is allowed to be edited
        if (!$diary->canBeEdited()) {
            return redirect()->route('diaries.show', $diary)
                ->with('error', 'This entry can no longer be edited as it is older than 24 hours.');
        }

        if ($diary->user_id !== auth()->id()) {
        abort(403);
    }
        $validated = $request->validate([
            'mood' => 'required|in:Poor,Below Average,Average,Good,Excellent',
            'energy' => 'required|in:Poor,Below Average,Average,Good,Excellent',
            'stress' => 'required|in:Poor,Below Average,Average,Good,Excellent',
            'highlights' => 'required|string',
            'challenges' => 'required|string',
            'gratitude' => 'required|string',
            'improvements' => 'required|string',
        ], [
            'highlights.required' => 'Highlight field is required',
            'challenges.required' => 'Challenges field is required',
            'gratitude.required' => 'Please type what are you grateful for today',
            'improvements.required' => 'Please type what you would like to improve in the future',
            'mood.required' => 'Please select your mood',
            'energy.required' => 'Please select your energy level',
            'stress.required' => 'Please select your stress level',
        ]);

        $diary->update($validated);

        return redirect()->route('diaries.index')
            ->with('success', 'All set! Your diary entry\'s updated!');
    }

    public function show(DiaryEntry $diary)
    {
         if ($diary->user_id !== auth()->id()) {
        abort(403);  }
        return view('diaries.show', compact('diary'));
    }
}
