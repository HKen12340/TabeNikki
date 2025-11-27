<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Content;
use App\Models\Image;
use App\Http\Requests\ContentRequest;

class ContentContoller extends Controller
{
    public function index(){
        $content = Content::with(['Image'])->where('user_id','=' ,Auth::user()->id)->get();
        //dd($content); //テスト用
        return view('index',['items' => $content]);
    }

    public function showContentRegistForm(){
        return view('regist_data');
    }

    public function registContent(ContentRequest $request){
        //dd($request);

        //バリデーション通過
        if($request->validated()){
            //食べ歩きデータ保存
            $content = Content::create([
                "food_name" => $request->food_name,
                "shop_name" => $request->shop_name,
                "price" => $request->price,
                "visit_date" => $request->visit_date,
                "place" => $request->place,
                "thoughts" => $request->thoughts,
                "user_id" => Auth::user()->id
            ]);


            //料理の写真をアップロード
            $food_img = $request->file("food_img");

            if($request->hasFile("food_img")){
                //拡張子の取得
                $food_img_extension = $food_img->getClientOriginalExtension();

                //料理の写真のファイル名を指定(food + ユーザーID_コンテンツID.ファイル拡張子)
                $food_img_name = "food".Auth::user()->id."_".$content->id.".".$food_img_extension;

                // 料理の写真を公開ディレクトリに保存
                Storage::putFileAs("public",$food_img,$food_img_name);

                $food_img_name = "storage/".$food_img_name;

            }else{
                $food_img_name = null;
            }

            //お店の写真をアップロード
            $shop_img = $request->file("shop_img");

            if($request->hasFile("shop_img")){
                //拡張子の取得
                $shop_img_extension = $shop_img->getClientOriginalExtension();

                //お店の写真のファイル名を指定(food + ユーザーID_コンテンツID.ファイル拡張子)
                $shop_img_name = "shop".Auth::user()->id."_".$content->id.".".$shop_img_extension;

                // 店の写真を公開ディレクトリに保存
                Storage::putFileAs("public",$shop_img,$shop_img_name);

                $shop_img_name = "storage/".$shop_img_name;
            }else{
                $shop_img_name = null;
            }


            //写真データの保存
            Image::create([
                "food_img" => $food_img_name,
                "shop_img" => $shop_img_name,
                "content_id" => $content->id,
            ]);
        }

        return redirect("/index");

    }
}
