<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function create(Request $request){
        $validated = $request->validate([
            'site' =>'required|max:50'
        ]);

        $site = new Site();
        $site->user_id = auth()->id();
        $site->name = $validated['site'];

        $site->save();

        return redirect('/profile');
    }
}
