<?php

namespace App\Http\Controllers\API\Export;

use App\Exports\UserCheckinExport;
use App\Exports\UserDepartmentExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\ExportExcel\UserCheckinRequest;
use App\Models\Department;
use App\Models\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    private $user;
    private $department;
    private $request;

    public function __construct(User $user,
                                Department $department,
                                Request $request) {
        $this->user = $user;
        $this->department = $department;
        $this->request = $request;
    }

    public function exportDepartment($department_id)
    {
        try {
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
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportUserCheckin(UserCheckinRequest $request, $user_id)
    {
        try {
            $year = $request->has('year') ? intval($request->input('year')) : Carbon::now()->year;
            $month = $request->has('month') ? intval($request->input('month')) : Carbon::now()->month;

            $user = $this->user->find($user_id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nhân viên không tồn tại'
                ], 500);
            }
            $fileName = $user->name . '_' . time() . '.xlsx';
            return Excel::download(new UserCheckinExport($user, $month, $year), $fileName);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
