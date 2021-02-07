<?php

namespace Tests\Unit;

use Luilliarcec\Utilities\Rules\Auth as AuthRules;
use Tests\TestCase;
use Tests\Utils\Invoice;
use Tests\Utils\User;

class AuthRuleTest extends TestCase
{
    function test_validates_that_the_record_exists_with_the_authenticated_user()
    {
        $this->actingAs(User::create(['name' => 'luis arce']));
        Invoice::create(['description' => 'Invoice 1']);

        $validator = $this->app['validator']->make(
            ['invoice_id' => 1],
            ['invoice_id' => AuthRules::exists('invoices', 'id')]
        );

        $this->assertFalse($validator->fails());
    }

    function test_validation_fails_when_record_does_not_belong_to_authenticated_user()
    {
        (new Invoice())
            ->user()->associate(User::create(['name' => 'andres cardenas']))
            ->fill(['description' => 'Invoice 1'])
            ->saveQuietly();

        $this->actingAs(User::create(['name' => 'luis arce']));
        Invoice::create(['description' => 'Invoice 2']);

        $validator = $this->app['validator']->make(
            ['invoice_id' => 1],
            ['invoice_id' => AuthRules::exists('invoices', 'id')]
        );

        $this->assertTrue($validator->fails());
    }
}
