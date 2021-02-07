<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Support\Facades\Auth;
use Luilliarcec\Utilities\Scopes\AuthScope;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withoutAuth()
 */
trait BelongsToAuth
{
    public static string $authIdColumn = 'user_id';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), self::$authIdColumn);
    }

    public static function bootBelongsToAuth()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user()->associate(Auth::user());
            }
        });

        static::addGlobalScope(new AuthScope);
    }

    public function getQualifiedAuthIdColumn(): string
    {
        return $this->getTable() . '.' . self::$authIdColumn;
    }
}
