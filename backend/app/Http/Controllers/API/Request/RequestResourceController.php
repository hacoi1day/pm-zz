<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\IndexRequest;
use App\Http\Requests\Request\StoreRequest;
use App\Http\Requests\Request\UpdateRequest;
use App\Services\RequestService;
use Illuminate\Support\Facades\Auth;

class RequestResourceController extends Controller
{
    private $requestService;

    public function __construct(RequestService $requestService) {
        $this->requestService = $requestService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $paginate = $this->requestService->paginate($request->all());
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
    public function store(StoreRequest $request)
    {
        $params = $request->all();
        $item = $this->requestService->create($params);
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
        $item = $this->requestService->get($id);
        return response()->json($item, 200);
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
    public function update(UpdateRequest $request, $id)
    {
        $item = $this->requestService->update($request->all(), $id);
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
        $item = $this->request->find($id);
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete successfully'
        ], 200);
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
