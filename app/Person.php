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
        'personId', 'firstName', 'lastName', 'phone', 'email'
    ];
}
