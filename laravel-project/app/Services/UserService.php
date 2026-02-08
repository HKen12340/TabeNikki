<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;

class UserService{

    private $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function register(Request $request){
        
        //ユーザ情報重複チェック
        if($this->repo->UserInfoExists($request)){
            return back();
        }

        //ユーザ作成
        $user = $this->repo->UserCreate($request);

        //ログイン実行
        Auth::login($user);
    }

}