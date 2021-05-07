<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserDepartmentExport implements FromView
{
    private $department;

    public function __construct($department) {
        $this->department = $department;
    }

    public function view(): View
    {
        $users = User::where('department_id', $this->department->id)->get();

        $items = [];
        $total = 0;

        foreach ($users as $user) {
            array_push($items, [
                'id' => $user->id,
                'name' => $user->name,
                'birthday' => Carbon::parse($user->birthday)->format('d-m-Y'),
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ]);
            $total++;
        }
        return view('exports.department_user', [
            'department' => $this->department,
            'items' => $items,
            'total' => $total
        ]);
    }

}
