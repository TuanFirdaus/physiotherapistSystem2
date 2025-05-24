<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class GeminiService
{
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiKey = getenv('GEMINI_API_KEY'); // Load from .env file
        $this->client = new Client([
            'base_uri' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:',
            'timeout'  => 10.0,
        ]);
    }

    public function generateText($prompt)
    {
        try {
            $response = $this->client->post('generateContent', [
                'query' => [
                    'key' => $this->apiKey
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
