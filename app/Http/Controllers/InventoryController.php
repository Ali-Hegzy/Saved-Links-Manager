<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventories = Inventory::whereLike('name',"%$request->search%",false)->where('user_id',Auth::id())->get();

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
    public function store(InventoryRequest $request)
    {
        Inventory::create([
            'user_id' => Auth::id(),
            ...$request->only('name', 'description'),
        ]);

        return redirect('/inventories')->with('inventory.store', 'Inventory Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        Gate::authorize('view',$inventory);

        $inventories = Auth::user()->inventories;
        $items = $inventory->items;
        $ids = [];

        foreach($items as $item){
            $ids[] = $item->link_id;
        }

        $links = Link::whereIn('id',$ids)->get();

        return view('Inventory.show',[
            "inventory" => $inventory,
            "items" => $links,
            "inventories" => $inventories,
        ]);
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
    public function update(InventoryRequest $request, Inventory $inventory)
    {
        Gate::authorize('update',$inventory);

        $inventory->update([
            ...$request->only(['name','description']),
        ]);

        return redirect('/inventories')->with('inventory.update', 'Inventory Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        Gate::authorize('delete',$inventory);

        $inventory::destroy($inventory->id);

        return redirect(route('inventories.index'))->with('inventory.destroy', 'Inventory Deleted Successfully');
    }
}
