<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryItemRequest;
use App\Models\Inventory;
use App\Models\InventoryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class inventoryItemController extends Controller
{
    private static RedirectResponse $redirect;
    private static string $redirectKey = 'invMessage';

    public function __construct()
    {
        self::$redirect = back();
    }

    private function redirectWith(string $message, ?string $key = null) : RedirectResponse
    {
        $key = $key ?? self::$redirectKey;
        return self::$redirect->with($key, $message);
    }

    /**
     * Check that this `item(link)` and this `inventory` is belong to the current Auth user. And reply with `404 Not Found` if the `link(item)` or `inventory` or both not found or aren't belong the user
     * @param InventoryItemRequest $validatedRequest the validated data from the InventoryItemRequest
     * @return array the related `link` and `inventory`
     */
    private function ensureUserOwns(InventoryItemRequest $validatedRequest) : array
    {
        $authUser = Auth::user();

        $link = $authUser->links()->findOrFail($validatedRequest->item);
        $inventory = $authUser->inventories()->findOrFail($validatedRequest->inventory);

        return [$link, $inventory];
    }

    public function store(InventoryItemRequest $request){
        [$link, $inventory] = $this->ensureUserOwns($request);

        $item = InventoryItem::firstOrCreate([
            'link_id' => $link->id,
            'inventory_id' => $inventory->id,
        ]);

        if (! $item->wasRecentlyCreated) {
            return $this->redirectWith('This item is already at this inventory');
        }

        return $this->redirectWith('Item stored successfully');
    }

    public function destroy(InventoryItemRequest $request){

        [$link, $inventory] = $this->ensureUserOwns($request);

        $deleted = InventoryItem::where('link_id', $link->id)
        ->where('inventory_id', $inventory->id)
        ->delete();

        if(!$deleted){
            return $this->redirectWith('There is a problem at deleting');
        }

        $name = Inventory::where('id',$inventory->id)->first()->name;

        return $this->redirectWith("Item removed from $name successfully");
    }
}
