<?php

namespace Luilliarcec\Utilities\Rules;

use Illuminate\Support\Facades\Auth as Authenticated;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Luilliarcec\Utilities\Concerns\BelongsToAuth;

class Auth
{
    public static function exists($table, $column = 'NULL'): Exists
    {
        return (new Exists($table, $column))
            ->where(BelongsToAuth::getAuthIdColumn(), Authenticated::id());
    }

    public static function unique($table, $column = 'NULL'): Unique
    {
        return (new Unique($table, $column))
            ->where(BelongsToAuth::getAuthIdColumn(), Authenticated::id());
    }
}
