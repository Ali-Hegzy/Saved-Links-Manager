<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['link_id', 'inventory_id'])]
class InventoryItem extends Model
{
    public function inventory(){
        $this->belongsTo(Inventory::class);
    }
}
