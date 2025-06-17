<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function update(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = trim($validated['name']);

        // Case-insensitive uniqueness check, ignoring current label
        $exists = Label::whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->where('id', '!=', $label->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'error' => 'The label "' . e($name) . '" already exists. Please choose a different name.'
            ], 422);
        }

        $label->name = $name;
        $label->save();

        return response()->json(['name' => $label->name]);
    }

    public function destroy(Label $label)
    {
        $label->delete();

        // For normal form submission
        return redirect()->back()->with('success', 'Label deleted successfully.');
    }
}
