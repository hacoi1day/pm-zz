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

    /**
     * @OA\Get(
     *      path="/manager/list-department",
     *      operationId="getListDepartment",
     *      tags={"Manager"},
     *      summary="List Department",
     *      description="List Department",
     *      @OA\Response(
     *          response=200,
     *          description="List Department By Manager Id",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function listDepartment()
    {
        $departments = $this->managerService->listDepartment();
        return response()->json([
            'status' => 'success',
            'departments' => $departments
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/manager/list-user-by-department/{departmentId}",
     *      operationId="getListUserByDepartment",
     *      tags={"Manager"},
     *      summary="List User By Department",
     *      description="List User By Department",
     *      @OA\Response(
     *          response=200,
     *          description="List User By Department",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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

    /**
     * @OA\Get(
     *      path="/manager/list-request/{departmentId}",
     *      operationId="getListRequestByDepartment",
     *      tags={"Manager"},
     *      summary="List Request By Department",
     *      description="List Request By Department",
     *      @OA\Response(
     *          response=200,
     *          description="List Request By Department",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function listRequestByDepartmentId(ListRequestRequest $request, $departmentId)
    {
        $paginate = $this->managerService->listRequestByDepartmentId($departmentId, $request->all());
        return response()->json($paginate);
    }

    /**
     * @OA\Get(
     *      path="/manager/approval-request/{requestId}",
     *      operationId="getApprovalRequest",
     *      tags={"Manager"},
     *      summary="Approval Request",
     *      description="Approval Request",
     *      @OA\Response(
     *          response=200,
     *          description="Status Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function approvalRequest($requestId)
    {
        $this->requestService->approvalRequest($requestId);
        return response()->json([
            'status' => 'success',
            'message' => 'Phê duyệt yêu cầu thành công.'
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/manager/refuse-request/{requestId}",
     *      operationId="getRefuseRequest",
     *      tags={"Manager"},
     *      summary="Refuse Request",
     *      description="Refuse Request",
     *      @OA\Response(
     *          response=200,
     *          description="Status Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function refuseRequest($requestId)
    {
        $this->requestService->refuseRequest($requestId);
        return response()->json([
            'status' => 'success',
            'message' => 'Từ chối yêu cầu thành công.'
        ], 200);
    }

}
