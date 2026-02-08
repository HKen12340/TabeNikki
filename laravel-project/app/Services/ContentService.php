<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Repositories\ContentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use RuntimeException;
use App\Http\Requests\ContentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class ContentService
{
    private $repo;

    public function __construct(ContentRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(){
        return $this->repo->index();
    }

    public function registContent(Request $request){
        $content = $this->repo->registContent($request);

        $food_img_name = $this->UploadImage($request,$content,"food_img");
        $shop_img_name = $this->UploadImage($request,$content,"shop_img");

        $this->repo->registImage($content,$food_img_name,$shop_img_name);

    }

    public function detailContent(Request $request){
        try{
            return $this->repo->detailContent($request);
        }catch(ModelNotFoundException){
            return throw new ModelNotFoundException;
        }
    }

     public function updateContent(ContentRequest $request){
        
        try{
                $content = $this->repo->updateContent($request);
                $image = $this->repo->updateTragetImage($content);

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

            }catch(ModelNotFoundException){
                return throw new ModelNotFoundException;
            }
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

            //リソースの開放
            imagedestroy($original_image);
            imagedestroy($canvas);

            return "storage/".$imgname;

        }else{
            return "storage/NoImage.png";
        }
    }

     public function DeleteContent(Request $request)
    {
         $contents =  $this->repo->deleteTragetContent($request);

            if($this->repo->deleteContentExists($request)){
                foreach($contents as $content){
                    if($content->Image->food_img != "storage/NoImage.png"){
                        $this->DeleteImage($content->Image->id,"food_img");
                    }

                    if($content->Image->shop_img != "storage/NoImage.png"){
                            $this->DeleteImage($content->Image->id,"shop_img");
                    }
                }
                $this->repo->DeleteContent($request);
            }
    }

    public function DeleteImage($img_id,$filename){
        $image = $this->repo->ImageFind($img_id);

        if($filename == "food_img"){
            $str = str_replace("storage/","public/",$image->food_img);
            Storage::delete($str);
        }else{
            $str = str_replace("storage/","public/",$image->shop_img);
            Storage::delete($str);
        }

    }

    public function SearchContent(Request $request){
        return $this->repo->SearchContent($request);
    }

}