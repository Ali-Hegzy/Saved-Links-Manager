<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['name'];

    protected $guarded = ['id','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function links(){
        return $this->hasMany(Link::class);
    }
}
