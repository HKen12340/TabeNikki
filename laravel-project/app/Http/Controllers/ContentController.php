<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Content;
use App\Http\Requests\ContentRequest;
use App\Services\ContentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function RagSearch(){
        return view("RagSereach");
    }
}
