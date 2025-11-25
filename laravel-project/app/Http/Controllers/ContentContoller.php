<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Content;
use App\Models\Image;

class ContentContoller extends Controller
{
    public function index(Request $request,Response $response){
        $content = Content::with(['Image'])->where('user_id','=' ,Auth::user()->id)->get();
        //dd($content); //テスト用
        //dump($content);
        return view('index',['items' => $content]);//,'images' => $images
    }

    public function showContentRegistForm(){
        return view('regist_data');
    }

    public function registContent(Request $request){
        //dd($request);

        $content = Content::create([
            "food_name" => $request->food_name,
            "shop_name" => $request->shop_name,
            "price" => $request->price,
            "visit_date" => $request->visit_date,
            "place" => $request->place,
            "thoughts" => $request->thoughts,
            "user_id" => Auth::user()->id
        ]);



        $food_img = " ";
        $food_img = $request->file("food_img");

        //拡張子の取得
        $food_img_extension = $food_img->getClientOriginalExtension();

        $food_name = "food".Auth::user()->id."_".$content->id.".".$food_img_extension;

        // 料理の写真を公開ディレクトリに保存
        Storage::putFileAs("public",$food_img,$food_name);

        $shop_img = " ";
        $shop_img = $request->shop_img;

        //拡張子の取得
        $shop_img_extension = $shop_img->getClientOriginalExtension();

        $shop_name = "shop".Auth::user()->id."_".$content->id.".".$shop_img_extension;

        // 店の写真を公開ディレクトリに保存
        Storage::putFileAs("public",$shop_img,$shop_name);

        Image::create([
            "food_img" => "storage/".$food_name,
            "shop_img" => "storage/".$shop_name,
            "content_id" => $content->id,
        ]);

        return redirect("/index");

    }
}
