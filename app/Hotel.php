<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotelId', 'name', 'city', 'numRooms', 'price'
    ];

    protected $primaryKey = 'hotelId';
    public $timestamps = false;

    public function rooms() {
        return $this->hasMany('App\Room', 'hotelId');
    }
}
