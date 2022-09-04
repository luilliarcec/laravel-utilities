<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Support\Str;

trait EnumsToArray
{
    public static function toArray(): array
    {
        foreach (self::cases() as $enum) {
            if (trans()->has($key = "validation.attributes.{$enum->name}")) {
                $values[$enum->value ?? $enum->name] = ucfirst(__($key));
            } else {
                $values[$enum->value ?? $enum->name] = (string) Str::of($enum->name)
                    ->kebab()
                    ->replace(['-', '_'], ' ')
                    ->ucfirst();
            }
        }

        return $values ?? [];
    }
}
