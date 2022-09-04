<?php

namespace Luilliarcec\Utilities;

use Illuminate\Database\Schema\Blueprint;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class UtilitiesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-utilities')
            ->hasConfigFile('utilities');
    }

    public function packageRegistered()
    {
        Blueprint::macro('authenticatedKey', function () {
            $key = config('utilities.authenticated.key');

            $model = config('utilities.authenticated.model');

            config('utilities.authenticated.use_constrained')
                ? $this->foreignIdFor($model = new $model, $key)->nullable()->constrained($model->getTable())
                : $this->foreignId($key)->nullable()->index();
        });

        Blueprint::macro('createdBy', fn () => $this->authenticatedKey());
    }
}
