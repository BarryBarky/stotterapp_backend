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

        $level = Level::create($formFields);

        if (count($request->hints) >= 1) {
            foreach ($request->hints as $hint) {
                if ($hint["checked"]) {
                    $level->hints()->attach($hint["value"]);
                }
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

        $level->update($formFields);

        $level->hints()->detach();

        if (count($request->hints) >= 1) {
            foreach ($request->hints as $hint) {
                if ($hint["checked"]) {
                    $level->hints()->attach($hint["value"]);
                }
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
