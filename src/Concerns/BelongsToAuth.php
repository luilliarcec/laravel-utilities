<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Luilliarcec\Utilities\Scopes\AuthScope;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|Builder withoutAuth()
 */
trait BelongsToAuth
{
    public static function bootBelongsToAuth()
    {
        static::creating(function ($model) {
            $model->user()->associate(Auth::user());
        });

        static::addGlobalScope(new AuthScope);
    }

    public static function getAuthIdColumn(): string
    {
        return (string)config('utilities.auth_foreign_id_column');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), self::getAuthIdColumn());
    }

    public function getQualifiedAuthIdColumn(): string
    {
        return $this->getTable() . '.' . self::getAuthIdColumn();
    }
}
