<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['seat_id', 'user_id' ,'trip_id' ,'start_city_id' ,'end_city_id'];
    function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
