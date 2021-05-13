<?php

namespace App\Services;

use App\Models\Checkin;
use Illuminate\Support\Facades\Auth;

class CheckinService
{
    private $checkin;

    public function __construct(Checkin $checkin) {
        $this->checkin = $checkin;
    }

    public function paginate()
    {
        $paginate = $this->checkin->latest()->paginate(10);
        return $paginate;
    }

    public function create($params)
    {
        $checkin = $this->checkin->create($params);
        return $checkin;
    }

    public function get($id)
    {
        $checkin = $this->checkin->findOrFail($id);
        return $checkin;
    }

    public function update($params, $id)
    {
        $checkin = $this->get($id);
        $checkin->update($params);
        return $checkin;
    }

    public function delete($id)
    {
        $checkin = $this->get($id);
        $checkin->delete();
        return true;
    }


    public function calendar($startDate, $endDate)
    {
        $startDate = date($startDate);
        $endDate = date($endDate);
        $userId = Auth::guard('api')->id();
        $result = $this->checkin
            ->where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();
        return $result;
    }

    public function getLastCheckin()
    {
        $userId = Auth::guard('api')->id();
        $lastCheckin = $this->checkin
            ->where('user_id', $userId)
            ->orderBy('time_in', 'desc')
            ->first();
        return $lastCheckin;
    }

    public function checkHasCheckin()
    {
        $lastCheckin = $this->getLastCheckin();
        if ($lastCheckin && is_null($lastCheckin->time_out)) {
            return false;
        }
        return true;
    }

    public function checkin()
    {
        $userId = Auth::guard('api')->id();
        $checkin = [
            'user_id' => $userId,
            'date' => date('Y-m-d', time()),
            'time_in' => date('Y-m-d H:i:s', time())
        ];
        $result = $this->checkin->create($checkin);
        return $result;
    }

    public function checkout()
    {
        $checkout = [
            'time_out' => date('Y-m-d H:i:s', time())
        ];
        $lastCheckin = $this->getLastCheckin();
        $lastCheckin->update($checkout);
        return $lastCheckin;
    }
}
