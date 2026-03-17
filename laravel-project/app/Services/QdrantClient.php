<?php

namespace App\Services;

use GuzzleHttp\Client;

class QdrantClient{
    private Client $http;
    private string $collection;
    
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


    public function upsert(int|string $id,array $vector,array $palyload = []):void{
        $this->http->put("collections/{$this->collection}/points",[
            'json' => [
                'points' => [
                    'id' => (string)$id,
                    'vector' => $vector,
                    'payload' => $palyload
                ],
            ],
        ]);
    }

    public function search(array $vector,int $limit = 5):array{

        $res = $this->http->post("collections/{$this->collection}/points/search",[
            'json' => [
                'json' => [
                    'vector' => $vector,
                    'limit' => $limit,
                    'with_payload' => true
                ],
            ],
        ]);

        $json = json_decode((string)$res->getBody(), true);

        return $json['result'] ?? [];
    }
    
}