<?php

namespace App\Exports;

use App\Models\Checkin;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserCheckinExport implements FromCollection, WithHeadings, WithMapping
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
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Checkin::where('user_id', $this->user_id)
            ->whereYear('date', '=' , $this->year)
            ->whereMonth('date', '=', $this->month)
            ->get();
    }

    public function headings(): array
    {
        return [
            'id' => 'ID',
            'date' => 'Ngày',
            'time_in' => 'Giờ vào',
            'time_out' => 'Giờ ra',
        ];
    }

    public function map($row): array
    {
        return [
            'id' => $row->id,
            'date' => Carbon::parse($row->date)->format('d-m-Y'),
            'time_in' => $row->time_in ? Carbon::parse($row->time_in)->format('h:i') : '',
            'time_out' => $row->time_out ? Carbon::parse($row->time_out)->format('h:i') : '',
        ];
    }

}
