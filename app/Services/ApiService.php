<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.api.url'); 
        $this->apiKey = config('services.api.key'); 
    }

    public function fetchData($endpoint)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->apiUrl . $endpoint);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Произошла ошибка при получении данных из API.'];
    }
}