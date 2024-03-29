<?php

namespace Mazecode\PackageCreator\Commands;

use Illuminate\Console\Command;

/**
 * List all locally installed packages.
 *
 * @author Mazecode
 **/
class ListPackages extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'packager:list';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'List all locally installed packages.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        $packages = [];

        foreach ($composer['autoload']['psr-4'] as $package => $path) {
            if ($package !== 'App\\') {
                $packages[] = [rtrim($package, '\\'), $path];
            }
        }

        $headers = ['Package', 'Path'];
        $this->table($headers, $packages);
    }
}
