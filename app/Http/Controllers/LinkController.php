<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LinkController extends Controller
{
    public function index()
    {
        $links = Auth::user()->links;
        $categories = Auth::user()->categories;

        return view('links.index',[
            'links' => $links,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('links.create');
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
            'site' => 'required|max:255',
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
