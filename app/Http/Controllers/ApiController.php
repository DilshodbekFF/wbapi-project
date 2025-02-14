<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\ApiService;

class ApiController extends Controller
{
    public function getOrders()
    {
        try {
            $response = Http::get('http://89.108.115.241:6969/api/stocks', [
                'dateFrom' => '2025-02-13',
                'page' => 1,
               'limit' => 100,
                'key' => 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie'
            ]);


            if ($response->failed()) {
                Log::error('API-запрос вернул ошибку.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json(['error' => 'Произошла ошибка при получении данных с API.', 'body'=>$response->body()], 500);
            }


            return response()->json($response->json());

        } catch (\Exception $e) {
            Log::error('Ошибка при выполнении API-запроса. ' . $e->getMessage());
            return response()->json(['error' => 'Произошла внутренняя ошибка.'], 500);
        }
    }
}


