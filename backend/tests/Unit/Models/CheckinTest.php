<?php

namespace Tests\Unit\Models;

use App\Models\Checkin;
use PHPUnit\Framework\TestCase;

class CheckinTest extends TestCase
{
    public function test_checkin()
    {
        $checkin = new Checkin;
        $checkin->user_id = 1;
        $checkin->date = '2021-05-14';
        $checkin->time_in = '2021-05-14 09:00:00';
        $checkin->time_out = '2021-05-14 18:00:00';
        $this->assertIsNumeric($checkin->user_id);
        $this->assertIsNumeric($checkin->user_id);
        $this->assertIsNumeric($checkin->user_id);
    }
}
