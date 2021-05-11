<?php

namespace App\Http\Controllers\API\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request\StoreRequest;
use App\Jobs\Request\SendMail;
use App\Models\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    private $request;
    private $user;

    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function myRequest()
    {
        $userId = Auth::guard('api')->id();
        $paginate = $this->request->where('user_id', $userId)->orderBy('created_at', 'asc')->paginate(10);
        $paginate->getCollection()->transform(function ($item) {
            $item->approval = $item->approval;
            return $item;
        });
        return response()->json($paginate, 200);
    }

    public function createMyRequest(StoreRequest $request)
    {
        $params = $request->all();

        $user = Auth::guard('api')->user();
        $params['user_id'] = $user->id;
        if (!$request->has('status')) {
            $params['status'] = 1;
        }
        $item = $this->request->create($params);

        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'project' => $item->project,
            'cause' => $item->cause
        ];

        // send mail to root account
        $root = $this->user->where('role_id', 1)->first();
        if ($root) {
            SendMail::dispatch($root->email, $data)->delay(Carbon::now());
        }
        // send mail to manager account
        $manager = $user->department->manager;
        if ($root) {
            SendMail::dispatch($manager->email, $data)->delay(Carbon::now());
        }

        return response()->json($item, 201);
    }
}
