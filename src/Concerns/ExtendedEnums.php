<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Support\Str;

trait ExtendedEnums
{
    public static function toArray(): array
    {
        foreach (self::cases() as $enum) {
            $values[$enum->value ?? $enum->name] = self::cast($enum->name);
        }

        return $values ?? [];
    }

    public static function values(): array
    {
        return collect(self::cases())->pluck('value')->toArray();
    }

    public static function names(): array
    {
        return collect(self::cases())->pluck('name')->toArray();
    }

    public function title(): string
    {
        return self::cast($this->name);
    }

    protected static function cast(mixed $name = null): string
    {
        return trans()->has($key = "validation.attributes.{$name}")
            ? ucfirst(__($key))
            : (string)Str::of($name)->headline()->ucfirst();
    }
}
