<?php

namespace Luilliarcec\Utilities\Rules;

use Illuminate\Contracts\Validation\Rule;

class Decimals implements Rule
{
    private string $match;
    private int $integers;
    private int $decimals;

    public function __construct(int $integers = 8, int $decimals = 2)
    {
        $this->integers = $integers;
        $this->decimals = $decimals;

        $this->match = sprintf(
            '/^[\d]{0,%s}(\.[\d]{0,%s})?$/',
            $this->integers,
            $this->decimals
        );
    }

    public function passes($attribute, $value): bool
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        return preg_match($this->match, $value) > 0;
    }

    public function message(): string
    {
        return __('The field :attribute must be a number composed of up to :integers integers and :decimals decimals', [
            ':integers' => $this->integers,
            ':decimals' => $this->decimals,
        ]);
    }
}
