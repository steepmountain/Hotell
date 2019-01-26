<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function create() {
        return view('reservation.create');
    }

    public function search() {
        return view('reservation.search');
    }
}
