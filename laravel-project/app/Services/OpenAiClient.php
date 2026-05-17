<?php
namespace App\Services;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;



class OpenAiClient{
    
    public Client $http;

    //GuzzleHttpライブラリのchatgpt初期接続
    public function __construct()
    {

        if(env('DEBUG_FLAG') == "true"){
            $this->http = new Client([
                'base_uri' => env('LOCAL_LLM_URL'),
                'timeout'  => 60,
                'headers'  => [
                    'Content-Type'  => 'application/json',
                ],
            ]);
        }else{
            $this->http = new Client([
                'base_uri' => env('LLM_URL'),
                'timeout'  => 60,
                'headers'  => [
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                    'Content-Type'  => 'application/json',
                ],
            ]);
        }
    }

    //chatgptに登録データを送ってベクトルに返還させる
    public function embed(string $text):array{

        $model = "";
        
        if(env('DEBUG_FLAG') == "true"){
            $model = 'nomic-embed-text';

            $res = $this->http->post('embeddings', [
                'json' => [
                    'model' => $model,
                    'prompt' => $text
                ],
            ]);
        }else{
            $model = 'text-embedding-3-large';

            $res = $this->http->post('embeddings', [
                'json' => [
                    'model' => $model,
                    'input'  => $text
                ],
            ]);
        }

        $json = json_decode((string)$res->getBody(), true);

        if(env('DEBUG_FLAG') == "true"){
            return $json;
        }else{
            return [$json['data'][0]['embedding']];
        }
    }

    //Qdrantから引き出したデータをcahtgptに乗せる
    public function answer(string $question,string $context): string{

        if(env('DEBUG_FLAG') == "true"){
            $model = 'gemma3:4b';
        }else{
            $model = 'gpt-5-mini';
        }


        
       $input = <<<TEXT
                あなたは「食べ歩きサービス」の思い出検索アシスタントです。
                与えられた候補メモ(CONTEXT)の範囲だけを根拠にこたえてください。
                候補がない場合は「見つかりませんでした」と返してください。
                また、出力する際は以下の形式で出力してください。

                出力形式
                検索に該当した料理は以下です。
                料理名 : [料理名](店名:[店名]、料金：[料金]円、場所：[場所]、訪問日：[訪問日]、感想：[感想])

                [QUESTION]
                {$question}

                [CONTEXT]
                {$context}
                TEXT;


        if(env('DEBUG_FLAG') == "true"){
            $res = $this->http->post('chat', [
                'json' => [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'user', 'content' => $input]
                    ],
                    'stream' => false, 
                ],
            ]);   
        }else{
            $res = $this->http->post('responses', [
                'json' => [
                    'model' => $model,
                    'input' => $input,
                ],
            ]);
        }

        $json = json_decode((string)$res->getBody(), true);

        if(env('DEBUG_FLAG') == "true"){
            return $json["message"]["content"];
        }else{
            return trim($json['output'][1]['content'][0]['text']);
        }
    }

}