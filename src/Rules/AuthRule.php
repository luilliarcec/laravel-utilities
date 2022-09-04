<?php

namespace Luilliarcec\Utilities\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;

class AuthRule
{
    public static function exists($table, $column = 'NULL', $authKeyName = null): Exists
    {
        return (new Exists($table, $column))
            ->where($authKeyName ?: self::getAuthKeyNameColumn(), Auth::id());
    }

    public static function unique($table, $column = 'NULL', $authKeyName = null): Unique
    {
        return (new Unique($table, $column))
            ->where($authKeyName ?: self::getAuthKeyNameColumn(), Auth::id());
    }

    public static function getAuthKeyNameColumn(): string
    {
        return (string) config('utilities.auth_key_name');
    }
}
