<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personId', 'firstName', 'lastName', 'phone', 'email'
    ];

    protected $table = 'people';
    protected $primaryKey = 'personId';
    public $timestamps = false;

    public function reservations() {
        return $this->hasMany('App\Reservation', 'personId');
    }
}
