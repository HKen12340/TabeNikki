<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Content;

class ContentContoller extends Controller
{
    public function index(Request $request,Response $response){
        $content = Content::all();
        //dd($content);
        return view('test',['items' => $content]);
    }
}
