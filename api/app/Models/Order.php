<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int user_id
 * @property int amount
 * @property int amount_decimals
 * @property int tax
 * @property int quote_id
 * @property int status_id
 * @property int amount_converted
 * @property int amount_converted_decimals
 */
class Order extends Model
{
    use HasFactory;

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
