<?php

namespace Luilliarcec\Utilities\Collections;

use BackedEnum;
use Illuminate\Support\Collection;

class EnumCollection extends Collection
{
    public function __construct($items = [], public ?string $enum = null)
    {
        parent::__construct($items);
    }

    public function getValues(): static
    {
        return $this->pluck('value');
    }

    public function getNames(): static
    {
        return $this->pluck('name');
    }

    public function casted(): array
    {
        return $this
            ->reduce(
                function ($enums, BackedEnum $enum) {
                    $enums[$enum->value ?? $enum->name] = $this->enum::cast($enum->name);

                    return $enums;
                }, []
            );
    }
}
