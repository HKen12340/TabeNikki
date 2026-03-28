<?php

namespace App\Http\Controllers;

use App\Services\QdrantClient;
use App\Services\OpenAiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RAGController extends Controller
{
    // public function IndexOne(int $contentId,OpenAiClient $opneai,QdrantClient $qdrant){
    //     $m = DB::table('contents')->where('id', $contentId)->get();
    //     if ($m) return response()->json(['error' => 'memoru not found',404]);

    //     //embedding化するテキスト
    //     $text = trim(implode("\n",array_filter([
    //         "料理名:" . ($m->food_name ?? ''),
    //         "店名" . ($m->shop_name ?? ''),
    //         "コメント" .  ($m->thoughts ?? ''),
    //         "来店日" .  ($m->visit_date ?? ''),
    //     ])));

    //     $vec = $opneai->embed($text);

    //     // text-embedding-3-large はデフォルト3072次元
    //     $qdrant->ensureCollection(count($vec));

    //     $qdrant->upsert($m->id,[
    //         'user_id' => (int)$m->user_id
    //     ]);

    // }

    public function search(Request $request,OpenAiClient $opneai,QdrantClient $qdrant){
        $request->validate([
            // 'user_id' => ['required','integer'],
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

        if(count($ids) === 0){
            // return response()->json([
            //     'answer' => '見つかりませんでした(候補データがありません)',
            //     'candidates' => []
            // ]);
        }

        $rows = DB::table('contents')->whereIn('id',$ids)->get();

        $context = $rows->map(function($m){
            return implode("\n",array_filter([
                "ID: {$m->id}",
                "料理名:" . ($m->food_name ?? ''),
                "店名" . ($m->shop_name ?? ''),
                "コメント" .  ($m->thoughts ?? ''),
                "来店日" .  ($m->visit_date ?? ''),
            ]));
        })->implode("\n\n---\n\n");

        $answer = $opneai->answer($q,$context);


        // return response()->json([
        //     'answer' => $answer,
        //     'candidates' => $rows,
        // ]);
        return view('RagSearch',['answer' => $answer]);

    }


}
