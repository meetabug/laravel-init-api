<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(3);
        return $users;
    }

    public function show(User $user)
    {
        return $user;
    }
    
    public function store(UserRequest $request)
    {
        User::create($request->all());
        return '用户注册成功。。。';
    }

    public function login(Request $request)
    {
        $res = Auth::guard('web')->attempt(['name'=>$request->name,'password'=>$request->password]);
        if($res){
            return '用户登录成功...';
        }
        return '用户登录失败';
    }
}