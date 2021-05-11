<?php

namespace App\Http\Controllers\API\Checkin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkin\CalendarRequest;
use App\Models\Checkin;
use Exception;
use Illuminate\Support\Facades\Auth;

class CheckinController extends Controller
{
    private $checkin;

    public function __construct(Checkin $checkin) {
        $this->checkin = $checkin;
    }

    public function getCalendar(CalendarRequest $request)
    {
        $start_date = date($request->input('start_date'));
        $end_date = date($request->input('end_date'));
        $userId = Auth::guard('api')->id();
        $result = $this->checkin
            ->where('user_id', $userId)
            ->whereBetween('date', [$start_date, $end_date])
            ->get();
        return response()->json($result, 200);
    }

    public function checkin()
    {
        $userId = Auth::guard('api')->id();
        $lastCheckin = $this->checkin
            ->where('user_id', $userId)
            ->orderBy('time_in', 'desc')
            ->first();
        if ($lastCheckin && is_null($lastCheckin->time_out)) {
            return response()->json([
                'status' => 'has_checkin',
                'message' => 'Bạn chưa Checkout!'
            ], 500);
        }
        $checkin = [
            'user_id' => $userId,
            'date' => date('Y-m-d', time()),
            'time_in' => date('Y-m-d H:i:s', time())
        ];
        $result = $this->checkin->create($checkin);
        return response()->json([
            'status' => 'success',
            'item' => $result,
            'message' => 'Checkin thành công.'
        ], 200);
    }

    public function checkout()
    {
        $userId = Auth::guard('api')->id();
        $lastCheckin = $this->checkin
            ->where('user_id', $userId)
            ->orderBy('time_in', 'desc')
            ->first();

        if (!$lastCheckin || ($lastCheckin && $lastCheckin->time_out !== null)) {
            return response()->json([
                'status' => 'don\'t_checkin',
                'message' => 'Bạn chưa Checkin!'
            ], 500);
        }
        $checkout = [
            'time_out' => date('Y-m-d H:i:s', time())
        ];
        $lastCheckin->update($checkout);
        return response()->json([
            'status' => 'success',
            'item' => $lastCheckin,
            'message' => 'Checkout thành công.'
        ], 200);
    }

    public function getLastCheckin()
    {
        $userId = Auth::guard('api')->id();
        $lastCheckin = $this->checkin
            ->where('user_id', $userId)
            ->orderBy('time_in', 'desc')
            ->first();
        return response()->json([
            'status' => 'success',
            'item' => $lastCheckin,
        ], 200);
    }
}
