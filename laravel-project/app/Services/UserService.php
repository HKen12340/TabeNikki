<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Events\UserRegistered;

class UserService{

    private $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function register(Request $request){
        
        //ユーザ情報重複チェック
        if($this->repo->UserInfoExists($request)){
            return false;
        }

        $user = $this->repo->UserCreate($request);

        //デプロイ先でメール送信環境が準備できていないので無効化
        // event(new UserRegistered($request));

        //ログイン実行
        Auth::login($user);
    }

}