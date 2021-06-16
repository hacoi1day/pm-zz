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
     * @OA\Get(
     *      path="/checkin/checkin",
     *      operationId="getPaginateCheckin",
     *      tags={"Checkin"},
     *      summary="Paginate Checkin",
     *      description="Paginate Checkin",
     *      @OA\Response(
     *          response=200,
     *          description="Paginate Checkin Data",
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
     * @OA\Post(
     *      path="/checkin/checkin",
     *      operationId="postStoreCheckin",
     *      tags={"Checkin"},
     *      summary="Store Checkin",
     *      description="Store Checkin",
     *      @OA\Response(
     *          response=200,
     *          description="Checkin Data Store",
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
    public function store(StoreCheckin $request)
    {
        $item = $this->checkinService->create($request->all());
        return response()->json($item, 201);
    }

    /**
     * @OA\Get(
     *      path="/checkin/checkin/{id}",
     *      operationId="getCheckin",
     *      tags={"Checkin"},
     *      summary="Get Checkin",
     *      description="Get Checkin",
     *      @OA\Response(
     *          response=200,
     *          description="Checkin Data Get",
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
     * @OA\Put(
     *      path="/checkin/checkin/{id}",
     *      operationId="putCheckin",
     *      tags={"Checkin"},
     *      summary="Update Checkin",
     *      description="Update Checkin",
     *      @OA\Response(
     *          response=200,
     *          description="Checkin Data Update",
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
    public function update(UpdateCheckin $request, $id)
    {
        $item = $this->checkinService->update($request->all(), $id);
        return response()->json($item, 202);
    }

    /**
     * @OA\Delete(
     *      path="/checkin/checkin/{id}",
     *      operationId="deleteCheckin",
     *      tags={"Checkin"},
     *      summary="Delete Checkin",
     *      description="Delete Checkin",
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
        $this->checkinService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Xoá Checkin thành công.'
        ], 200);
    }
}
