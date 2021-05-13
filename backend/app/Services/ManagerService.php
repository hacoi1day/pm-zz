<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManagerService
{
    private $user;
    private $department;
    private $request;

    public function __construct(User $user, Department $department, Request $request) {
        $this->user = $user;
        $this->department = $department;
        $this->request = $request;
    }

    public function listDepartment()
    {
        $user_id = Auth::guard('api')->id();
        $departments = $this->department->where('manager_id', $user_id)->get();
        return $departments;
    }

    public function listUserByDepartmentId($departmentId)
    {
        $user_id = Auth::guard('api')->id();
        $department = $this->department
            ->where('manager_id', $user_id)
            ->where('id', $departmentId)
            ->first();
        if (!$department) {
            return [];
        }
        $users = $department->users;
        return $users;
    }

    public function listRequestByDepartmentId($departmentId, $params)
    {
        $paginate = $this->request
        ->join('users', 'users.id', 'requests.user_id')
        ->where(function ($query) use ($params) {
            if (array_key_exists('status', $params)) {
                $query->where('status', $params['status']);
            }
        })
        ->where('users.department_id', $departmentId)
        ->select('requests.*', 'users.email', 'users.name')
        ->paginate(10);

        $paginate->getCollection()->transform(function ($item) {
            $item->approval = $item->approval;
            return $item;
        });

        return $paginate;
    }
}
