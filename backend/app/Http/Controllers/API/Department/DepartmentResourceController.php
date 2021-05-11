<?php

namespace App\Http\Controllers\API\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartment;
use App\Http\Requests\Department\UpdateDepartment;
use App\Models\Department;
use Exception;

class DepartmentResourceController extends Controller
{
    private $department;

    public function __construct(Department $department) {
        $this->department = $department;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = $this->department->paginate(10);
        $paginate->getCollection()->transform(function ($item) {
            $item->manager;
            return $item;
        });
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
        $item = $this->department->create($request->all());
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->department->find($id);
        return response()->json($item, 202);
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
        $item = $this->department->find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->department->find($id);
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete successfully'
        ], 200);
    }

    public function dropdown()
    {
        $items = $this->department->all();
        $result = [];
        foreach ($items as $item) {
            array_push($result, [
                'id' => $item->id,
                'name' => $item->name,
            ]);
        }
        return response()->json($result, 200);
    }
}
