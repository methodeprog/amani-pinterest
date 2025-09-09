<?php

namespace Amani\Pinterest;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Client
{
    protected $http;
    protected $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;

        $this->http = new GuzzleClient([
            'base_uri' => 'https://api.pinterest.com/v5/',
            'headers' => [
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type'  => 'application/json'
            ]
        ]);
    }

    public function createPin(string $boardId, string $title, string $description, string $link, string $mediaUrl)
    {
        try {
            $response = $this->http->post("pins", [
                'json' => [
                    'board_id'    => $boardId,
                    'title'       => $title,
                    'description' => $description,
                    'link'        => $link,
                    'media_source' => [
                        'source_type' => 'image_url',
                        'url' => $mediaUrl
                    ]
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}



