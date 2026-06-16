<?php

namespace App\Console\Commands;

use App\Services\ContentReleaseService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckContentReleaseJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:check-release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and process pending content releases';

    protected $contentReleaseService;

    /**
     * Create a new command instance.
     */
    public function __construct(ContentReleaseService $contentReleaseService)
    {
        parent::__construct();
        $this->contentReleaseService = $contentReleaseService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for pending content releases...');

        try {
            $releasedCount = $this->contentReleaseService->processPendingReleases();
            
            if ($releasedCount > 0) {
                $this->info("✓ Released {$releasedCount} content item(s)");
                Log::info("Content release job completed", ['released' => $releasedCount]);
            } else {
                $this->info('✓ No pending releases');
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("✗ Content release failed: {$e->getMessage()}");
            Log::error("Content release job failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }
}
