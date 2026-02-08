<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\NewUserIntroduction;
use Illuminate\Contracts\Mail\Mailer;


class UserController extends Controller
{

    public function showLogin(){
        return view('login');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(Request $request,Mailer $mailer){

        //ユーザ情報重複チェック
        if(User::where('name','=',$request->name)->exists() || User::where('email','=',$request->email)->exists()){
            return back();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //ウェルカムメール送信
        $mailer->to('test@exemple.com')
        ->send(new NewUserIntroduction);

        //ログイン実行
        Auth::login($user);
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
