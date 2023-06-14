<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VariantController extends Controller
{
    public function index(): \Inertia\Response
    {
        $variants = Variant::all();

        return Inertia::render('variants/Variants', [
            "variants" => $variants
        ]);
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render('variants/AddVariant');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        Variant::create($request->validate([
            'name' => ['required'],
        ]));

        return to_route('variants');
    }

    public function edit(Variant $variant): \Inertia\Response
    {
        return Inertia::render('variants/EditVariant', [
            "variant" => $variant
        ]);
    }

    public function save(Variant $variant, Request $request): \Illuminate\Http\RedirectResponse
    {
        $variant->update($request->validate([
            'name' => ['required'],
        ]));

        return to_route('variants');
    }

    public function destroy(Variant $variant): \Illuminate\Http\RedirectResponse
    {
        $variant->delete();
        return to_route('variants');
    }
}
