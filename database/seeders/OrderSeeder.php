<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;


class OrderSeeder extends Seeder
{
   
    public function run(): void{
        $page = 1; 
        $url = 'http://89.108.115.241:6969/api/orders';
        $apiKey = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie'; 
        $dateFrom = '2025-02-10';
        $dateTo = '2025-02-12';
        $limit = 500; 

        do {
        
            $response = Http::get($url, [
                'dateFrom' => $dateFrom,
                'dateTo'   => $dateTo,
                'page'     => $page,
                'limit'    => $limit,
                'key'      => $apiKey
            ]);

        
            if ($response->successful()) {
                $data = $response->json(); 

            
                foreach ($data['data'] as $item) {
                    Order::insert(
                        [
                            'g_number'          => $item['g_number'],
                            'date'              => $item['date'],
                            'last_change_date'  => $item['last_change_date'],
                            'supplier_article'  => $item['supplier_article'],
                            'tech_size'         => $item['tech_size'],
                            'barcode'           => $item['barcode'],
                            'total_price'       => $item['total_price'],
                            'discount_percent'  => $item['discount_percent'],
                            'warehouse_name'    => $item['warehouse_name'],
                            'oblast'            => $item['oblast'],
                            'income_id'         => $item['income_id'],
                            'odid'              => $item['odid'],
                            'nm_id'             => $item['nm_id'],
                            'subject'           => $item['subject'],
                            'category'          => $item['category'],
                            'brand'             => $item['brand'],
                            'is_cancel'         => $item['is_cancel'],
                            'cancel_dt'         => $item['cancel_dt'] ?? null,
                        ]
                    );
                }

            
                if (!empty($data['links']['next'])) {
                    $page++; 
                } else {
                    break; 
                }
            } else {
            
                break;
            }
        } while (true);
    }
}










