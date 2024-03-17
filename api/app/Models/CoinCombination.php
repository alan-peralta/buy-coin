<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int from_coin_id
 * @property int to_coin_id
 * @property string name
 * @property bool is_active
 */
class CoinCombination extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_coin_id',
        'to_coin_id',
        'name',
        'is_active'
    ];

    public function from(): HasOne
    {
        return $this->hasOne(Coin::class, 'id', 'from_coin_id');
    }

    public function to(): HasOne
    {
        return $this->hasOne(Coin::class, 'id', 'to_coin_id');
    }
}
