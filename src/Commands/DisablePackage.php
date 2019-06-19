<?php

namespace Mazecode\PackageCreator\Commands;

use Mazecode\PackageCreator\Conveyor;
use Mazecode\PackageCreator\Wrapping;
use Illuminate\Console\Command;
use Mazecode\PackageCreator\ProgressBar;

/**
 * remove an existing package.
 *
 * @author Mazecode
 **/
class DisablePackage extends Command
{
    use ProgressBar;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'packager:disable {vendor} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a package from composer.json and the providers config.';

    /**
     * Packages roll off of the conveyor.
     *
     * @var object \Mazecode\PackageCreator\Conveyor
     */
    protected $conveyor;

    /**
     * Packages are packed in wrappings to personalise them.
     *
     * @var object \Mazecode\PackageCreator\Wrapping
     */
    protected $wrapping;

    /**
     * Create a new command instance.
     */
    public function __construct(Conveyor $conveyor, Wrapping $wrapping)
    {
        parent::__construct();
        $this->conveyor = $conveyor;
        $this->wrapping = $wrapping;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Start the progress bar
        $this->startProgressBar(2);

        // Defining vendor/package
        $this->conveyor->vendor($this->argument('vendor'));
        $this->conveyor->package($this->argument('name'));

        // Start removing the package
        $this->info('Disabling package '.$this->conveyor->vendor().'\\'.$this->conveyor->package().'...');
        $this->makeProgress();

        // Composer dump-autoload to remove service provider
        $this->info('Dumping autoloads and undiscovering package...');
        $this->wrapping->removeFromComposer($this->conveyor->vendor(), $this->conveyor->package());
        $this->wrapping->removeFromProviders($this->conveyor->vendor(), $this->conveyor->package());
        $this->conveyor->dumpAutoloads();
        $this->makeProgress();

        // Finished removing the package, end of the progress bar
        $this->finishProgress('Package disabled successfully!');
    }
}
