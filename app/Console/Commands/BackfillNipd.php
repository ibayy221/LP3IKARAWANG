<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mahasiswa;

class BackfillNipd extends Command
{
    protected $signature = 'nipd:backfill {--dry-run}';
    protected $description = 'Backfill missing NIPD values for existing mahasiswa records';

    public function handle()
    {
        $missing = Mahasiswa::where(function ($q) {
            $q->whereNull('nipd')->orWhere('nipd', '');
        })->whereRaw("LOWER(COALESCE(status_verifikasi,'')) = 'verified'")->count();
        if ($missing === 0) {
            $this->info('No missing NIPD values found.');
            return 0;
        }

        $this->info("Found {$missing} records missing NIPD.");
        $bar = $this->output->createProgressBar($missing);
        $bar->start();

        Mahasiswa::where(function ($q) {
            $q->whereNull('nipd')->orWhere('nipd', '');
        })->whereRaw("LOWER(COALESCE(status_verifikasi,'')) = 'verified'")
            ->orderBy('id_mahasiswa')
            ->chunk(100, function ($rows) use ($bar) {
            foreach ($rows as $r) {
                $old = $r->nipd;
                $r->nipd = Mahasiswa::generateNipd($r->id_program_studi ?? null);
                if (!$this->option('dry-run')) {
                    $r->save();
                }
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);
        $this->info('Backfill complete' . ($this->option('dry-run') ? ' (dry-run)' : ''));
        return 0;
    }
}
