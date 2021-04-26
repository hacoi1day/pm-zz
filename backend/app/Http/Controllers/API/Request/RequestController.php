<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\Controller;
use App\Models\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function myRequest()
    {
        try {
            $userId = Auth::guard('api')->id();
            $paginate = $this->request->where('user_id', $userId)->orderBy('created_at', 'asc')->paginate(10);
            $paginate->getCollection()->transform(function ($item) {
                $item->approval = $item->approval;
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
}
