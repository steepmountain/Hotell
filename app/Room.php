<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'roomId', 'hotelId'
    ];

    protected $primaryKey = 'roomId';
    public $timestamps = false;
}
