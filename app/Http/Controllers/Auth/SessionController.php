<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(){
        return view('Auth.login');
    }

    public function create(LoginRequest $request){
        $validated = $request->validated();

        if(! Auth::attempt($validated)){
            return back()
                ->withErrors(['password' => 'Email or password is incorrect.'])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function destroy(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
