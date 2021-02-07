<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Support\Facades\Auth;
use Luilliarcec\Utilities\Scopes\AuthScope;

trait BelongsToAuth
{
    public static string $authIdColumn = 'user_id';

    public function user()
    {
        return $this->belongsTo(
            config('auth.providers.users.model'),
            self::$authIdColumn
        )->withTrashed();
    }

    public static function bootHasCompany()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user()->associate(Auth::user());
            }
        });

        static::addGlobalScope(new AuthScope());
    }

    public function getQualifiedAuthIdColumn(): string
    {
        return $this->getTable() . '.' . self::$authIdColumn;
    }
}
