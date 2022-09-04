<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Luilliarcec\Utilities\Scopes\AuthenticatedScope;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|Builder withoutAuthenticated()
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
        return $this->belongsTo($model = $this->getAuthenticatedModelName(), $this->getAuthenticatedKeyNameColumn())
            ->when($this->hasSoftDeletes($model), fn ($query) => $query->withTrashed())
            ->withDefault();
    }

    public function getAuthenticatedKeyNameColumn(): string
    {
        return (string) config('utilities.authenticated_key_name');
    }

    public function getAuthenticatedModelName(): string
    {
        return (string) config('auth.providers.users.model');
    }

    public function getQualifiedAuthenticatedKeyNameColumn(): string
    {
        return $this->qualifyColumn($this->getAuthenticatedKeyNameColumn());
    }

    protected function hasSoftDeletes($model): bool
    {
        return in_array(SoftDeletes::class, class_uses($model));
    }
}
