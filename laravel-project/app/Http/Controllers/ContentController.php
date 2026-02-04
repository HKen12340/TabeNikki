<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Content;
use App\Models\Image;
use App\Http\Requests\ContentRequest;
use RuntimeException;
use odelNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContentController extends Controller
{

    public function index(){
        $content = Content::with(['Image'])->where('user_id','=' ,Auth::user()->id)->
        orderBy('created_at','desc')->paginate(6);
        return view('index',['items' => $content]);
    }

    public function showContentRegistForm(){
        return view('regist_data');
    }

    public function registContent(ContentRequest $request){

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
        try{
            $content = Content::where('id', '=' ,$id)->where('user_id','=',Auth::user()->id)->firstOrfail();
        }catch(ModelNotFoundException){
            return view("404NotFound");
        }
        return view('content',['item' => $content]);
    }

    public function updateForm($id){

        try{
            $content = Content::where('id', '=' ,$id)->where('user_id','=',Auth::user()->id)->firstOrfail();
        }catch(ModelNotFoundException){
            return view("404NotFound");
        }

        return view('update',['item' => $content]);
    }

    public function updateContent(ContentRequest $request){

        $content = Content::find($request->id);
        
        Content::where('id',$request->id)->update([
            "food_name" => $request->food_name,
            "shop_name" => $request->shop_name,
            "price" => $request->price,
            "visit_date" => $request->visit_date,
            "thoughts" => $request->thoughts,
            "place" => $request->place
        ]);

        $image = Image::where('content_id','=',$content->id)->first();
        $food_img_name = $image->food_img;
        $shop_img_name = $image->shop_img;

        if($request->hasFile("food_img")){
            $this->DeleteImage($image->id,"food_img");
            $food_img_name = $this->UploadImage($request,$content,"food_img");
        }

        if($request->hasFile("shop_img")){
            $this->DeleteImage($image->id,"shop_img");
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


                //加工前の画像情報を取得
            list($original_w,$original_h,$type) = getimagesize($imgfile);

            //加工したいファイルをフォーマット別に読み出す
            switch($type){
                case IMAGETYPE_JPEG:
                    $original_image = imagecreatefromjpeg($imgfile);
                    break;
                case IMAGETYPE_PNG:
                    $original_image = imagecreatefrompng($imgfile);
                    break;
                case IMAGETYPE_GIF:
                    $original_image = imagecreatefromgif($imgfile);
                    break;
                default:
                    throw new RuntimeException('対応していないファイル形式です:',$type);
            }

            // 元の画像のサイズを取得
            $source_width = imagesx($original_image);
            $source_height = imagesy($original_image);

            $canvas = imagecreatetruecolor(100,100);
            imagecopyresampled($canvas,$original_image,0,0,0,0,"100","100",$source_width,$source_height);

            $file_path = public_path("storage/".$imgname);

            switch($type){
                case IMAGETYPE_JPEG:
                    imagejpeg($canvas,$file_path);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($canvas,$file_path,9);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($canvas,$file_path);
                    break;
            }

            
            imagedestroy($original_image);
            imagedestroy($canvas);

            return "storage/".$imgname;

        }else{
            return "storage/NoImage.png";
        }

    }


    public function DeleteImage($img_id,$filename){
        $image = Image::find($img_id);

        if($filename == "food_img"){
            $str = str_replace("storage/","public/",$image->food_img);
            Storage::delete($str);
        }else{
            $str = str_replace("storage/","public/",$image->shop_img);
            Storage::delete($str);
        }

    }

    public function DeleteContent(Request $request,$id){
            
        $contents =  Content::with(['Image'])->where('user_id' ,Auth::user()->id )->where('id' , $id)->get();

            if($contents->count() > 0){
                foreach($contents as $content){
                    if($content->Image->food_img != "storage/NoImage.png"){
                        $this->DeleteImage($content->Image->id,"food_img");
                    }

                    if($content->Image->shop_img != "storage/NoImage.png"){
                            $this->DeleteImage($content->Image->id,"shop_img");
                    }
                }

                Content::where('user_id' ,Auth::user()->id )->where('id' , $id)->first()->delete();
                //削除がカスケードされ、content_id(外部キー)でつながっているimagesテーブルのレコードも削除される
            }
        
        return redirect('/index');
    }
}
