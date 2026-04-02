<?php

namespace App\Http\Controllers;

use App\Services\QdrantClient;
use App\Services\OpenAiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RAGController extends Controller
{

    public function search(Request $request,OpenAiClient $opneai,QdrantClient $qdrant){
        $request->validate([
            'q' => ['required','string','max:500']
        ]);

        $userId = (int)Auth::user()->id;
        $q = $request->input('q');
        
        $qVec = $opneai->embed($q);
    
        $hits = $qdrant->search($qVec,5);

        $ids = [];

        foreach($hits as $h){
            if((int)($h['payload']['user_id'] ?? 0) === $userId){
                $ids[] = (int)$h['id'];
            }
        }

        $rows = DB::table('contents')->whereIn('id',$ids)->get();

        $context = $rows->map(function($m){
            return implode("\n",array_filter([
                "ID: {$m->id}",
                "料理名:" . ($m->food_name ?? ''),
                "店名:" . ($m->shop_name ?? ''),
                "料金:" . ($m->price ?? ''),
                "場所:" . ($m->place ?? ''),
                "コメント:" .  ($m->thoughts ?? ''),
                "来店日:" .  ($m->visit_date ?? '')
            ]));
        })->implode("\n\n---\n\n");

    

        $answer = $opneai->answer($q,$context);

        return view('RagSearch',['answer' => $answer]);

    }


}
