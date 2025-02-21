<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['account_id', 'token', 'type'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}