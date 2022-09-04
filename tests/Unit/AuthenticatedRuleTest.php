<?php

namespace Tests\Unit;

use Luilliarcec\Utilities\Rules\Authenticated;
use Tests\TestCase;
use Tests\Utils\Invoice;
use Tests\Utils\User;

class AuthenticatedRuleTest extends TestCase
{
    public function test_validates_that_the_record_exists_with_the_authenticated_user()
    {
        $this->actingAs(User::create(['name' => 'luis arce']));
        Invoice::create(['description' => 'Invoice 1']);

        $this->assertFalse(
            $this->app['validator']
                ->make(
                    ['invoice_id' => 1],
                    ['invoice_id' => Authenticated::make('invoices', 'id')->exists()]
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
                    ['invoice_id' => Authenticated::make('invoices', 'id')->exists()]
                )
                ->fails()
        );
    }

    public function test_validate_that_the_record_is_unique_per_authenticated_user()
    {
        $this->actingAs(User::create(['name' => 'luis arce']));
        Invoice::create(['description' => 'Invoice 1']);

        $this->assertTrue(
            $this->app['validator']
                ->make(
                    ['invoice_id' => 1],
                    ['invoice_id' => Authenticated::make('invoices', 'id')->unique()]
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
                    ['invoice_id' => Authenticated::make('invoices', 'id')->unique()]
                )
                ->fails()
        );
    }
}
