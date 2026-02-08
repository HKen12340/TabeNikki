<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface{
    
    public function UserCreate(Request $request){
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    public function UserInfoExists(Request $request){
       return User::where('name','=',$request->name)->exists() 
       || User::where('email','=',$request->email)->exists();
    }

}