<?php
namespace App\Repositories;

use Illuminate\Http\Request;

interface UserRepositoryInterface{
    public function UserCreate(Request $request);
    public function UserInfoExists(Request $request);
}