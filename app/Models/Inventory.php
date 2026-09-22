<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id' ,'name', 'description'])]
#[Guarded(['id', 'created_at', 'updated_at'])]
class Inventory extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function items(){
        return $this->hasMany(InventoryItem::class);
    }
}
