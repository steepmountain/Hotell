<?php

namespace App\Helpers;

use App;
use App\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReservationHelpers
{
    public static function insertReservation($request, $personId, $numRooms)
    {
        $reservations = array();

        foreach (range(1, $numRooms) as $index) {
            $firstAvailableRoom = $availableRooms = ReservationHelpers::availableRoomsInRange($request->toDate, $request->fromDate, $request->hotel)[0];
            $id = DB::table('reservations')
                ->insertGetId([
                    'roomId' => $firstAvailableRoom,
                    'personId' => $personId,
                    'fromDate' => $request->fromDate,
                    'toDate' => $request->toDate,
                ]);
            $reservations[] = $id;
        };

        return DB::table('reservations')
            ->whereIn('reservationId', $reservations)
            ->get();
    }

    public static function availableRoomsInRange($to, $from, $hotel)
    {
        $reserved = DB::table('reservations')
            ->select('roomId')
            ->where('reservations.toDate', '>=', $from)
            ->where('reservations.fromDate', '<=', $to)
            ->get();

        $reservedIds = array();
        foreach ($reserved as $id) {
            $reservedIds[] = (string) $id->roomId;
        }

        $available = DB::table('rooms')
            ->select('roomId')
            ->where('hotelId', $hotel)
            ->whereNotIn('roomId', $reservedIds)
            ->get();

        $availableIds = array();
        foreach ($available as $id) {
            $availableIds[] = (string) $id->roomId;
        }

        return $availableIds;
    }

    public static function createOrGetPerson($request)
    {
        $firstName = filter_var($request->firstName, FILTER_SANITIZE_STRING);
        $lastName = filter_var($request->lastName, FILTER_SANITIZE_STRING);
        $email = filter_var($request->email, FILTER_SANITIZE_STRING);
        $phone = filter_var($request->phone, FILTER_SANITIZE_STRING);

        $person = App\Person::where([
            ['firstName', '=', $firstName],
            ['lastName', '=', $lastName],
            ['email', '=', $email],
            ['phone', '=', $phone],
        ])
            ->first();

        if ($person) {
            $id = DB::table('people')
                ->insertGetId([
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                ]
                );

            $person = DB::table('people')
                ->where('personId', '=', $id)
                ->first();
        }

        return $person;
    }
}
