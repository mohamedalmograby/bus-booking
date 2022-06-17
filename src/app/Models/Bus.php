<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $hidden = [ 'created_at' , "updated_at"];

    function trip()
    {
        return $this->belongsTo(Trip::class);
    }
    function seats(){
        return $this->hasMany(Seat::class);
    }
}
