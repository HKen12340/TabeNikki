<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Content;


class ContentContoller extends Controller
{
    public function index(Request $request,Response $response){

        $content = Content::get();
        //dd($content); テスト用
        return view('index',['items' => $content]);
    }
}
