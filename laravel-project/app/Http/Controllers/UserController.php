<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\UserService;


class UserController extends Controller
{

    public function showLogin(){
        return view('login');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(Request $request,UserService $service){
        $service->register($request);
        
        event(new UserRegistered($request));

        return redirect()->route('index');
    }

    public function profile(){
        return view("profile");
    }

    public function login(Request $request){

        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);
        

        //ユーザ情報照合
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('index');
        }
        
        //フラッシュエラーメッセージ
        return back()->withErrors(['msg' => 'メールアドレスかパスワードが間違っています']);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function notFound(){
        return redirect('/notFound');
    }
}
