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
        $model = env('OPENAI_CHAT_MODEL', 'gpt-5-mini');


       $input = <<<TEXT
                自己紹介してください
                TEXT;

        $res = $this->http->post('responses', [
            'json' => [
                'model' => $model,
                'input' => $input,
            ],
        ]);

        $json = json_decode((string)$res->getBody(), true);


        dd($json['output']);
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
        dd($json['data'][0]["embedding"]);
        return [];
    }

    public function answer(string $question,string $context): string{
        return "";
    }

}