<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class FindDuplicates extends Command
{
    protected $signature = 'db:find-duplicates {--field=email}';
    protected $description = 'Find duplicate Mahasiswa rows by a given field (email, nama_mhs, no_hp)';

    public function handle()
    {
        $field = $this->option('field') ?: 'email';
        if (!in_array($field, ['email', 'nama_mhs', 'no_hp'])) {
            $this->error('Unsupported field. Use email, nama_mhs or no_hp');
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
            $rows = Mahasiswa::where($field, $d->{$field})->get(['id','nama_mhs','email','no_hp','jurusan','created_at']);
            $this->table(['id','nama_mhs','email','no_hp','jurusan','created_at'],$rows->toArray());
        }

        return 0;
    }
}
