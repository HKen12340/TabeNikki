<?php

namespace App\Services;

use GuzzleHttp\Client;

class QdrantClient{
    private Client $http;
    private string $collection;
    
    //Qdarnt初期接続
    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => trim(env('QDRANT_URL','http://qdrant:6333'),'/'),
            'timeout'  => 30,
            'headers'  => [
                'Content-Type'  => 'application/json',
            ],
        ]);

        $this->collection = env('QDRANT_COLLECTION','memories');
    }

    //コレクション作成
    public function ensureCollection(int $vectorSize) : void
    {
        try{
            $this->http->get("collections/{$this->collection}");
            return;
        }catch(\Throwable $e){

        }

        $this->http->put("collections/{$this->collection}",[
            'json' => [
                'vectors' => [
                    'size' => $vectorSize,
                    'distance' => 'Cosine',
                ],
            ],
        ]);

    }


    //コレクションに要素登録
    public function upsert(int $id,array $vector,array $palyload = []):void{


        $res = $this->http->put("collections/{$this->collection}/points", [
            'json' => [
                'points' => [
                    [
                        'id' => $id,
                        'vector' => $vector[0],
                        'payload' => $palyload
                    ]
                ],
            ],
        ]);

    }

    public function search(array $vector,int $limit = 5):array{
        $res = $this->http->post("collections/{$this->collection}/points/search",[
                'json' => [
                    'vector' => $vector[0],
                    'limit' => $limit,
                    'with_payload' => true
                ]
        ]);

        $json = json_decode((string)$res->getBody(), true);

        return $json['result'] ?? [];
    }
    
}