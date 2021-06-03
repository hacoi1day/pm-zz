<?php

namespace Database\Seeders;

use App\Models\Checkin;
use Illuminate\Database\Seeder;

class CheckinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Checkin::create([
            'id' => 1,
            'user_id' => 1,
            'date' => '2021-05-01',
            'time_in' => '2021-05-01 09:00:00',
            'time_out' => '2021-05-01 18:00:00'
        ]);
        Checkin::create([
            'id' => 2,
            'user_id' => 1,
            'date' => '2021-05-02',
            'time_in' => '2021-05-02 09:00:00',
            'time_out' => '2021-05-02 18:00:00'
        ]);
        Checkin::create([
            'id' => 3,
            'user_id' => 1,
            'date' => '2021-05-03',
            'time_in' => '2021-05-03 09:00:00',
            'time_out' => '2021-05-03 18:00:00'
        ]);
        Checkin::create([
            'id' => 4,
            'user_id' => 1,
            'date' => '2021-05-04',
            'time_in' => '2021-05-04 09:00:00',
            'time_out' => '2021-05-04 18:00:00'
        ]);
        Checkin::create([
            'id' => 5,
            'user_id' => 1,
            'date' => '2021-05-05',
            'time_in' => '2021-05-05 09:00:00',
            'time_out' => '2021-05-05 18:00:00'
        ]);
    }
}
