<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Token;
use App\Models\Account;

class AddToken extends Command
{
    protected $signature = 'add:token {account_id} {token} {type}';
    protected $description = 'Добавить API-токен к аккаунту';

    public function handle()
    {
        $account_id = $this->argument('account_id');
        $token = $this->argument('token');
        $type = $this->argument('type');

        $account = Account::find($account_id);
        if (!$account) {
            $this->error("Аккаунт не найден!");
            return;
        }

        if ($account->token) {
            $this->error("Этот аккаунт уже имеет токен!");
            return;
        }

        Token::create(['account_id' => $account_id, 'token' => $token, 'type' => $type]);
        $this->info("Токен '$token' добавлен к аккаунту.");
    }
}
