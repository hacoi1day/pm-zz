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

    public function checkin()
    {
        try {
            $userId = Auth::guard('api')->id();
            $lastCheckin = $this->checkin->where('user_id', $userId)->orderBy('date', 'desc')->first();
            if ($lastCheckin->time_out === null) {
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
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function checkout()
    {
        try {
            $userId = Auth::guard('api')->id();
            $lastCheckin = $this->checkin->where('user_id', $userId)->orderBy('date', 'desc')->first();
            if ($lastCheckin->time_out !== null) {
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
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getLastCheckin()
    {
        try {
            $userId = Auth::guard('api')->id();
            $lastCheckin = $this->checkin
                ->where('user_id', $userId)
                ->orderBy('date', 'desc')->first();
            return response()->json([
                'status' => 'success',
                'item' => $lastCheckin,
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
