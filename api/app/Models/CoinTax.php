<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_coin_id',
        'to_coin_id',
        'percent',
        'amount'
    ];
}
