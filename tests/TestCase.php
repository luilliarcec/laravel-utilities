<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Luilliarcec\Utilities\UtilitiesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tests\Utils\User;

class TestCase extends Orchestra
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/utils/migrations');
    }

    protected function getPackageProviders($app): array
    {
        return [UtilitiesServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', User::class);

        /** Database */
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
