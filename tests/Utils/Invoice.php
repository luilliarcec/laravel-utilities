<?php

namespace Tests\Utils;

use Illuminate\Database\Eloquent\Model;
use Luilliarcec\Utilities\Concerns\BelongsToAuth;

class Invoice extends Model
{
    use BelongsToAuth;

    protected $fillable = [
        'description',
        'subtotal',
        'total',
    ];
}
