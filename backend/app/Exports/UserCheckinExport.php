<?php

namespace App\Exports;

use App\Models\Checkin;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserCheckinExport implements FromView
{
    private $user_id;
    private $month;
    private $year;

    public function __construct($user_id, $month = null, $year = null) {
        $this->user_id = $user_id;
        if (is_null($month)) {
            $this->month = Carbon::now()->month;
        }
        if (is_null($year)) {
            $this->year = Carbon::now()->year;
        }
    }

    public function view(): View
    {
        $items = Checkin::where('user_id', $this->user_id)
            ->whereYear('date', '=' , $this->year)
            ->whereMonth('date', '=', $this->month)
            ->get();
        $result = [];
        $totalDay = 0;
        $totalHours = 0;
        foreach ($items as $item) {
            $time_in = Carbon::parse($item->time_in);
            $time_out = Carbon::parse($item->time_out);
            $data = [
                'date' => Carbon::parse($item->date)->format('d-m-Y'),
                'time_in' => $time_in,
                'time_out' => $time_out,
                'count' => $time_in->diff($time_out)->format('%H:%I')
            ];
            array_push($result, $data);
        }
        return view('exports.user_checkin', [
            'items' => $result,
            'totalHours' => $totalHours,
            'totalDay' => $totalDay
        ]);
    }

}
