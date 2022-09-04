<?php

namespace Tests\Unit;

use Luilliarcec\Utilities\Rules\DecimalsRule;
use Tests\TestCase;

class DecimalsRuleTest extends TestCase
{
    function test_does_not_generate_error_when_the_number_is_a_string()
    {
        $validator = $this->app['validator']->make(
            ['amount' => '123'],
            ['amount' => new DecimalsRule]
        );

        $this->assertFalse($validator->fails());
    }

    function test_does_not_generate_error_when_number_is_0()
    {
        $validator = $this->app['validator']->make(
            ['amount' => '0'],
            ['amount' => new DecimalsRule]
        );

        $this->assertFalse($validator->fails());
    }

    function test_does_not_generate_error_when_number_is_whitespace()
    {
        $validator = $this->app['validator']->make(
            ['amount' => ''],
            ['amount' => new DecimalsRule]
        );

        $this->assertFalse($validator->fails());
    }

    function test_null_generates_an_error()
    {
        $validator = $this->app['validator']->make(
            ['amount' => null],
            ['amount' => new DecimalsRule]
        );

        $this->assertTrue($validator->fails());
    }

    function test_anything_that_does_not_have_a_number_format_generates_an_error()
    {
        $validator = $this->app['validator']->make(
            ['amount' => 'asas'],
            ['amount' => new DecimalsRule]
        );

        $this->assertTrue($validator->fails());
    }

    function test_when_the_number_has_more_integers_than_allowed_it_generates_an_error()
    {
        $validator = $this->app['validator']->make(
            ['amount' => 12345],
            ['amount' => new DecimalsRule(4, 2)]
        );

        $this->assertTrue($validator->fails());
    }

    function test_when_the_number_has_more_decimals_than_allowed_it_generates_an_error()
    {
        $validator = $this->app['validator']->make(
            ['amount' => 0.25],
            ['amount' => new DecimalsRule(1, 1)]
        );

        $this->assertTrue($validator->fails());
    }
}
