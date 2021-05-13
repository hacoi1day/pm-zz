<?php

namespace App\Http\Controllers\API\Manager;

use App\Exports\UserCheckinExport;
use App\Exports\UserDepartmentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ListRequestRequest;
use App\Models\Department;
use App\Models\Request;
use App\Models\User;
use App\Services\DepartmentService;
use App\Services\ManagerService;
use App\Services\RequestService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ManagerController extends Controller
{
    private $user;
    private $department;
    private $request;

    private $managerService;
    private $requestService;

    public function __construct(User $user, Department $department, Request $request,
        ManagerService $managerService, RequestService $requestService
    ) {
        $this->user = $user;
        $this->department = $department;
        $this->request = $request;
        $this->managerService = $managerService;
        $this->requestService = $requestService;
    }

    public function listDepartment()
    {
        $departments = $this->managerService->listDepartment();
        return response()->json([
            'status' => 'success',
            'departments' => $departments
        ], 200);
    }

    public function listUserByDepartmentId($departmentId)
    {
        $users = $this->managerService->listUserByDepartmentId($departmentId);

        if (count($users) === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng ban không thuộc quản lý.'
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'users' => $users
        ], 200);
    }

    public function listRequestByDepartmentId(ListRequestRequest $request, $departmentId)
    {
        $paginate = $this->managerService->listRequestByDepartmentId($departmentId, $request->all());
        return response()->json($paginate);
    }

    public function approvalRequest($requestId)
    {
        $this->requestService->approvalRequest($requestId);
        return response()->json([
            'status' => 'success',
            'message' => 'Phê duyệt yêu cầu thành công.'
        ], 200);
    }

    public function refuseRequest($requestId)
    {
        $this->requestService->refuseRequest($requestId);
        return response()->json([
            'status' => 'success',
            'message' => 'Từ chối yêu cầu thành công.'
        ], 200);
    }

}
