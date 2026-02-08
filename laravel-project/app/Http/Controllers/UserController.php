<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\NewUserIntroduction;
use Illuminate\Contracts\Mail\Mailer;
use App\Services\UserService;


class UserController extends Controller
{

    public function showLogin(){
        return view('login');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(Request $request,UserService $service,Mailer $mailer){
        $service->register($request);
        
        $mailer->to('test@exemple.com')
        ->send(new NewUserIntroduction);

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
