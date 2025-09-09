<?php

namespace Amani\Pinterest;

use GuzzleHttp\Client;

class Pinterest
{
    protected string $accessToken;
    protected Client $http;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->http = new Client([
            'base_uri' => 'https://api.pinterest.com/v5/',
            'headers'  => [
                'Authorization' => "Bearer {$this->accessToken}",
                'Content-Type'  => 'application/json'
            ]
        ]);
    }

    /**
     * Publier un pin
     */
    public function createPin(string $boardId, string $title, string $description, string $link, string $imageUrl): array
    {
        $payload = [
            'board_id'    => $boardId,
            'title'       => $title,
            'description' => $description,
            'link'        => $link,
            'media_source' => [
                'source_type' => 'image_url',
                'url' => $imageUrl
            ]
        ];

        $response = $this->http->post('pins', ['json' => $payload]);

        return json_decode((string) $response->getBody(), true);
    }
}

