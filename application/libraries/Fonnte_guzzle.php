<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Fonnte_guzzle
{

    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'https://api.fonnte.com/',
            'timeout'  => 30,
        ]);
    }

    public function send(array $data, string $token)
    {
        try {
            $response = $this->client->post('send', [
                'headers' => [
                    'Authorization' => $token,
                ],
                'multipart' => $this->buildMultipart($data),
            ]);

            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ];
        }
    }

    protected function buildMultipart(array $data)
    {
        $multipart = [];

        foreach ($data as $key => $value) {
            if ($key === 'file' && $value instanceof CURLFile) {
                $multipart[] = [
                    'name' => 'file',
                    'contents' => fopen($value->getFilename(), 'r'),
                    'filename' => basename($value->getFilename())
                ];
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => (string)$value
                ];
            }
        }

        return $multipart;
    }
}
