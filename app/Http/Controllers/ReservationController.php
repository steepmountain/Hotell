<?php

namespace App\Http\Controllers;

use App;
use App\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Kommentarer til meg selv
 *      Passer $request rundt mindre.
 *      Lag servicer som gjør mindre biter av arbeidet utenfor controller
 */

class ReservationController extends Controller
{
    public function create()
    {
        $hotels = App\Hotel::select('name', 'hotelId')
            ->distinct('name')
            ->get();

        return view('reservation.create', ['hotels' => $hotels]);
    }

    public function search()
    {
        return view('reservation.search');
    }

    public function createReservation(Request $request)
    {
        // all reservations with this hotel's rooms in the given time frame
        $available = App\Helpers\ReservationHelpers::availableRoomsInRange($request->toDate, $request->fromDate, $request->hotel);
        $availableFiltered = DB::table('rooms')
            ->whereIn('roomId', $available)
            ->get();

        // TODO: Match numRooms mot enoughRooms. lag en custom rule og send tilbake til view.
        $enoughRooms = $availableFiltered >= $request->numRooms;

        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|alpha_num',
            'hotel' => [
                'required',
                'alpha_num',
                Rule::notIn(['default']),
            ],
            'numRooms' => 'required|digits_between:1,100|integer',
            'fromDate' => 'required|date|after:today',
            'toDate' => 'required|date|after:fromDate',
        ]);

        $person = App\Helpers\ReservationHelpers::createOrGetPerson($request);
        $reservations = App\Helpers\ReservationHelpers::insertReservation($request, $person->personId, $request->numRooms);

        $hotel = DB::table('hotels')
            ->where('hotelId', '=', $request->hotel)
            ->first();

        return view('reservation.success',
            ['reservations' => $reservations,
                'hotel' => $hotel->name,
                'price' => $hotel->price * count($reservations),
            ]);
    }
}
