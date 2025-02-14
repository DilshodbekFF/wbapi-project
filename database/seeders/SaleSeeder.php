<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Http;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $page = 1;
        $limit = 500;
        $total = 0;

        do {
            $response = Http::get('http://89.108.115.241:6969/api/sales', [
                'dateFrom' => '2025-02-10',
                'dateTo' => '2025-02-12',
                'page' => $page,
                'limit' => $limit,
                'key' => 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie'
            ]);

            $data = $response->json();
            $sales = $data['data'] ?? [];

            foreach ($sales as $item) {
                Sale::insert(
                    [
                        'g_number' => $item['g_number'],
                        'date' => $item['date'],
                        'last_change_date' => $item['last_change_date'],
                        'supplier_article' => $item['supplier_article'],
                        'tech_size' => $item['tech_size'],
                        'barcode' => $item['barcode'],
                        'total_price' => $item['total_price'],
                        'discount_percent' => $item['discount_percent'],
                        'is_supply' => $item['is_supply'],
                        'is_realization' => $item['is_realization'],
                        'promo_code_discount' => $item['promo_code_discount'],
                        'warehouse_name' => $item['warehouse_name'],
                        'country_name' => $item['country_name'],
                        'oblast_okrug_name' => $item['oblast_okrug_name'],
                        'region_name' => $item['region_name'],
                        'income_id' => $item['income_id'],
                        'sale_id' => $item['sale_id'],
                        'odid' => $item['odid'],
                        'spp' => $item['spp'],
                        'for_pay' => $item['for_pay'],
                        'finished_price' => $item['finished_price'],
                        'price_with_disc' => $item['price_with_disc'],
                        'nm_id' => $item['nm_id'],
                        'subject' => $item['subject'],
                        'category' => $item['category'],
                        'brand' => $item['brand'],
                        'is_storno' => $item['is_storno'],
                    ]
                );
            }

            $total += count($sales);
            $page++;

        } while (count($sales) === $limit);
    }
}
