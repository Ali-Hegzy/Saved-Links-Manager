<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class inventoryItemController extends Controller
{
    public function store(Request $request){
        // Check first that this item and this inventory is belong to the Auth user.
        $link = $request->user()->links()->findOrFail($request->item);
        $inventory = $request->user()->inventories()->findOrFail($request->inventory);

        $redirect = back();
        $redirectKey = 'invMessage';

        $check = InventoryItem::where('link_id', $link->id)
        ->where('inventory_id', $inventory->id)
        ->get()
        ->isNotEmpty();

        if($check){
            return $redirect->with($redirectKey, 'This item is already at this inventory');
        }

        $inventoryItem = new InventoryItem();
        $inventoryItem->link_id = $link->id;
        $inventoryItem->inventory_id = $inventory->id;

        $inventoryItem->save();

        return $redirect->with($redirectKey, 'Item stored successfully');
    }

    public function destroy(Request $request){
        $link = $request->user()->links()->findOrFail($request->item);
        $inventory = $request->user()->inventories()->findOrFail($request->inventory);

        $redirect = back();
        $redirectKey = 'invMessage';

        $check = InventoryItem::where('link_id', $link->id)
        ->where('inventory_id', $inventory->id)
        ->get()
        ->isEmpty();

        if($check){
            return $redirect->with($redirectKey, 'There is a problem at deleting');
        }

        $id = InventoryItem::where('link_id', $link->id)
        ->where('inventory_id', $inventory->id)
        ->first()->id;

        $name = Inventory::where('id',$inventory->id)->first()->name;

        InventoryItem::destroy($id);

        return $redirect->with($redirectKey, "Item removed from $name successfully");
    }
}
