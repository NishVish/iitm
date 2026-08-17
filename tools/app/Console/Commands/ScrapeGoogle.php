<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ScrapeGoogle extends Command
{
    protected $signature = 'scrape:google';

    protected $description = 'Run Dusk Google scraper and store results';

    public function handle()
    {
        $this->info("Starting Google scraping via Dusk...");

        // Run Dusk tests
        $exitCode = Artisan::call('dusk');

        if ($exitCode === 0) {
            $this->info("Dusk completed successfully.");
        } else {
            $this->error("Dusk failed.");
        }

        $this->info("Done.");

        return 0;
    }
}