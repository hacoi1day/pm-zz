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
        try {
            $user_id = Auth::guard('api')->id();
            $departments = $this->department->where('manager_id', $user_id)->get();
            return response()->json([
                'status' => 'success',
                'departments' => $departments
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listUserByDepartmentId($department_id)
    {
        try {
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
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportExcelUserByDepartmentId($department_id)
    {
        try {
            return Excel::download(new UserDepartmentExport($department_id), 'users_'.time().'.xlsx');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportUserCheckinByUserId($user_id)
    {
        try {
            return Excel::download(new UserCheckinExport($user_id), $user_id . '_checkin.xlsx');
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listRequestByDepartmentId(ListRequestRequest $request, $department_id)
    {
        try {
            $paginate = $this->request
            ->join('users', 'users.id', 'requests.user_id')
            ->where(function ($query) use ($request) {
                if ($request->has('status')) {
                    $query->where('status', $request->input('status'));
                }
            })
            ->where('users.department_id', $department_id)
            ->select('requests.*')
            ->paginate(10);

            $paginate->getCollection()->transform(function ($item) {
                $item->approval = $item->approval;
                return $item;
            });

            return response()->json($paginate);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
