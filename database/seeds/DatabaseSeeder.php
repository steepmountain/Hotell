<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $thonId = DB::table('hotels')->insertGetId(
            [
                'name' => 'Thon Hotel',
                'city' => 'Skien',
                'numRooms' => '40',
                'price' => '1440',
            ]
        );

        foreach (range(1, 40) as $index) {
            DB::table('rooms')->insert([
                'hotelId' => $thonId
            ]);
        }

        $claironId = DB::table('hotels')->insertGetId(
            [
                'name' => 'Clairon Hotel',
                'city' => 'Porsgrunn',
                'numRooms' => '60',
                'price' => '1330',
            ]
        );

        foreach (range(1, 60) as $index) {
            DB::table('rooms')->insert([
                'hotelId' => $claironId
            ]);
        }

        $hoiersId = DB::table('hotels')->insertGetId(
            [
                'name' => 'Hoiers Hotel',
                'city' => 'Langesund',
                'numRooms' => '70',
                'price' => '1550',
            ]
        );

        foreach (range(1, 70) as $index) {
            DB::table('rooms')->insert([
                'hotelId' => $hoiersId
            ]);
        }

        $kroghId = DB::table('hotels')->insertGetId(
            [
                'name' => 'Krogh Hotel',
                'city' => 'Bø',
                'numRooms' => '30',
                'price' => '1240',
            ]
        );

        foreach (range(1, 30) as $index) {
            DB::table('rooms')->insert([
                'hotelId' => $kroghId
            ]);
        }

    }
}
