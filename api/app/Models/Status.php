<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public const NEW = 1;
    public const APPROVED = 2;
    public const CANCELLED = 3;
    public const EXPIRED = 4;

    public const FINALIZE_ORDER = [
        self::APPROVED,
        self::CANCELLED
    ];

}
