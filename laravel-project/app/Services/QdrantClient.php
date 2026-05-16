<?php

namespace App\Services;

use GuzzleHttp\Client;

class QdrantClient{
    private Client $http;
    private string $collection;
    private int $vector_size;

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

        if(env('DEBUG_FLAG') == "true"){
            $this->vector_size = 768;
            $this->collection = env('QDRANT_COLLECTION','local_memories');
        }else{
            $this->vector_size = 3072;
            $this->collection = env('QDRANT_COLLECTION','memories');
        }   

        
    }

    //コレクション作成
    public function ensureCollection() : void
    {
        try{
            $this->http->get("collections/{$this->collection}");
            return;
        }catch(\Throwable $e){

        }

        $this->http->put("collections/{$this->collection}",[
            'json' => [
                'vectors' => [
                    'size' => $this->vector_size,
                    'distance' => 'Cosine',
                ],
            ],
        ]);

    }


    //コレクションに要素登録
    public function upsert(int $id,array $vector,array $palyload = []):void{

        if(env('DEBUG_FLAG') == "true"){
            $vector_ary = $vector["embedding"];
        }else{
            $vector_ary = $vector[0];
        }


        $res = $this->http->put("collections/{$this->collection}/points", [
            'json' => [
                'points' => [
                    [
                        'id' => $id,
                        'vector' => $vector_ary,
                        'payload' => $palyload
                    ]
                ],
            ],
        ]);

    }

    public function search(array $vector,int $limit = 5):array{

        if(env('DEBUG_FLAG') == "true"){
            $vector_ary = $vector["embedding"];
        }else{
            $vector_ary = $vector[0];
        }

        $res = $this->http->post("collections/{$this->collection}/points/search",[
                'json' => [
                    'vector' => $vector_ary,
                    'limit' => $limit,
                    'with_payload' => true
                ]
        ]);

        $json = json_decode((string)$res->getBody(), true);
        return $json['result'] ?? [];
    }

    public function delete(int $id){

        $res = $this->http->post("collections/{$this->collection}/points/delete",[
            'json' => [
                'points' => [$id]
            ]
        ]);
    }
    
}