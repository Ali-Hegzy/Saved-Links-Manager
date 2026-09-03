<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Auth::user()->inventories;

        return view('Inventory.index', [
            "inventories" => $inventories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $inventory = new Inventory();
        $inventory->user_id = auth()->id();
        $inventory->name = $validation['name'];
        $inventory->description = $validation['description'];

        $inventory->save();

        return redirect('/inventories');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        Gate::authorize('view',$inventory);

        return view('Inventory.show',["inventory" => $inventory]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        Gate::authorize('view',$inventory);

        return view('Inventory.edit',["inventory" => $inventory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        Gate::authorize('update',$inventory);

        $validation = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        $inventory->name = $validation['name'];
        $inventory->description = $validation['description'];
        $inventory->save();

        return redirect('/inventories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        Gate::authorize('delete',$inventory);

        $inventory::destroy($inventory->id);

        return redirect(route('inventories.index'));
    }
}
