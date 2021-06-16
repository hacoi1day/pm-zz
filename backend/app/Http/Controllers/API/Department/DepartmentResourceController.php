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
     * @OA\Get(
     *      path="/department/department",
     *      operationId="getPaginateDepartment",
     *      tags={"Department"},
     *      summary="Get Paginate Department",
     *      description="Get Paginate Department",
     *      @OA\Response(
     *          response=200,
     *          description="Paginate Department Data",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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
     * @OA\Post(
     *      path="/department/department",
     *      operationId="postDepartment",
     *      tags={"Department"},
     *      summary="Post Department",
     *      description="Post Department",
     *      @OA\Response(
     *          response=201,
     *          description="Department Data Post",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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
     * @OA\Get(
     *      path="/department/department/{id}",
     *      operationId="getDepartment",
     *      tags={"Department"},
     *      summary="Get Department",
     *      description="Get Department",
     *      @OA\Response(
     *          response=200,
     *          description="Department Data Get",
     *          @OA\JsonContent()
     *       )
     *     )
     */
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
     * @OA\Put(
     *      path="/department/department/{id}",
     *      operationId="putDepartment",
     *      tags={"Department"},
     *      summary="Put Department",
     *      description="Put Department",
     *      @OA\Response(
     *          response=202,
     *          description="Department Data Put",
     *          @OA\JsonContent()
     *       )
     *     )
     */

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
     * @OA\Delete(
     *      path="/department/department/{id}",
     *      operationId="deleteDepartment",
     *      tags={"Department"},
     *      summary="Delete Department",
     *      description="Delete Department",
     *      @OA\Response(
     *          response=200,
     *          description="Status Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */

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

    /**
     * @OA\Get(
     *      path="/department/dropdown",
     *      operationId="getDropdownDepartment",
     *      tags={"Department"},
     *      summary="Dropdown Department",
     *      description="Dropdown Department",
     *      @OA\Response(
     *          response=200,
     *          description="List Dropdown Department",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function dropdown()
    {
        $dropdown = $this->departmentService->dropdown();
        return response()->json($dropdown, 200);
    }
}
