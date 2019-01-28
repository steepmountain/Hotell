<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function create()
    {
        $hotels = App\Hotel::select('name')
            ->distinct()
            ->get();

        return view('reservation.create', ['hotels' => $hotels]);
    }

    public function createReservation(Request $request)
    {

        //TODO: sanitize

        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|alpha_num',
            'city' => [
                'required',
                'string',
                Rule::notIn(['default']),
            ],
            'numRooms' => 'required|digits_between:1,100|integer',
            'fromDate' => 'required|date|after:today',
            'toDate' => 'required|date|after:fromDate',
        ]);

        // TODO: Checks if any rooms are actually available
        // get the count of rooms in the hotel. see if the number of reservations in the time between fromDate and toDate is smaller than this number

        // TODO: Extract all this to person service
        $firstName = filter_var($request->firstName, FILTER_SANITIZE_STRING);
        $lastName =filter_var($request->lastName, FILTER_SANITIZE_STRING);
        $email =filter_var($request->email, FILTER_SANITIZE_STRING);
        $phone = filter_var($request->phone, FILTER_SANITIZE_STRING);

        // Get or create person
        $person = DB::table('people')
            ->where([
                ['firstName', '=', $firstName],
                ['lastName', '=', $lastName],
                ['email', '=', $email],
                ['phone', '=', $phone]
            ])
            ->first()
            ->get();

        if ($person == null) {
            $id = DB::table('people')
                ->insert([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                    'phone' => $phone
                    ]
                );
            $person = DB::table('people')
                ->where('id', '=', $id)
                ->first()
                ->get();
        }

        // TODO: Extract all this to reservation service
        // Create a person if they don't exist
        // Create a reservation with the given person in an available room IF THERE IS ONE

        return view('reservation.success', ['reservation' => $reservation]);
    }

    public function search()
    {
        return view('reservation.search');
    }
}
