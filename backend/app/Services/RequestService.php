<?php

namespace App\Services;

use App\Jobs\Request\SendMail;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RequestService
{
    private $request;
    private $user;

    public function __construct(Request $request, User $user) {
        $this->request = $request;
        $this->user = $user;
    }

    public function paginate($params)
    {
        $paginate = $this->request
            ->where(function ($query) use ($params) {
                if (array_key_exists('status', $params)) {
                    $query->where('status', $params['status']);
                }
            })
            ->paginate(10);
        $paginate->getCollection()->transform(function ($item) {
            $item->user;
            $item->approval;
            return $item;
        });
        return $paginate;
    }

    public function create($params)
    {
        $params['user_id'] = Auth::guard('api')->id();
        if (!array_key_exists('status', $params)) {
            $params['status'] = 1;
        }
        $item = $this->request->create($params);
        return $item;
    }

    public function get($id)
    {
        $item = $this->request->findOrFail($id);
        $item->user;
        return $item;
    }

    public function update($params, $id)
    {
        $item = $this->get($id);
        $item->update($params);
        return $item;
    }

    public function delete($id)
    {
        $item = $this->get($id);
        $item->delete();
        return true;
    }

    public function approvalRequest($requestId)
    {
        $request = $this->get($requestId);
        $request->update([
            'status' => 2,
            'approval_by' => Auth::guard('api')->id()
        ]);
        return true;
    }

    public function refuseRequest($requestId)
    {
        $request = $this->get($requestId);
        $request->update([
            'status' => 3,
            'approval_by' => Auth::guard('api')->id()
        ]);
        return true;
    }

    public function myRequest()
    {
        $userId = Auth::guard('api')->id();
        $paginate = $this->request->where('user_id', $userId)->oldest()->with('approval')->paginate(10);
        // $paginate->getCollection()->transform(function ($item) {
        //     $item->approval = $item->approval;
        //     return $item;
        // });
        return $paginate;
    }

    public function createMyRequest($params)
    {
        $user = Auth::guard('api')->user();
        $params['user_id'] = $user->id;
        $params['status'] = array_key_exists('status', $params) ? $params['status'] : 1;
        $request = $this->request->create($params);

        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'project' => $request->project,
            'cause' => $request->cause
        ];

        // send mail to root account
        $root = $this->user->where('role_id', 1)->first();
        if ($root) {
            SendMail::dispatch($root->email, $data)->delay(now());
        }
        // send mail to manager account
        $manager = optional($user->department)->manager;
        if ($manager) {
            SendMail::dispatch($manager->email, $data)->delay(now());
        }
        return $request;
    }
}
