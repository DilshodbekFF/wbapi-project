<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApiService;

class UpdateDataCommand extends Command
{
    protected $signature = 'update:data';
    protected $description = 'Обновление данных через API или другие источники';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        \Log::info('Данные обновляются...');

        app(ApiService::class)->updateData();

        \Log::info('Данные обновлены.');
    }
}