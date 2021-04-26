<?php

namespace App\Http\Controllers\API\Checkin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkin\CalendarRequest;
use App\Models\Checkin;
use Exception;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    private $checkin;

    public function __construct(Checkin $checkin) {
        $this->checkin = $checkin;
    }

    public function getCalendar(CalendarRequest $request)
    {
        try {
            $start_date = date($request->input('start_date'));
            $end_date = date($request->input('end_date'));
            $result = $this->checkin->whereBetween('date', [$start_date, $end_date])->get();
            return response()->json($result, 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
