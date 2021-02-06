<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Luilliarcec\Utilities\UtilitiesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders(Application $app): array
    {
        return [UtilitiesServiceProvider::class];
    }
}
