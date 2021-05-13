<?php

namespace App\Http\Controllers\API\Export;

use App\Exports\UserCheckinExport;
use App\Exports\UserDepartmentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\ExportExcel\UserCheckinRequest;
use App\Services\DepartmentService;
use App\Services\UserService;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    private $userService;
    private $departmentService;

    public function __construct(UserService $userService,
                                DepartmentService $departmentService) {
        $this->userService = $userService;
        $this->departmentService = $departmentService;
    }

    public function exportDepartment($departmentId)
    {
        $department = $this->departmentService->get($departmentId);
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng ban không tồn tại.'
            ], 500);
        }
        $fileName = 'Danh sách nhân viên ' . $department->name . '_' . time() . '.xlsx';
        return Excel::download(new UserDepartmentExport($department), $fileName);
    }

    public function exportUserCheckin(UserCheckinRequest $request, $userId)
    {
        $year = $request->has('year') ? intval($request->input('year')) : now()->year;
        $month = $request->has('month') ? intval($request->input('month')) : now()->month;

        $user = $this->userService->get($userId);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nhân viên không tồn tại'
            ], 500);
        }
        $fileName = $user->name . '_' . $month . '_' . $year . '_' . time() . '.xlsx';
        return Excel::download(new UserCheckinExport($user, $month, $year), $fileName);
    }
}
