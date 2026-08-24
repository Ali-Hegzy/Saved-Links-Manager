<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('Auth.register');
    }

    public function create(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create($validated);

        Auth::login($user);
        $category = new Category();
        $category->user_id = Auth::user()->id;
        $category->save();

        $request->session()->regenerate();

        return redirect('/');
    }
}
