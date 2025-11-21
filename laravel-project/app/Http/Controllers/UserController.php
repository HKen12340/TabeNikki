<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function showLogin(){
        return view('login');
    }

    public function showRegister(){
        return view('register');
    }

    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('profile');
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
            return redirect()->intended('profile');
        }

        return back();
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
