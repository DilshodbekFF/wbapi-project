<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiService;

class AddApiService extends Command
{
    protected $signature = 'add:apiservice {name} {base_url} {token_type}';
    protected $description = 'Добавить новую API-службу';

    public function handle()
    {
        $name = $this->argument('name');
        $base_url = $this->argument('base_url');
        $token_type = $this->argument('token_type');

        ApiService::create(['name' => $name, 'base_url' => $base_url, 'token_type' => $token_type]);

        $this->info("API-служба '$name' создана.");
    }
}
