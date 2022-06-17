<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $hidden = ['pivot'];

    use HasFactory;
    function trips()
    {
        return $this->belongsToMany(Trip::class);
    }
}
