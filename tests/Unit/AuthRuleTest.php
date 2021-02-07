<?php

namespace Tests\Unit;

use Luilliarcec\Utilities\Rules\Auth as AuthRules;
use Tests\TestCase;
use Tests\Utils\Invoice;
use Tests\Utils\User;

class AuthRuleTest extends TestCase
{
    function test_a()
    {
        $this->actingAs(User::create(['name' => 'luis arce']));

        Invoice::create(['description' => 'Invoice 1']);

        $validator = $this->app['validator']->make(
            ['invoice_id' => 1],
            ['invoice_id' => AuthRules::exists('invoices', 'id')]
        );

        $this->assertFalse($validator->fails());
    }
}
