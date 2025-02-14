<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $page = 1;
        $limit = 500;
        $key = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';

        do {
            $response = Http::get('http://89.108.115.241:6969/api/stocks', [
                'dateFrom' => '2025-02-14',
                'page' => $page,
                'limit' => $limit,
                'key' => $key
            ]);

            $data = $response->json();

            if (!isset($data['data']) || empty($data['data'])) {
                break;
            }

            foreach ($data['data'] as $item) {
                Stock::insert(
                    [
                        'date' => $item['date'] ?? null,
                        'last_change_date' => $item['last_change_date'] ?? null,
                        'supplier_article' => $item['supplier_article'] ?? null,
                        'tech_size' => $item['tech_size'] ?? null,
                        'barcode' => $item['barcode'] ?? null,
                        'quantity' => $item['quantity'] ?? null,
                        'is_supply' => $item['is_supply'] ?? false,
                        'is_realization' => $item['is_realization'] ?? false,
                        'quantity_full' => $item['quantity_full'] ?? null,
                        'warehouse_name' => $item['warehouse_name'] ?? null,
                        'in_way_to_client' => $item['in_way_to_client'] ?? null,
                        'in_way_from_client' => $item['in_way_from_client'] ?? null,
                        'nm_id' => $item['nm_id'] ?? null,
                        'subject' => $item['subject'] ?? null,
                        'category' => $item['category'] ?? null,
                        'brand' => $item['brand'] ?? null,
                        'sc_code' => $item['sc_code'] ?? null,
                        'price' => $item['price'] ?? null,
                        'discount' => $item['discount'] ?? null
                    ]
                );
            }

            $page++; 
            $hasNextPage = isset($data['links']['next']) && $data['links']['next'] !== null; 

        } while ($hasNextPage); 
    }
}