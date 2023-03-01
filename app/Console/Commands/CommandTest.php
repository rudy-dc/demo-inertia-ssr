<?php

namespace App\Console\Commands;

use App\Jobs\TestJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CommandTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command test';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (config('logging.channels.slack.url')) {
            Log::channel('slack')->info("Exec command test");

            TestJob::dispatch()->delay(now()->addSeconds(10));
        } else {
            Log::error("LOG_SLACK_WEBHOOK_URL not filled");
        }
    }
}
