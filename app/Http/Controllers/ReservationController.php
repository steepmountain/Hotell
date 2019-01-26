<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index() {
        return view('reservation.index');
    }
}
