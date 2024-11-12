<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;



class AuthController extends Controller
{

    public function index(){

        if(Auth::id() >0 ){

            return redirect()->route('dashboard.index');
        }
        return view('backend.auth.login');
    }

    public function login(LoginRequest $request){
        $credentials =[
            'email' => $request-> input('email'),
            'password' => $request-> input('password'),
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index')-> with('success','Đăng nhập thành công');
        }else {
            return redirect()->route('auth.admin')-> with('error','Email hoặc mật khẩu sai!');
        }
    }

    public function logout(Request $request): RedirectResponse{
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin');
    }
}
