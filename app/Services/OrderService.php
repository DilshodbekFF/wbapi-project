<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Account;
use App\Models\Order;
use Exception;

class OrderService
{
    protected $baseUrl = 'http://89.108.115.241:6969/api/orders';
    protected $retryAttempts = 3;

    public function fetchOrders($dateFrom, $dateTo)
    {
        $accounts = Account::all();

        foreach ($accounts as $account) {
            $page = 1;
            do {
                $response = $this->makeRequest($account, $dateFrom, $dateTo, $page);

                if ($response === false) {
                    Log::error("API bilan bog‘liq muammo, so‘rov bajarilmadi.");
                    break;
                }

                $orders = $response['orders'] ?? [];
                foreach ($orders as $order) {
                    $this->storeOrder($order, $account->id);
                }

                $page++;
            } while (count($orders) == 100);
        }
    }

    private function makeRequest($account, $dateFrom, $dateTo, $page)
    {
        $url = "{$this->baseUrl}?dateFrom={$dateFrom}&dateTo={$dateTo}&page={$page}&key={$account->api_key}&limit=100";

        for ($attempt = 0; $attempt < $this->retryAttempts; $attempt++) {
            try {
                $response = Http::get($url);

                if ($response->status() == 200) {
                    return $response->json();
                }

                if ($response->status() == 429) {
                    Log::warning("429 xatosi olindi. " . ($attempt + 1) . "-urinishdan so‘ng kutib turamiz.");
                    sleep(5);
                    continue;
                }

                Log::error("API xatosi: " . $response->status());
                return false;
            } catch (Exception $e) {
                Log::error("API bilan bog‘liq xatolik: " . $e->getMessage());
                sleep(3);
            }
        }

        return false;
    }

    private function storeOrder($orderData, $accountId)
    {
        Order::updateOrCreate(
            ['order_id' => $orderData['id'], 'account_id' => $accountId], 
            [
                'customer_name' => $orderData['customer_name'],
                'total_price' => $orderData['total_price'],
                'status' => $orderData['status'],
                'date' => $orderData['date'],
            ]
        );
    }
}
