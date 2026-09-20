<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        if(!empty($request->query())){
            $sites = array_keys($request->all());
            array_shift($sites);

            $links = Link::whereLike('title',"%$request->search%",false)->where('user_id',Auth::id());

            if(count($sites)){
                $links = $links->withWhereHas('site', function ($query) use ($sites) {
                    $query->whereIn('name', $sites);
                });
            }

            $links = $links->with('site')->paginate(5)->withQueryString();

        }else{
            $links = Auth::user()->links()->with('site')->paginate(5);
        }

        $sites = Auth::user()->sites;
        $inventories = Auth::user()->inventories;

        return view('links.index',[
            'links' => $links,
            'sites' => $sites,
            'inventories' => $inventories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sites = Auth::user()->sites;

        return view('links.create',['sites' => $sites]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkRequest $request)
    {
        $site_id = Auth::user()->sites()->where('name', $request->site)->first('id')->id;

        Link::create([
            'user_id' => Auth::id(),
            'site_id' => $site_id,
            ...$request->only('title', 'description', 'url', 'status'),
        ]);

        return redirect('/links')->with('link.store', 'Link Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        Gate::authorize('view',$link);

        return view('links.show',["link" => $link]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        Gate::authorize('view',$link);
        $sites = Auth::user()->sites;

        return view('links.edit',[
            "link" => $link,
            "sites" => $sites,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkRequest $request, Link $link)
    {
        Gate::authorize('update',$link);

        $site_id = Auth::user()->sites()->where('name', $request->site)->first('id')->id;

        $link->update([
            'site_id' => $site_id,
            ...$request->only('title', 'description', 'url', 'status'),
        ]);

        return redirect('/links')->with('link.update', 'Link Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        Gate::authorize('delete',$link);

        Link::destroy($link->id);

        return redirect('/links')->with('link.destroy', 'Link Deleted Successfully');
    }
}
