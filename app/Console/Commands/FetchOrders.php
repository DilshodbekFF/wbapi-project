<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OrderService;
use App\Models\Order; 
use Illuminate\Support\Facades\Http; 

class FetchOrders extends Command
{
    protected $signature = 'orders:fetch {dateFrom} {dateTo}';
    protected $description = 'Получение заказов через API';

    public function handle()
    {
        $dateFrom = $this->argument('dateFrom');
        $dateTo = $this->argument('dateTo');

        $apiUrl = "http://89.108.115.241:6969/api/orders";
        $apiKey = "E6kUTYrYwZq2tN4QEtyzsbEBk3ie";

        $response = Http::get($apiUrl, [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'page' => 1,
            'key' => $apiKey,
            'limit' => 100,
        ]);

        if ($response->successful()) {
            $orders = $response->json()['data'] ?? [];

            foreach ($orders as $orderData) {
                Order::insert(
                    [
                        'g_number'          => $orderData['g_number'],
                        'date'              => $orderData['date'],
                        'last_change_date'  => $orderData['last_change_date'],
                        'supplier_article'  => $orderData['supplier_article'],
                        'tech_size'         => $orderData['tech_size'],
                        'barcode'           => $orderData['barcode'],
                        'total_price'       => $orderData['total_price'],
                        'discount_percent'  => $orderData['discount_percent'],
                        'warehouse_name'    => $orderData['warehouse_name'],
                        'oblast'            => $orderData['oblast'],
                        'income_id'         => $orderData['income_id'],
                        'odid'              => $orderData['odid'],
                        'nm_id'             => $orderData['nm_id'],
                        'subject'           => $orderData['subject'],
                        'category'          => $orderData['category'],
                        'brand'             => $orderData['brand'],
                        'is_cancel'         => $orderData['is_cancel'],
                        'cancel_dt'         => $orderData['cancel_dt'] ?? null,
                    ]
                );
            }

            $this->info('Заказы успешно сохранены в базе!');
        } else {
            $this->error("API-запрос не удался. Status: " . $response->status());
        }
    }
}