<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class DeduplicateMahasiswa extends Command
{
    protected $signature = 'mahasiswa:dedupe {--keep=first}';
    protected $description = 'Find exact duplicates (same email, no_tlp and id_program_studi) and remove duplicates keeping one record';

    public function handle()
    {
        $duplicates = Mahasiswa::select('email','no_tlp','id_program_studi', DB::raw('count(*) as cnt'))
            ->whereNotNull('email')
            ->where('email','<>','')
            ->groupBy('email','no_tlp','id_program_studi')
            ->having('cnt','>',1)
            ->get();

        if ($duplicates->isEmpty()) {
            $this->info('No exact duplicates found.');
            return 0;
        }

        foreach ($duplicates as $d) {
            $this->info("Cleaning: {$d->email} / {$d->no_tlp} / {$d->id_program_studi} ({$d->cnt})");
            $rows = Mahasiswa::where('email',$d->email)
                ->where('no_tlp',$d->no_tlp)
                ->where('id_program_studi',$d->id_program_studi)
                ->orderBy('id_mahasiswa')
                ->get();
            $keep = $this->option('keep') === 'last' ? $rows->last() : $rows->first();
            $this->info('Keeping id: '.$keep->id_mahasiswa);
            foreach ($rows as $r) {
                if ($r->id_mahasiswa === $keep->id_mahasiswa) continue;
                // Move non-null fields to kept row if missing
                foreach (['nipd','nama_mhs','payment_status','payment_amount','sumber_pendaftaran','status_verifikasi','marketing_notes'] as $f) {
                    if (empty($keep->$f) && !empty($r->$f)) {
                        $keep->$f = $r->$f;
                    }
                }
                $keep->save();
                $r->delete();
                $this->info('Deleted id: '.$r->id_mahasiswa);
            }
        }

        $this->info('Deduplication complete.');
        return 0;
    }
}
