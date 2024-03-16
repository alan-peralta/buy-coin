<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string from
 * @property string to
 * @property int bid
 * @property int ask
 * @property int bid_decimals
 * @property int ask_decimals
 */
class Quote extends Model
{
    use HasFactory;


    public function orders(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
