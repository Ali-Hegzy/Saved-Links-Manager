<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    public function invetory(){
        $this->belongsTo(Inventory::class);
    }
}
