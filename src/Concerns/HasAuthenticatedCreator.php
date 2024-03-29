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
            $model->creator()->associate(Auth::user());
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo($model = $this->getAuthenticatedModelName(), $this->getAuthenticatedKeyNameColumn())
            ->when($this->hasSoftDeletes($model), fn ($query) => $query->withTrashed())
            ->withDefault();
    }

    public function getAuthenticatedKeyNameColumn(): string
    {
        return (string) config('utilities.authenticated.key');
    }

    public function getAuthenticatedModelName(): string
    {
        return (string) config('utilities.authenticated.model');
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
