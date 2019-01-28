<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservationId', 'roomId', 'personId', 'toDate', 'fromDate'
    ];

    protected $primaryKey = 'reservationId';
    public $timestamps = false;

    public function person() {
        return $this->belongsTo('App\Person', 'reservationId');
    }

    public function room() {
        return $this->belongsTo('App\Room', 'reservationId');
    }
}
