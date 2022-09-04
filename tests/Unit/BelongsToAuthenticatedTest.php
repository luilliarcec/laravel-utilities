<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\Utils\Invoice;
use Tests\Utils\User;

class BelongsToAuthenticatedTest extends TestCase
{
    public function test_get_the_table_name_and_column_name_of_the_relation()
    {
        $this->assertEquals(
            'invoices.user_id',
            (new Invoice())->getQualifiedAuthenticatedKeyNameColumn()
        );
    }

    public function test_gets_a_belongs_to_instance()
    {
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            (new Invoice())->user()
        );
    }

    public function test_the_authenticated_user_is_saved_by_event()
    {
        $this->actingAs(User::create(['name' => 'luis arce']));

        $invoice = Invoice::create(['description' => 'Invoice 1']);

        $this->assertEquals(Auth::id(), $invoice->user_id);
    }

    public function test_get_the_relationship_with_the_authenticated_user()
    {
        $this->actingAs(User::create(['name' => 'luis arce']));

        $invoice = Invoice::create(['description' => 'Invoice 1']);

        $this->assertInstanceOf(User::class, $invoice->user);
    }

    public function test_the_global_scope_of_get_by_authenticated_user_applies()
    {
        (new Invoice())
            ->user()->associate(User::create(['name' => 'andres cardenas']))
            ->fill(['description' => 'Invoice 1'])
            ->saveQuietly();

        $this->actingAs(User::create(['name' => 'luis arce']));
        Invoice::create(['description' => 'Invoice 2']);

        $invoices = Invoice::all();
        $this->assertTrue($invoices->contains('description', 'Invoice 2'));
        $this->assertFalse($invoices->contains('description', 'Invoice 1'));
    }

    public function test_the_global_scope_is_removed_with_a_method_call()
    {
        (new Invoice())
            ->user()->associate(User::create(['name' => 'andres cardenas']))
            ->fill(['description' => 'Invoice 1'])
            ->saveQuietly();

        $this->actingAs(User::create(['name' => 'luis arce']));
        Invoice::create(['description' => 'Invoice 2']);

        $invoices = Invoice::withoutAuthenticated()->get();
        $this->assertTrue($invoices->contains('description', 'Invoice 2'));
        $this->assertTrue($invoices->contains('description', 'Invoice 1'));
    }
}
