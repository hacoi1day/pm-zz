<?php

namespace App\Http\Controllers\API\Checkin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkin\StoreCheckin;
use App\Http\Requests\Checkin\UpdateCheckin;
use App\Services\CheckinService;

class CheckinResourceController extends Controller
{
    private $checkinService;

    public function __construct(CheckinService $checkinService) {
        $this->checkinService = $checkinService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = $this->checkinService->paginate();
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
    public function store(StoreCheckin $request)
    {
        $item = $this->checkinService->create($request->all());
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
        $checkin = $this->checkinService->get($id);
        return response()->json($checkin, 200);
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
    public function update(UpdateCheckin $request, $id)
    {
        $item = $this->checkinService->update($request->all(), $id);
        return response()->json($item, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->checkinService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Xoá Checkin thành công.'
        ], 200);
    }
}
