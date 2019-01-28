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

    public function hotel() {
        return $this->belongsTo('App\Hotel', 'roomId');
    }

    public function reservations() {
        return $this->hasMany('App\Reservation', 'roomId');
    }
}
