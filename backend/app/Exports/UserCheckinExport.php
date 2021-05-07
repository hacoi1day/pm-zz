<?php

namespace App\Exports;

use App\Models\Checkin;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserCheckinExport implements FromView
{
    private $user;
    private $month;
    private $year;

    public function __construct($user, $month = null, $year = null) {
        $this->user = $user;
        $this->month = $month ? $month : Carbon::now()->month;
        $this->year = $year ? $year : Carbon::now()->year;
    }

    public function view(): View
    {
        $items = Checkin::where('user_id', $this->user->id)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->get();

        $result = [];
        $totalDay = 0;
        $totalHours = 0;

        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;

        foreach ($items as $item) {
            $date = Carbon::parse($item->date);
            $day = $date->day;
            $time_in = Carbon::parse($item->time_in);
            $time_out = Carbon::parse($item->time_out);

            $calc = $time_in->diffInMinutes($time_out);
            $calc = round(($calc / 60), 2);

            $color = 'gray';
            if ($calc !== 0 && $calc < 8) {
                $color = 'red';
            }
            if ($calc !== 0 && $calc >= 8) {
                $color = 'green';
            }

            $totalDay++;
            $totalHours += $calc;

            $result[$day] = [
                'time_in' => $time_in,
                'time_out' => $time_out,
                'calc' => $calc,
                'color' => $color
            ];
        }
        return view('exports.user_checkin', [
            'user' => $this->user,
            'items' => $result,
            'totalHours' => $totalHours,
            'totalDay' => $totalDay,

            'daysInMonth' => $daysInMonth,
            'year' => $this->year,
            'month' => $this->month
        ]);
    }

}
