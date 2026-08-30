<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class LinkController extends Controller
{
    public function index(Request $request)
    {
        if(!empty($request->query())){
            $sites = array_keys($request->all());
            array_shift($sites);

            $links = Link::whereLike('title',"%$request->search%",false)->where('user_id',Auth::id());

            if(count($sites)){
                $links = $links->whereIn('site',$sites);
            }

            $links = $links->get();

        }else{
            $links = Auth::user()->links;
        }

        $sites = Auth::user()->sites;

        return view('links.index',[
            'links' => $links,
            'sites' => $sites,
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
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|min:8|max:255',
            'description' => 'required|min:8',
            'url' => 'required|url',
            'site' => ['required', Rule::exists('sites','name')->where(function ($query){
                $query->where('user_id', auth()->id());
            })],
            'status' => 'boolean'
        ]);

        $link = new Link();
        $link->user_id = Auth::user()->id;
        $link->title = $validate['title'];
        $link->description = $validate['description'];
        $link->url = $validate['url'];
        $link->site = $validate['site'];
        $link->status = $validate['status'];

        $link->save();

        return redirect('/links');
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

        return view('links.edit',["link" => $link]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        Gate::authorize('update',$link);

        $link->title = $request->title;
        $link->description = $request->description;
        $link->url = $request->url;
        $link->site = $request->site;
        $link->status = $request->status;
        $link->save();

        return redirect('/links');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        //
    }
}
