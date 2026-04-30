<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegistaration;

use App\Services\UserService;


class UserController extends Controller
{

    public function showLogin(){
        return view('login');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(UserRegistaration $request,UserService $service){
        if($request->validated()){

            $result = $service->register($request);
            
            if($result === false){
                return back()->withErrors(['msg' => '入力された情報はすでに使用されています']);
            }
     
           return redirect()->route('index');
        }
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
