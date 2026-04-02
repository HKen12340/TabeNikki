<?php
namespace App\Services;
use GuzzleHttp\Client;


class OpenAiClient{
    
    public Client $http;

    //GuzzleHttpライブラリのchatgpt初期接続
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

    //chatgptに登録データを送ってベクトルに返還させる
    public function embed(string $text):array{
        $model = env('OPENAI_CHAT_MODEL', 'text-embedding-3-large');

        $res = $this->http->post('embeddings', [
            'json' => [
                'model' => $model,
                'input' => $text
            ],
        ]);
        $json = json_decode((string)$res->getBody(), true);
        return [$json['data'][0]['embedding']];
    }

    //Qdrantから引き出したデータをcahtgptに乗せる
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


        $json = json_decode((string)$res->getBody(), true);

        
        return trim($json['output'][1]['content'][0]['text']);
    }

}