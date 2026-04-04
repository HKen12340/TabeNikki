<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\User;
use App\Http\Requests\ContentRequest;
use App\Services\ContentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use App\Mail\RandomFoodRecMail;

class ContentController extends Controller
{

    public function index(ContentService $service){
        $result = $service->index();
        return view('index',['items' => $result]);
    }

    public function showContentRegistForm(){
        return view('CreateData');
    }

    public function registContent(ContentRequest $request,ContentService $service){

        //バリデーション通過
        if($request->validated()){
            $content = $service->registContent($request);
        }

        return redirect("/index");
    }

    public function detailContent(Request $request){
        try{
            $content = Content::where('id', '=' ,$request->id)->where('user_id','=',Auth::user()->id)->firstOrfail();
        }catch(ModelNotFoundException){
            return view("404NotFound");
        }
        return view('content',['item' => $content]);
    }

    public function updateForm(Request $request){

        try{
            $content = Content::where('id', '=' ,$request->id)->where('user_id','=',Auth::user()->id)->firstOrfail();
        }catch(ModelNotFoundException){
            return view("404NotFound");
        }

        return view('EditData',['item' => $content]);
    }

    public function updateContent(ContentRequest $request,ContentService $service){
        try{
            $service->updateContent($request);
            return redirect("/index");
        }catch(ModelNotFoundException){
            return view("404NotFound");
        }
    }


    public function DeleteImage($img_id,$filename,ContentService $service){
        $service->DeleteImage($img_id,$filename);
    }

    public function DeleteContent(Request $request,ContentService $service){
        $service->DeleteContent($request);
        return redirect('/index');
    }

    //ヘッダー部分の料理と店の検索機能
    public function SearchContent(Request $request,ContentService $service){
         $result = $service->SearchContent($request);
         return view('/index',['items' => $result]);
    }

    public function RagSearchForm(){
        return view("/RagSearch");
    }

    public function TestMail(){
        return view("/testmail");
    }

    public function TestMailSend(){
        $user = User::where('id',Auth::user()->id)->first();

        //dd($user);
        //ランダムで選ばれた料理情報を載せたメールを総世親

            //ユーザIDに該当する料理を抽出
            $test = Content::where('user_id',$user->id)->get();

            $max = Content::where('user_id',$user->id)->count();

            if($max != 0){
                //ランダムで料理を選ぶ
                $mail_content = $test->get(rand(0,$max));

                //メール送信
                Mail::to($user->email)
                ->send(new RandomFoodRecMail($user,$mail_content));
            }
        return view("/testmail",["msg" => "メールの送信が成功しました"]);
    }
}
