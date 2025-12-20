<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class DeduplicateMahasiswa extends Command
{
    protected $signature = 'mahasiswa:dedupe {--keep=first}';
    protected $description = 'Find exact duplicates (same email, no_hp and jurusan) and remove duplicates keeping one record';

    public function handle()
    {
        $duplicates = Mahasiswa::select('email','no_hp','jurusan', DB::raw('count(*) as cnt'))
            ->whereNotNull('email')
            ->where('email','<>','')
            ->groupBy('email','no_hp','jurusan')
            ->having('cnt','>',1)
            ->get();

        if ($duplicates->isEmpty()) {
            $this->info('No exact duplicates found.');
            return 0;
        }

        foreach ($duplicates as $d) {
            $this->info("Cleaning: {$d->email} / {$d->no_hp} / {$d->jurusan} ({$d->cnt})");
            $rows = Mahasiswa::where('email',$d->email)->where('no_hp',$d->no_hp)->where('jurusan',$d->jurusan)->orderBy('id')->get();
            $keep = $this->option('keep') === 'last' ? $rows->last() : $rows->first();
            $this->info('Keeping id: '.$keep->id);
            foreach ($rows as $r) {
                if ($r->id === $keep->id) continue;
                // Move non-null fields to kept row if missing
                foreach (['nipd','nama_mhs','payment_status','payment_amount','sumber_pendaftaran','status_verifikasi','marketing_notes'] as $f) {
                    if (empty($keep->$f) && !empty($r->$f)) {
                        $keep->$f = $r->$f;
                    }
                }
                $keep->save();
                $r->delete();
                $this->info('Deleted id: '.$r->id);
            }
        }

        $this->info('Deduplication complete.');
        return 0;
    }
}
