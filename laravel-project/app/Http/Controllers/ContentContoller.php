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

            $food_img_name = $this->UploadImage($request,$content,"food_img");
            $shop_img_name = $this->UploadImage($request,$content,"shop_img");

            //写真データの保存
            Image::create([
                "food_img" => $food_img_name,
                "shop_img" => $shop_img_name,
                "content_id" => $content->id,
            ]);
        }

        return redirect("/index");
    }

    public function detailContent($id){
        $content = Content::where('id', '=' ,$id)->where('user_id','=',Auth::user()->id)->get();
        //実装予定
        //ユーザーIDとコンテンツのuser_idが異なる
        //もしくはそもそも指定されたコンテンツIDがない場合は404 NotFound ページを出す
        if(count($content) == 0){
            return redirect("/notFound");
        }

        return view('content',['items' => $content]);
    }

    public function updateForm($id){
        $content = Content::where('id', '=' ,$id)->where('user_id','=',Auth::user()->id)->get();

        if(count($content) == 0){
            return view("/notFound");
        }

        return view('update',['items' => $content]);
    }

    public function updateContent(ContentRequest $request){

        $content = Content::find($request->id);

        $content->updated([
            "food_name" => $request->food_name,
            "shop_name" => $request->shop_name,
            "price" => $request->price,
            "visit_date" => $request->visit_date,
            "place" => $request->place
        ]);

        //なんかバグあり
        $image = Image::where('content_id','=',$content->id)->first();
        $food_img_name = $image->food_img ?? null;
        $shop_img_name = $image->shop_img ?? null;

        if($request->hasFile("food_img")){
            $this->DeleteImage($content,"food_img");
            $food_img_name = $this->UploadImage($request,$content,"food_img");
        }

        if($request->hasFile("shop_img")){
            $this->DeleteImage($content,"shop_img");
            $shop_img_name = $this->UploadImage($request,$content,"shop_img");
        }

        $image->update([
            "food_img" => $food_img_name,
            "shop_img" => $shop_img_name,
        ]);

        return redirect("/index");
    }

    //写真アップロード関数 (リクエスト、Contentモデル、属性nameの名前)
    public function UploadImage(Request $request,Content $content,$filename){

        if($request->hasFile($filename)){
            //お店の写真をアップロード
            $imgfile = $request->file($filename);

            //拡張子の取得
            $img_extension = $imgfile->getClientOriginalExtension();

            //お店の写真のファイル名を指定(food + ユーザーID_コンテンツID.ファイル拡張子)
            $imgname = $filename."_".Auth::user()->id."_".$content->id.".".$img_extension;
            // 店の写真を公開ディレクトリに保存
            Storage::putFileAs("public",$imgfile,$imgname);

            return "storage/".$imgname;
        }else{
            return null;
        }
    }

    public function DeleteImage(Content $content,$filename){
        $image = Image::find($content->id);

        if($filename == "food_img" && $image && is_null($image->food_img)){
            Storage::delete($image->food_img);
        }else if($image && is_null($image->shop_img)){
            Storage::delete($image->shop_img);
        }
    }

}
