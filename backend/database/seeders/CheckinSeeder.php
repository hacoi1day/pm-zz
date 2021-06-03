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
            'date' => '2021-06-01',
            'time_in' => '2021-06-01 09:00:00',
            'time_out' => '2021-06-01 18:00:00'
        ]);
        Checkin::create([
            'id' => 1,
            'user_id' => 1,
            'date' => '2021-06-02',
            'time_in' => '2021-06-02 09:00:00',
            'time_out' => '2021-06-02 18:00:00'
        ]);
        Checkin::create([
            'id' => 1,
            'user_id' => 1,
            'date' => '2021-06-03',
            'time_in' => '2021-06-03 09:00:00',
            'time_out' => '2021-06-03 18:00:00'
        ]);
        Checkin::create([
            'id' => 1,
            'user_id' => 1,
            'date' => '2021-06-04',
            'time_in' => '2021-06-04 09:00:00',
            'time_out' => '2021-06-04 18:00:00'
        ]);
        Checkin::create([
            'id' => 1,
            'user_id' => 1,
            'date' => '2021-06-05',
            'time_in' => '2021-06-05 09:00:00',
            'time_out' => '2021-06-05 18:00:00'
        ]);
    }
}
