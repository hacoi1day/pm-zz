<?php

namespace App\Http\Controllers\API\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartment;
use App\Http\Requests\Department\UpdateDepartment;
use App\Services\DepartmentService;

class DepartmentResourceController extends Controller
{
    private $departmentService;

    public function __construct(DepartmentService $departmentService) {
        $this->departmentService = $departmentService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = $this->departmentService->paginate();
        return response()->json($paginate, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartment $request)
    {
        $department = $this->departmentService->create($request->all());
        return response()->json($department, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = $this->departmentService->get($id);
        return response()->json($department, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartment $request, $id)
    {
        $department = $this->departmentService->update($request->all(), $id);
        return response()->json($department, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->departmentService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Xoá Phòng ban thành công.'
        ], 200);
    }

    public function dropdown()
    {
        $dropdown = $this->departmentService->dropdown();
        return response()->json($dropdown, 200);
    }
}
