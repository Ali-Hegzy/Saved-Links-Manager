<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SiteController extends Controller
{
    public function index(Request $request){
        $sites = Site::whereLike('name',"%$request->search%",false)->where('user_id',Auth::id())->get();

        return view('sites.index',[
            'sites' => $sites,
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' =>'required|max:50'
        ]);

        $site = new Site();
        $site->user_id = auth()->id();
        $site->name = $validated['name'];

        $site->save();

        return redirect('/sites')->with('site.store', 'Site Created Successfully');
    }

    public function edit(Site $site){
        Gate::authorize('view',$site);
        return view('sites.edit',[
            'site' => $site,
        ]);
    }

    public function update(Request $request, Site $site){
        Gate::authorize('update',$site);

        $validation = $request->validate([
            'name' => 'required|max:50',
        ]);

        $old = $site->name;
        $site->name = $validation['name'];
        $site->save();

        Link::where('site',$old)->where('user_id',Auth::id())->update(['site' => $validation['name']]);

        return redirect('/sites')->with('site.update', 'Site Updated Successfully');
    }

    public function destroy(Site $site){
        Gate::authorize('delete',$site);
        Site::destroy($site->id);

        return redirect('/sites')->with('site.destroy', 'Site deleted Successfully');
    }
}
