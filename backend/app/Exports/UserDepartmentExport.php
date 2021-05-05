<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserDepartmentExport implements FromCollection, WithHeadings, WithMapping
{
    private $department_id;

    public function __construct($department_id) {
        $this->department_id = $department_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('department_id', $this->department_id)->get();
    }

    public function headings(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Họ và tên',
            'birthday' => 'Ngày sinh',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ'
        ];
    }

    public function map($row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'birthday' => Carbon::parse($row->birthday)->format('d-m-Y'),
            'email' => $row->email,
            'phone' => $row->phone,
            'address' => $row->address
        ];
    }

}
