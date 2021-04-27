<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUser;
use App\Jobs\Mail\User\StoreUserMail;
use App\Models\ChangePass;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResourceController extends Controller
{
    private $user;
    private $changePass;

    public function __construct(User $user, ChangePass $changePass) {
        $this->user = $user;
        $this->changePass = $changePass;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $paginate = $this->user->paginate(10);
            $paginate->getCollection()->transform(function ($item) {
                $item->department;
                return $item;
            });
            return response()->json($paginate, 200);
        } catch (Exception $e) {
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
    public function store(StoreUser $request)
    {
        try {
            $params = $request->all();
            $password = (array_key_exists('password', $params) && !is_null($params['password'])) ? $params['password'] : Str::random(6);
            $params['password'] = Hash::make($password);

            $item = $this->user->create($params);

            $message = [
                'type' => 'Store user',
                'email' => $item->email,
                'password' => $password,
                'content' => 'User has been created!',
            ];

            StoreUserMail::dispatch($message, $item)->delay(Carbon::now());

            return response()->json($item, 201);
        } catch (Exception $e) {
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
            $item = $this->user->find($id);
            return response()->json($item, 200);
        } catch (Exception $e) {
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
    public function update(Request $request, $id)
    {
        try {
            $item = $this->user->find($id);
            $params = $request->all();
            if (array_key_exists('password', $params)) {
                $params['password'] = Hash::make($params['password']);
            }
            $item->update($params);
            return response()->json($item, 202);
        } catch (Exception $e) {
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
            $item = $this->user->find($id);
            $item->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Delete successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function dropdown()
    {
        try {
            $items = $this->user->all();
            $result = [];
            foreach ($items as $item) {
                array_push($result, [
                    'id' => $item->id,
                    'name' => $item->name,
                ]);
            }
            return response()->json($result, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
