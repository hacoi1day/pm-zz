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
        try {

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
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
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
        try {
            $params = $request->all();
            $params['user_id'] = Auth::guard('api')->id();
            if (!$request->has('status')) {
                $params['status'] = 1;
            }
            $item = $this->request->create($params);
            return response()->json($item, 201);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $item = $this->request->find($id);
            $item->user;
            return response()->json($item, 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
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
        try {
            $item = $this->request->find($id);
            $item->update($request->all());
            return response()->json($item, 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->request->find($id);
            $item->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Delete successfully'
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function approvalRequest($request_id)
    {
        try {
            $request = $this->request->find($request_id);
            $request->update([
                'status' => 2,
                'approval_by' => Auth::guard('api')->id()
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Phê duyệt yêu cầu thành công.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function refuseRequest($request_id)
    {
        try {
            $request = $this->request->find($request_id);
            $request->update([
                'status' => 3,
                'approval_by' => Auth::guard('api')->id()
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Từ chôi yêu cầu thành công.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
