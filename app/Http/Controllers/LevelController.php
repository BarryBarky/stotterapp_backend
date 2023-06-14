<?php

namespace App\Http\Controllers;

use App\Models\Hint;
use App\Models\Level;
use App\Models\Variant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LevelController extends Controller
{
    public function index(): \Inertia\Response
    {
        $levels = Level::all();
        $levels->load('variant');

        return Inertia::render('levels/Levels', [
            'levels' => $levels
        ]);
    }

    public function create(): \Inertia\Response
    {
        $variants = Variant::all();
        $hints = Hint::all();

        return Inertia::render('levels/AddLevel', [
            'variants' => $variants,
            'hints' => $hints
        ]);
    }

    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => ['required'],
            'text' => ['required'],
            'time' => ['required'],
        ]);

        $formFields["variant_id"] = $request->variant_id;

        if ($request->hasFile('character')) {
            $formFields['character'] = $request->file('character')->store('levels', 'public');
        }

        $level = Level::create($formFields);

        //        connect the pets to the advertisement
        if (count($request->hints) >= 1) {
            foreach ($request->hints as $hint_id) {
                $level->hints()->attach($hint_id);
            }
        }

        return to_route('levels');
    }

    public function edit(Level $level): \Inertia\Response
    {
        $variants = Variant::all();
        $hints = Hint::all();
        $level->load('variant');
        $level->load('hints');
        return Inertia::render('levels/EditLevel', [
            "level" => $level,
            "variants" => $variants,
            "hints" => $hints
        ]);
    }

    public function save(Level $level, Request $request): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'title' => ['required'],
            'text' => ['required'],
            'time' => ['required'],
        ]);

        $formFields["variant_id"] = $request->variant_id;

        if ($request->hasFile('character')) {
            $formFields['character'] = $request->file('character')->store('levels', 'public');
        }

        $level->update($formFields);

        //        connect the pets to the advertisement
        if (count($request->hints) >= 1) {
            foreach ($request->hints as $hint_id) {
                $level->hints()->attach($hint_id);
            }
        }

        return to_route('levels');
    }

    public function destroy(Level $level): \Illuminate\Http\RedirectResponse
    {
        $level->delete();
        return to_route('levels');
    }
}
