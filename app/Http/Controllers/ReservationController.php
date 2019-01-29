<?php

namespace App\Http\Controllers;

use App;
use App\Helpers;
use App\Helpers\ReservationHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Kommentarer til meg selv
 *      Passer $request rundt mindre.
 *      Lag servicer som gjør mindre biter av arbeidet utenfor controller
 *      Gjør om alle whereIn om til JOINS for performance
 */

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        $hotels = App\Hotel::select('name', 'hotelId')
            ->distinct('name')
            ->get();

        return view('reservation.create', [
            'hotels' => $hotels,
            'numRooms' => $request->numRooms,
            'toDate' => $request->toDate,
            'fromDate' => $request->fromDate,
            'hotelId' => $request->hotelId
        ]);
    }

    public function search()
    {
        $cities = App\Hotel::select('city')
            ->distinct('city')
            ->get();

        return view('reservation.search', ['cities' => $cities]);
    }

    public function performSearch(Request $request)
    {
        $validated = $request->validate([
            'city' => [
                'required',
                'alpha_num',
                Rule::notIn(['default']),
            ],
            'numRooms' => 'required|digits_between:1,100|integer',
            'fromDate' => 'required|date|after:today',
            'toDate' => 'required|date|after:fromDate',
        ]);

        $checkPrice = $request->maxPrice != null ? $request->maxPrice : PHP_INT_MAX;
        $hotels = App\Hotel::where('city', '=', $request->city)
            ->where('price', '<=', $checkPrice)
            ->orderBy('price', 'asc')
            ->get();

        // TODO: check that hotels have free rooms here and not later
        // TODO: group free rooms by hotel and attach them to the model
        // $availableRoomIds = array();
        // foreach ($hotels as $hotel) {
        //     $tmp = ReservationHelpers::availableRoomsInRange($request->toDate, $request->fromDate, $hotel->hotelId);
        //     $availableRoomIds = array_merge($availableRoomIds, $tmp);
        // }
        // $availableRooms = DB::table('rooms')
        //     ->whereIn('roomId', $availableRoomIds)
        //     ->get();

        return view('reservation.searchResult', [
            'hotels' => $hotels,
            'fromDate' => $request->fromDate,
            'toDate' => $request->toDate,
            'numRooms' => $request->numRooms]
        );

    }

    public function createReservation(Request $request)
    {
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

        // all reservations with this hotel's rooms in the given time frame
        $available = ReservationHelpers::availableRoomsInRange($request->toDate, $request->fromDate, $request->hotel);
        $availableFiltered = App\Room::whereIn('roomId', $available)
            ->get();

        // TODO: Match numRooms mot enoughRooms. lag en custom rule og send tilbake til view.
        $enoughRooms = count($availableFiltered) >= $request->numRooms;
        if (!$enoughRooms) {
            abort(500);
        }

        $person = ReservationHelpers::createOrGetPerson($request);
        $reservations = ReservationHelpers::insertReservation($request, $person->personId, $request->numRooms);

        $hotel = App\Hotel::where('hotelId', '=', $request->hotel)
            ->first();

        return view('reservation.success',
            ['reservations' => $reservations,
                'hotel' => $hotel->name,
                'price' => $hotel->price * count($reservations),
            ]);
    }
}
