<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\IndexRequest;
use App\Http\Requests\Request\StoreRequest;
use App\Http\Requests\Request\UpdateRequest;
use App\Models\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class RequestResourceController extends Controller
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $paginate = $this->request
            ->where(function ($query) use ($request) {
                if ($request->has('status')) {
                    $query->where('status', $request->input('status'));
                }
            })
            ->paginate(10);
        $paginate->getCollection()->transform(function ($item) {
            $item->user;
            $item->approval;
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
    public function store(StoreRequest $request)
    {
        $params = $request->all();
        $params['user_id'] = Auth::guard('api')->id();
        if (!$request->has('status')) {
            $params['status'] = 1;
        }
        $item = $this->request->create($params);
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
        $item = $this->request->find($id);
        $item->user;
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
        $item = $this->request->find($id);
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
        $item = $this->request->find($id);
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete successfully'
        ], 200);
    }

    public function approvalRequest($request_id)
    {
        $request = $this->request->find($request_id);
        $request->update([
            'status' => 2,
            'approval_by' => Auth::guard('api')->id()
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Phê duyệt yêu cầu thành công.'
        ], 200);
    }

    public function refuseRequest($request_id)
    {
        $request = $this->request->find($request_id);
        $request->update([
            'status' => 3,
            'approval_by' => Auth::guard('api')->id()
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Từ chối yêu cầu thành công.'
        ], 200);
    }
}
