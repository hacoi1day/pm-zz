<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\StoreRequest;
use App\Jobs\Request\SendMail;
use App\Models\Request;
use App\Models\User;
use App\Services\RequestService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    private $requestService;

    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * @OA\Get(
     *      path="/my-request",
     *      operationId="getMyRequest",
     *      tags={"Request"},
     *      summary="My Request",
     *      description="My Request",
     *      @OA\Response(
     *          response=200,
     *          description="Paginate My Request",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function myRequest()
    {
        $paginate = $this->requestService->myRequest();
        return response()->json($paginate, 200);
    }

    /**
     * @OA\Post(
     *      path="/create-my-request",
     *      operationId="postCreateMyRequest",
     *      tags={"Request"},
     *      summary="Create My Request",
     *      description="Create My Request",
     *      @OA\Response(
     *          response=201,
     *          description="Create My Request",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function createMyRequest(StoreRequest $request)
    {
        $params = $request->all();
        $item = $this->requestService->createMyRequest($params);
        return response()->json($item, 201);
    }
}
