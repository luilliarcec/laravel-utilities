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

        $this->assertFalse(
            $this->app['validator']
                ->make(
                    ['invoice_id' => 1],
                    ['invoice_id' => AuthRules::exists('invoices', 'id')]
                )
                ->fails()
        );

        (new Invoice())
            ->user()->associate(User::create(['name' => 'andres cardenas']))
            ->fill(['description' => 'Invoice 2'])
            ->saveQuietly();

        $this->assertTrue(
            $this->app['validator']
                ->make(
                    ['invoice_id' => 2],
                    ['invoice_id' => AuthRules::exists('invoices', 'id')]
                )
                ->fails()
        );
    }

    function test_validate_that_the_record_is_unique_per_authenticated_user()
    {
        $this->actingAs(User::create(['name' => 'luis arce']));
        Invoice::create(['description' => 'Invoice 1']);

        $this->assertTrue(
            $this->app['validator']
                ->make(
                    ['invoice_id' => 1],
                    ['invoice_id' => AuthRules::unique('invoices', 'id')]
                )
                ->fails()
        );

        (new Invoice())
            ->user()->associate(User::create(['name' => 'andres cardenas']))
            ->fill(['description' => 'Invoice 2'])
            ->saveQuietly();

        $this->assertFalse(
            $this->app['validator']
                ->make(
                    ['invoice_id' => 2],
                    ['invoice_id' => AuthRules::unique('invoices', 'id')]
                )
                ->fails()
        );
    }
}
