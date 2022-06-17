<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $hidden = [ 'created_at' , "updated_at"];

    function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
