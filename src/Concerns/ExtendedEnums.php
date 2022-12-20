<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Support\Str;
use Luilliarcec\Utilities\Collections\EnumCollection;

trait ExtendedEnums
{
    public static function toArray(array $excepts = []): array
    {
        return static::collection()->toArray();
    }

    public static function values(): array
    {
        return static::collection()->getValues()->toArray();
    }

    public static function names(): array
    {
        return static::collection()->getNames()->toArray();
    }

    public static function collection(): EnumCollection
    {
        return new EnumCollection(static::class, static::cases());
    }

    public static function cast(mixed $name = null): string
    {
        return trans()->has($key = "validation.attributes.{$name}")
            ? ucfirst(__($key))
            : (string) Str::of($name)->headline()->ucfirst();
    }

    public function title(): string
    {
        return self::cast($this->name);
    }

    public function equalTo(mixed $enum): bool
    {
        if (is_array($enum)) {
            return in_array($this, $enum);
        }

        return $this === $enum;
    }
}
