<?php

namespace App\Console\Commands;

use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Kuis;
use Illuminate\Console\Command;

class AutoPublishContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:auto-publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically publish content (Materi, Tugas, Kuis) based on waktu_rilis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-publish content...');

        // Auto-publish Materi
        $materiUpdated = Materi::where('status', 'draft')
            ->whereNotNull('waktu_rilis')
            ->where('waktu_rilis', '<=', now())
            ->get();

        foreach ($materiUpdated as $materi) {
            // Update status - the observer will handle notifications automatically
            $materi->update(['status' => 'published']);
        }

        $this->info("Materi: {$materiUpdated->count()} items published");

        // Auto-publish Tugas
        $tugasUpdated = Tugas::where('status', 'draft')
            ->whereNotNull('waktu_rilis')
            ->where('waktu_rilis', '<=', now())
            ->get();

        foreach ($tugasUpdated as $tugas) {
            // Update status - the observer will handle notifications automatically
            $tugas->update(['status' => 'published']);
        }

        $this->info("Tugas: {$tugasUpdated->count()} items published");

        // Auto-publish Kuis
        $kuisUpdated = Kuis::where('status', 'draft')
            ->whereNotNull('waktu_rilis')
            ->where('waktu_rilis', '<=', now())
            ->get();

        foreach ($kuisUpdated as $kuis) {
            // Update status - the observer will handle notifications automatically
            $kuis->update(['status' => 'published']);
        }

        $this->info("Kuis: {$kuisUpdated->count()} items published");

        $total = $materiUpdated->count() + $tugasUpdated->count() + $kuisUpdated->count();
        $this->info("Total: {$total} items auto-published");

        return Command::SUCCESS;
    }


}
