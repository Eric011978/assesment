<?php

namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;

class TestController
{
    public function test()
    {
        // Access token request
        $client = HttpClient::create();
        $response = $client->request('POST', 'https://rdbauth.staging.sidekickit.nl/token',
            [
                'body' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => 'f8ceed63597fd9a05b942bbb58360430',
                        'client_secret' => '402ebc5ce2b94fd803518d97364b5d0ceecf291975f5c265b6fd69f7e974c85b62e6dcd770c8814a18c9b71e8a064678313d74206d3c9118be8f09c454b2bb5d'
                    ],
                ]);

        $responseArray = $response->toArray();
        var_dump($responseArray['token_type'] . ' ' . $responseArray['access_token']);

        // Rest API
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.richtlijnendatabase.nl/guidelines',
            [
                'headers' => [
                    'Authorization' =>  $responseArray['token_type'] . ' ' . $responseArray['access_token'],
                ],
            ]);

        var_dump($response->getContent()); die;

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        //$contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        //$content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        //$content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $response;
    }
}