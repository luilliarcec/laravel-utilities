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

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }
}
