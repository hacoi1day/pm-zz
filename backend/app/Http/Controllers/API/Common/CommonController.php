<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\CheckUniqueRequest;
use App\Models\User;
use App\Services\CommonService;
use Exception;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    private $commonService;

    public function __construct(CommonService $commonService) {
        $this->commonService = $commonService;
    }

    /**
     * @OA\Get(
     *      path="/common/check-unique/{table}/{column}/{id?}",
     *      operationId="getCheckUnique",
     *      tags={"Common"},
     *      summary="Get Check Unique",
     *      description="Get Check Unique",
     *      @OA\Response(
     *          response=200,
     *          description="Checkin Unique Status",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function checkUnique (CheckUniqueRequest $request, $table, $column, $id = '')
    {
        $value = $request->input('value');
        $check = $this->commonService->checkUnique($value, $table, $column, $id);
        return $check;
    }
}
