<?php

namespace App\Http\Controllers;

use App\Models\Hint;
use App\Models\Level;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HintController extends Controller
{
    public function index(): \Inertia\Response
    {
        $hints = Hint::all();

        return Inertia::render('hints/Hints', [
            "hints" => $hints
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('hints/AddHint');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'text' => ['required'],
        ]);

        if ($request->hasFile('audio')) {
            $formFields['audio'] = $request->file('audio')->store('hints', 'public');
        }
        Hint::create($formFields);

        return to_route('hints');
    }

    public function edit(Hint $hint): \Inertia\Response
    {
        return Inertia::render('hints/EditHint', [
            "hint" => $hint
        ]);
    }

    public function save(Hint $hint, Request $request): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'text' => ['required'],
        ]);

        if ($request->hasFile('audio')) {
            $formFields['audio'] = $request->file('audio')->store('hints', 'public');
        }

        $hint->update($formFields);

        return to_route('hints');
    }

    public function destroy(Hint $hint): \Illuminate\Http\RedirectResponse
    {
        $hint->delete();
        return to_route('hints');
    }
}
