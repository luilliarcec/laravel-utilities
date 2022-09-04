<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Luilliarcec\Utilities\UtilitiesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tests\Utils\User;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/Utils/migrations');
    }

    protected function getPackageProviders($app): array
    {
        return [UtilitiesServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('utilities.auth_foreign_id_column', 'user_id');

        /** Database */
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
