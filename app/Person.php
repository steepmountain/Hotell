<?php

namespace App;

class Person
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstName', 'lastName', 'phone', 'email'
    ];
}
