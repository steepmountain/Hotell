<?php

namespace App;

class Hotel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservationId', 'roomId', 'personId', 'toDate', 'fromDate'
    ];
}
