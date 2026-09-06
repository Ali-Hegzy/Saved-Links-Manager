<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sites = Auth::user()->sites()->limit(5)->get();
        $linksCount = Auth::user()->links()->count();

        return view('profile',[
            'user' => $user,
            'sites' => $sites,
            'linksCount' => $linksCount,
        ]);
    }
}
