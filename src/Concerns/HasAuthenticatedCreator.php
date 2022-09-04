<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

trait HasAuthenticatedCreator
{
    public static function bootHasAuthenticatedCreator(): void
    {
        static::creating(function ($model) {
            $model->user()->associate(Auth::user());
        });
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
