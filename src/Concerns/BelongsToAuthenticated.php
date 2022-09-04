<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Luilliarcec\Utilities\Scopes\AuthenticatedScope;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|Builder withoutAuth()
 */
trait BelongsToAuthenticated
{
    public static function bootBelongsToAuthenticated(): void
    {
        static::creating(function ($model) {
            $model->user()->associate(Auth::user());
        });

        static::addGlobalScope(new AuthenticatedScope);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo($model = $this->getAuthModelName(), $this->getAuthKeyNameColumn())
            ->when($this->hasSoftDeletes($model), fn ($query) => $query->withTrashed())
            ->withDefault();
    }

    public function getAuthKeyNameColumn(): string
    {
        return (string) config('utilities.auth_key_name');
    }

    public function getAuthModelName(): string
    {
        return (string) config('auth.providers.users.model');
    }

    public function getQualifiedAuthKeyNameColumn(): string
    {
        return $this->qualifyColumn($this->getAuthKeyNameColumn());
    }

    protected function hasSoftDeletes($model): bool
    {
        return in_array(SoftDeletes::class, class_uses($model));
    }
}
