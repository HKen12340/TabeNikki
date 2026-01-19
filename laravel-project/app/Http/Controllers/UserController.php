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

        if(count(User::where('name','=',$request->name)->get()) || count(User::where('email','=',$request->email)->get())){
            return back();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $mailer->to('test@exemple.com')
        ->send(new NewUserIntroduction);

        Auth::login($user);
        return redirect()->route('index');
    }

    public function profile(){
        return view("profile");
    }

    public function login(Request $request){

        //受け取った値をバリデーション検証
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        //DBで値の照合を行う
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
        redirect('/notFound');
    }
}
