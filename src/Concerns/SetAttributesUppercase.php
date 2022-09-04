<?php

namespace Luilliarcec\Utilities\Concerns;

use Illuminate\Support\Str;

trait SetAttributesUppercase
{
    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value): mixed
    {
        parent::setAttribute($key, $value);

        $this->applyCase($key, $value);

        return $this;
    }

    /**
     * Attributes that should be ignored by default
     *
     * @return string[]
     */
    protected function attributesIgnoredByDefault(): array
    {
        return [
            'token',
            'email',
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
            'profile_photo_url',
        ];
    }

    /**
     * Apply the case to the attribute
     *
     * @param $key
     * @param $value
     */
    private function applyCase($key, $value): void
    {
        if (is_string($value) && $this->shouldBeApplied($key)) {
            $this->attributes[$key] = Str::upper($value);
        }
    }

    /**
     * Checks if the case should be applied to the attribute
     *
     * @param $key
     * @return bool
     */
    private function shouldBeApplied($key): bool
    {
        return !in_array($key, $this->dontApply());
    }

    /**
     * Attributes that should be ignored globally/
     *
     * @return string[]
     */
    private function attributesIgnoredGlobally(): array
    {
        return (array)config('utilities.attributes_ignored_globally');
    }

    /**
     * Returns the array of attributes to which the case should not be applied.
     *
     * @return string[]
     */
    private function dontApply(): array
    {
        $dontApply = $this->attributesIgnoredByDefault();
        $dontApply = array_merge($dontApply, $this->attributesIgnoredGlobally());

        if (property_exists($this, 'dontApplyCase')) {
            $dontApply = array_merge($dontApply, $this->dontApplyCase);
        }

        return $dontApply;
    }
}
