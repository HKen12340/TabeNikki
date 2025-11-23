<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Content;

class ContentContoller extends Controller
{
    public function index(Request $request,Response $response){
        $content = Content::where('user_id','=' ,Auth::user()->id)->get();
        //dd($content); テスト用
        return view('index',['items' => $content]);
    }

    public function showContentRegistForm(){
        return view('regist_data');
    }

    public function registContent(Request $request){

        Storage::put("", "");

    }
}
