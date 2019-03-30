<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function index()
    {
        $admins = Admin::paginate(3);
        return AdminResource::collection($admins);
    }

    public function show(Admin $admin)
    {
        return $this->success(new AdminResource($admin));
    }
    
    public function store(AdminRequest $request)
    {
        Admin::create($request->all());
        return $this->setStatusCode(201)->success('用户注册成功');
    }

    public function login(Request $request)
    {
        $present_guard = Auth::getDefaultDriver();
        $token = Auth::claims(['guard'=>$present_guard])->attempt(['name' => $request->name, 'password' => $request->password]);
        if($token){
            $admin = Auth::user();
            if($admin->last_token) {
                try{
                    Auth::setToken($admin->last_token)->invalidate();
                }catch (TokenExpiredException $e){
                    //因为让一个过期的token再失效，会抛出异常，所以我们捕捉异常，不需要做任何处理
                }
            }
            $admin->last_token = $token;
            $admin->save();
            return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
        }
        return $this->failed('用户登录失败',401);
    }

    public function logout()
    {
        Auth::logout();
        return $this->success('退出成功...');
    }

    public function info()
    {
        $admin = Auth::user();
        return $this->success(new AdminResource($admin));
    }
}
