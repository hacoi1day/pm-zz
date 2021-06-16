<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DropdownUserRequest;
use App\Http\Requests\User\StoreUser;
use App\Models\ChangePass;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserResourceController extends Controller
{
    private $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *      path="/user/user",
     *      operationId="getPaginateUser",
     *      tags={"User"},
     *      summary="Paginate User",
     *      description="Paginate User",
     *      @OA\Response(
     *          response=200,
     *          description="Paginate User Data",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = $this->userService->paginate();
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
     * @OA\Post(
     *      path="/user/user",
     *      operationId="postStoreUser",
     *      tags={"User"},
     *      summary="Store User",
     *      description="Store User",
     *      @OA\Response(
     *          response=200,
     *          description="User Data Store",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $params = $request->all();
        $user = $this->userService->create($params);
        return response()->json($user, 201);
    }

    /**
     * @OA\Get(
     *      path="/user/user/{id}",
     *      operationId="getUser",
     *      tags={"User"},
     *      summary="Get User",
     *      description="Get User",
     *      @OA\Response(
     *          response=200,
     *          description="User Data Get",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->userService->get($id);
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
     * @OA\Put(
     *      path="/user/user/{id}",
     *      operationId="putUser",
     *      tags={"User"},
     *      summary="Update User",
     *      description="Update User",
     *      @OA\Response(
     *          response=200,
     *          description="User Data Update",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = $request->all();
        $user = $this->userService->update($params, $id);
        return response()->json($user, 202);
    }

    /**
     * @OA\Delete(
     *      path="/user/user/{id}",
     *      operationId="deleteUser",
     *      tags={"User"},
     *      summary="Delete User",
     *      description="Delete User",
     *      @OA\Response(
     *          response=200,
     *          description="Status Message",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Xoá nhân viên thành công.'
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/user/dropdown",
     *      operationId="getDropdownUser",
     *      tags={"User"},
     *      summary="Dropdown User",
     *      description="Dropdown User",
     *      @OA\Response(
     *          response=200,
     *          description="List Dropdown User",
     *          @OA\JsonContent()
     *       )
     *     )
     */
    public function dropdown(DropdownUserRequest $request)
    {
        $role_id = $request->get('role_id', '');
        $result = $this->userService->dropdown($role_id);
        return response()->json($result, 200);
    }
}
