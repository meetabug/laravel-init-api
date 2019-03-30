<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(3);
        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        return $this->success(new UserResource($user));
    }
    
    public function store(UserRequest $request)
    {
        User::create($request->all());
        return $this->setStatusCode(201)->success('用户注册成功');
    }

    public function login(Request $request)
    {
        $token = Auth::guard('api')->attempt(['name'=>$request->name,'password'=>$request->password]);
        if($token){
            return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
        }
        return $this->failed('用户登录失败',401);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->success('退出成功...');
    }

    public function info()
    {
        $user = Auth::guard('api')->user();
        return $this->success(new UserResource($user));
    }
}
