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

    public function checkUnique (CheckUniqueRequest $request, $table, $column, $id = '')
    {
        $value = $request->input('value');
        $check = $this->commonService->checkUnique($value, $table, $column, $id);
        return $check;
    }
}
