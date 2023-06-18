<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        $users = User::all();
        

        return Inertia::render('users/Users', [
            'users' => $users
        ]);
    }
    public function create(): \Inertia\Response
    {
        return Inertia::render('users/addUser');
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $formFields["id"] = $request->id;
        $user = User::create($formFields);


        return to_route('users');
    }
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->delete();
        return to_route('users');
    }
}
