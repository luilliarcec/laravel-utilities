<?php

namespace Tests;

use Luilliarcec\Utilities\UtilitiesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [UtilitiesServiceProvider::class];
    }
}
