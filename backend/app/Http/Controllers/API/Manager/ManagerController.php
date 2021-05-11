<?php

namespace App\Http\Controllers\API\Manager;

use App\Exports\UserCheckinExport;
use App\Exports\UserDepartmentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ListRequestRequest;
use App\Models\Department;
use App\Models\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ManagerController extends Controller
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
        return response()->json([
            'status' => 'success',
            'departments' => $departments
        ], 200);
    }

    public function listUserByDepartmentId($department_id)
    {
        $user_id = Auth::guard('api')->id();
        $department = $this->department
            ->where('manager_id', $user_id)
            ->where('id', $department_id)
            ->first();
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng ban không thuộc quản lý.'
            ], 500);
        }
        $users = $department->users;
        return response()->json([
            'status' => 'success',
            'users' => $users
        ], 200);
    }

    public function exportExcelUserByDepartmentId($department_id)
    {
        $department = $this->department->find($department_id);
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng ban không tồn tại.'
            ], 500);
        }
        $department->manager;
        $fileName = 'Danh sách nhân viên ' . $department->name . '_' . time() . '.xlsx';
        return Excel::download(new UserDepartmentExport($department), $fileName);
    }

    public function exportUserCheckinByUserId($user_id)
    {
        $user = $this->user->find($user_id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nhân viên không tồn tại'
            ], 500);
        }
        return Excel::download(new UserCheckinExport($user_id), $user_id . '_checkin.xlsx');
    }

    public function listRequestByDepartmentId(ListRequestRequest $request, $department_id)
    {
        $paginate = $this->request
        ->join('users', 'users.id', 'requests.user_id')
        ->where(function ($query) use ($request) {
            if ($request->has('status')) {
                $query->where('status', $request->input('status'));
            }
        })
        ->where('users.department_id', $department_id)
        ->select('requests.*', 'users.email', 'users.name')
        ->paginate(10);

        $paginate->getCollection()->transform(function ($item) {
            $item->approval = $item->approval;
            return $item;
        });

        return response()->json($paginate);
    }

    public function approvalRequest($request_id)
    {
        $request = $this->request->find($request_id);
        $request->update([
            'status' => 2,
            'approval_by' => Auth::guard('api')->id()
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Phê duyệt yêu cầu thành công.'
        ], 200);
    }

    public function refuseRequest($request_id)
    {
        $request = $this->request->find($request_id);
        $request->update([
            'status' => 3,
            'approval_by' => Auth::guard('api')->id()
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Từ chôi yêu cầu thành công.'
        ], 200);
    }

}
