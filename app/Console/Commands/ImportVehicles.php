<?php

namespace App\Console\Commands;

use App\Services\CarSynchronizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportVehicles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vehicles:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import vehicles from data json files';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $files = Storage::allFiles('data');

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();
        
        foreach ($files as $file) {
            $syncService = new CarSynchronizer($file);
            $syncService->sync();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Files imported");
    }
}
