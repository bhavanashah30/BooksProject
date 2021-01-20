<?php

namespace App\Services;

use GuzzleHttp\Client;
use stdClass;

class APIService
{
    private $client;

    private $headers;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get($url, array $headers = []): stdClass
    {
        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer',
            'Accept' => 'application/json'
        ];

        $response = $this->client->get($url, [
            'headers' => array_merge($this->headers, $headers),
            'verify' => false,
            'allow_redirects' => true,
            'proxy' => ''
        ]);

      return json_decode($response->getBody()->getContents());
    }
}
