<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function create()
    {
        $cities = App\Hotel::select('city')
            ->distinct();
        return view('reservation.create', ['cities' => $cities]);
    }

    public function search()
    {
        return view('reservation.search');
    }
}
