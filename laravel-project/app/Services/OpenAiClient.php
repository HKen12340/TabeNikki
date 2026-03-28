<?php
namespace App\Services;
use GuzzleHttp\Client;

use Illuminate\Support\Facades\Log;


class OpenAiClient{
    
    public Client $http;

    public function __construct()
    {

        $this->http = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'timeout'  => 60,
            'headers'  => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type'  => 'application/json',
            ],
        ]);

    }


    public function test(){

    }

    public function embed(string $text):array{
        $model = env('OPENAI_CHAT_MODEL', 'text-embedding-3-large');

        $res = $this->http->post('embeddings', [
            'json' => [
                'model' => $model,
                'input' => "リンゴ"
            ],
        ]);

        $json = json_decode((string)$res->getBody(), true);
        return [$json['data'][0]['embedding']];
    }

    public function answer(string $question,string $context): string{
        $model = env('OPENAI_CHAT_MODEL', 'gpt-5-mini');

       $input = <<<TEXT
                あなたは「食べ歩きサービス」の思い出検索アシスタントです。
                与えられた候補メモ(CONTEXT)の範囲だけを根拠にこたえてください。
                候補がない場合は「見つかりませんでした」と返してください。
                [QUESTION]
                {$question}

                [CONTEXT]
                {$context}
                TEXT;

        $res = $this->http->post('responses', [
            'json' => [
                'model' => $model,
                'input' => $input,
            ],
        ]);

        if(isset($json['output_text'])){
            return (string)$json['output_text'];
        }

        $json = json_decode((string)$res->getBody(), true);



        // $out = '';
        // foreach(($json['output'] ?? []) as $item){
        //     foreach(($item['output'] ?? []) as $c){
        //         $out .= $c['text'] ?? '';
        //     }   
        // }
        
        return trim($json['output'][1]['content'][0]['text']);
    }

}