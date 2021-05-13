<?php

namespace App\Http\Controllers\API\Checkin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkin\CalendarRequest;
use App\Models\Checkin;
use App\Services\CheckinService;
use Exception;
use Illuminate\Support\Facades\Auth;

class CheckinController extends Controller
{
    private $checkinService;

    public function __construct(CheckinService $checkinService) {
        $this->checkinService = $checkinService;
    }

    public function getCalendar(CalendarRequest $request)
    {
        $result = $this->checkinService->calendar($request->get('start_date'), $request->get('end_date'));
        return response()->json($result, 200);
    }

    public function checkin()
    {
        if (!$this->checkinService->checkHasCheckin()) {
            return response()->json([
                'status' => 'has_checkin',
                'message' => 'Bạn chưa Checkout!'
            ], 500);
        }
        $result = $this->checkinService->checkin();
        return response()->json([
            'status' => 'success',
            'item' => $result,
            'message' => 'Checkin thành công.'
        ], 200);
    }

    public function checkout()
    {
        if ($this->checkinService->checkHasCheckin()) {
            return response()->json([
                'status' => 'don\'t_checkin',
                'message' => 'Bạn chưa Checkin!'
            ], 500);
        }
        $result = $this->checkinService->checkout();
        return response()->json([
            'status' => 'success',
            'item' => $result,
            'message' => 'Checkout thành công.'
        ], 200);
    }

    public function getLastCheckin()
    {
        $lastCheckin = $this->checkinService->getLastCheckin();
        return response()->json([
            'status' => 'success',
            'item' => $lastCheckin,
        ], 200);
    }
}
