<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Http\Request;
use App\Repositories\ContentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;
use App\Services\QdrantClient;
use App\Services\OpenAiClient;

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
        $this->IndexOne($content->id,new OpenAiClient,new QdrantClient);

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

            $manager = new ImageManager(new Driver());
            $resize_image = $manager->read($imgfile)->resize(300,300);

            //写真アップロード
            Storage::disk('public')->put(
                (string)$imgname,
                (string)$resize_image->encode()
            );


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

    public function IndexOne(int $contentId,OpenAiClient $opneai,QdrantClient $qdrant){

        $m = DB::table('contents')->where('id', $contentId)->first();
        
        //if ($m) return response()->json(['error' => 'memoru not found',404]);

        //embedding化するテキスト
        $text = trim(implode("\n",array_filter([
            "料理名:" . ($m->food_name ?? ''),
            "店名" . ($m->shop_name ?? ''),
            "コメント" .  ($m->thoughts ?? ''),
            "来店日" .  ($m->visit_date ?? ''),
        ])));

        $vec = $opneai->embed($text);

        // text-embedding-3-large はデフォルト3072次元
        $qdrant->ensureCollection(count($vec));

        $qdrant->upsert($m->id,$vec,[
            'user_id' => (int)$m->user_id
        ]);

    }

}