<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Database\Query\Builder;
use Luilliarcec\Utilities\Scopes\AuthenticatedScope;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|Builder withoutAuthenticated()
 */
trait BelongsToAuthenticated
{
    use HasAuthenticatedCreator;

    public static function bootBelongsToAuthenticated(): void
    {
        static::addGlobalScope(new AuthenticatedScope);
    }
}
