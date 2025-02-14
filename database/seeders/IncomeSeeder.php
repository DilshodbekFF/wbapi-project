<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Support\Facades\Http;



class IncomeSeeder extends Seeder
{
    public function run(): void
    {
        $page = 1;
        $limit = 500; 
        $apiUrl = 'http://89.108.115.241:6969/api/incomes';
        $apiKey = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';

        do {
            $response = Http::get($apiUrl, [
                'dateFrom' => '2025-02-10',
                'dateTo' => '2025-02-12',
                'page' => $page,
                'limit' => $limit,
                'key' => $apiKey
            ]);

            $data = $response->json();

            if (!empty($data['data'])) {
                foreach ($data['data'] as $item) {
                    Income::insert( 
                        [
                            'income_id' => $item['income_id'] ?? '',
                            'number' => $item['number'] ?? '',
                            'date' => $item['date'],
                            'last_change_date' => $item['last_change_date'],
                            'supplier_article' => $item['supplier_article'],
                            'tech_size' => $item['tech_size'],
                            'barcode' => $item['barcode'],
                            'quantity' => $item['quantity'],
                            'total_price' => $item['total_price'],
                            'date_close' => $item['date_close'],
                            'warehouse_name' => $item['warehouse_name'],
                            'nm_id' => $item['nm_id'],
                        ]
                    );
                }
            }

            $page++;

        } while (!empty($data['next']));
    }
}