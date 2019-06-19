<?php

namespace Mazecode\Packager;

use Illuminate\Support\ServiceProvider;

/**
 * This is the service provider.
 *
 * Place the line below in the providers array inside app/config/app.php
 * <code>'Mazecode\PackageCreator\PackagerServiceProvider',</code>
 *
 * @author Mazecode
 **/
class PackagerServiceProvider extends ServiceProvider
{
    /**
     * The console commands.
     *
     * @var bool
     */
    protected $commands = [
        'Mazecode\PackageCreator\Commands\NewPackage',
        'Mazecode\PackageCreator\Commands\RemovePackage',
        'Mazecode\PackageCreator\Commands\GetPackage',
        'Mazecode\PackageCreator\Commands\GitPackage',
        'Mazecode\PackageCreator\Commands\ListPackages',
        'Mazecode\PackageCreator\Commands\MoveTests',
        'Mazecode\PackageCreator\Commands\CheckPackage',
        'Mazecode\PackageCreator\Commands\PublishPackage',
        'Mazecode\PackageCreator\Commands\EnablePackage',
        'Mazecode\PackageCreator\Commands\DisablePackage',
    ];

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/packager.php' => config_path('packager.php'),
        ]);
    }

    /**
     * Register the command.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/packager.php', 'packager');

        $this->commands($this->commands);
    }
}
