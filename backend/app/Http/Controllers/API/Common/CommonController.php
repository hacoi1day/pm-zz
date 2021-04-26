<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\CheckUniqueRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    private $users;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function checkUnique (CheckUniqueRequest $request, $table, $column, $id = '')
    {
        try {
            $value = $request->input('value');
            $id = intval($id);
            switch ($table) {
                case 'users':
                    $item = $this->user->where($column, $value)->first();
                    if ($item && $item->id !== $id) return 0;
                    break;
            }
            return 1;
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra. ' + $e->getMessage()
            ], 500);
        }
    }
}
