<?php

namespace Amani\Pinterest;

use GuzzleHttp\Client;

class PinterestClient
{
    private $client;
    private $accessToken;

    public function __construct(string $accessToken)
    {
        $this->client = new Client([
            'base_uri' => 'https://api.pinterest.com/v5/',
        ]);
        $this->accessToken = $accessToken;
    }

    public function createPin(string $boardId, string $title, string $description, string $link, string $mediaUrl)
    {
        $response = $this->client->post("pins", [
            'headers' => [
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type'  => 'application/json'
            ],
            'json' => [
                "board_id"   => $boardId,
                "title"      => $title,
                "description"=> $description,
                "link"       => $link,
                "media_source" => [
                    "source_type" => "image_url",
                    "url" => $mediaUrl
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
