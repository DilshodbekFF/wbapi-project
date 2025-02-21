<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Account;
use App\Models\Company;

class AddAccount extends Command
{
    protected $signature = 'add:account {company_id} {username} {password}';
    protected $description = 'Добавить новый аккаунт';

    public function handle()
    {
        $company_id = $this->argument('company_id');
        $username = $this->argument('username');
        $password = bcrypt($this->argument('password'));

        $company = Company::find($company_id);
        if (!$company) {
            $this->error("Компания не найдена!");
            return;
        }

        Account::create(['company_id' => $company_id, 'username' => $username, 'password' => $password]);
        $this->info("Аккаунт '$username' добавлен в компанию.");
    }
}
