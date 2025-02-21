<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'username', 'password'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function token()
    {
        return $this->hasOne(Token::class);
    }

    public function getApiData($date = null)
{
    $client = new Client();
    
    $token = $this->token->token; 
    
    try {
        $queryParams = [];
        
        if ($date) {
            $queryParams['date'] = $date;
        }
        
        $response = $client->get('https://api.example.com/data', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
            'query' => $queryParams  
        ]);

        return json_decode($response->getBody()->getContents(), true);
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

    

public static function getRoundRobinApiData()
    {
    $accounts = self::where('status', 'active')->get();
    $data = [];

    $lastUpdatedDate = $account->last_updated;

    foreach ($accounts as $account) {
        $apiData = $account->getApiData($lastUpdatedDate);
        if (!isset($apiData['error'])) {
            $data[] = $apiData;
        }
    }

    return $data;
    }
}