<?php
namespace App\Repositories;

use App\Models\Content;
use App\Models\Image;
use App\Repositories\ContentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ContentRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContentRepository implements ContentRepositoryInterface{

    public function index()
    {
        return Content::with(['Image'])->where('user_id','=' ,Auth::user()->id)->
        orderBy('created_at','desc')->paginate(6);
    }

    public function registContent(Request $request){

            return Content::create([
                "food_name" => $request->food_name,
                "shop_name" => $request->shop_name,
                "price" => $request->price,
                "visit_date" => $request->visit_date,
                "place" => $request->place,
                "thoughts" => $request->thoughts,
                "user_id" => Auth::user()->id
            ]);

    }

    public function registImage(Content $content,string $food_img_name,string $shop_img_name){
        Image::create([
            "food_img" => $food_img_name,
            "shop_img" => $shop_img_name,
            "content_id" => $content->id,
        ]);
    }

    public function updateContent(ContentRequest $request)
    {
        try{
            $content = Content::where('id', '=' ,$request->id)->
            where('user_id','=',Auth::user()->id)->firstOrfail();

            Content::where('id',$request->id)->update([
                "food_name" => $request->food_name,
                "shop_name" => $request->shop_name,
                "price" => $request->price,
                "visit_date" => $request->visit_date,
                "thoughts" => $request->thoughts,
                "place" => $request->place
            ]);

        }catch(ModelNotFoundException){
             throw new ModelNotFoundException;
        }

        return $content;
    }


    public function DeleteContent(Request $request)
    {
        Content::where('user_id' ,Auth::user()->id )->
        where('id' , $request->id)->first()->delete();
        /*削除がカスケードされ、content_id(外部キー)でつながっている
        imagesテーブルのレコードも削除される*/
    }

    public function SearchContent(Request $request)
    {
        return Content::where("food_name","like","%{$request->SearchText}%")->where('user_id',Auth::user()->id)->
         orWhere("shop_name","like","%{$request->SearchText}%")->where('user_id',Auth::user()->id)->
         orderBy('created_at','desc')->paginate(6);
    }

    public function detailContent(Request $request)
    {
        return Content::where('id', '=' ,$request->id)->
        where('user_id','=',Auth::user()->id)->firstOrFail();
    }

    public function updateTragetImage(Content $content){
       return Image::where('content_id','=',$content->id)->first();
    }

    public function deleteTragetContent(Request $request){
         return Content::with(['Image'])->where('user_id' ,Auth::user()->id )->
         where('id' , $request->id)->get();
    }

    public function deleteContentExists(Request $request){
        return Content::with(['Image'])->where('user_id' ,Auth::user()->id )->
        where('id' , $request->id)->exists();
    }

    public function ImageFind($img_id)
    {
        return Image::find($img_id);
    }
    
}
