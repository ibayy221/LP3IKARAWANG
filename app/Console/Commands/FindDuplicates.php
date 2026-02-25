<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class FindDuplicates extends Command
{
    protected $signature = 'db:find-duplicates {--field=email}';
    protected $description = 'Find duplicate Mahasiswa rows by a given field (email, nama_mhs, no_tlp)';

    public function handle()
    {
        $field = $this->option('field') ?: 'email';
        if (!in_array($field, ['email', 'nama_mhs', 'no_tlp'])) {
            $this->error('Unsupported field. Use email, nama_mhs or no_tlp');
            return 1;
        }

        $dupes = Mahasiswa::select($field, DB::raw('count(*) as cnt'))
            ->whereNotNull($field)
            ->where($field, '<>', '')
            ->groupBy($field)
            ->having('cnt', '>', 1)
            ->orderByDesc('cnt')
            ->get();

        if ($dupes->isEmpty()) {
            $this->info('No duplicates found by '.$field);
            return 0;
        }

        foreach ($dupes as $d) {
            $this->line("{$field} = {$d->{$field}} ({$d->cnt})");
            $rows = Mahasiswa::where($field, $d->{$field})->get(['id_mahasiswa','nama_mhs','email','no_tlp','id_program_studi','created_at']);
            $this->table(['id_mahasiswa','nama_mhs','email','no_tlp','id_program_studi','created_at'],$rows->toArray());
        }

        return 0;
    }
}
