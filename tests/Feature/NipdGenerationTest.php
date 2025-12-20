<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Mahasiswa;

class NipdGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_nipd_is_generated_on_store()
    {
        // Simulate form post
        $response = $this->post('/mahasiswa', [
            'nama_mhs' => 'Test User',
            'no_hp' => '081234567890',
            'jurusan' => 'ASE'
        ]);

        $response->assertSessionHas('success');

        // Find the latest Mahasiswa with jurusan ASE and check nipd
        $m = Mahasiswa::where('jurusan','ASE')->orderByDesc('id')->first();
        $this->assertNotNull($m);
        $this->assertNotNull($m->nipd);
        $this->assertStringStartsWith(config('nipd.branch_code') . config('nipd.program_codes.ASE'), $m->nipd);

        // Now create another and ensure sequence increments relative to previous max
        $this->post('/mahasiswa', [
            'nama_mhs' => 'Second User',
            'no_hp' => '081234567891',
            'jurusan' => 'ASE'
        ]);

        $latest = Mahasiswa::where('jurusan','ASE')->orderByDesc('id')->take(2)->get();
        $this->assertCount(2, $latest);
        $firstSeq = (int) substr($latest[1]->nipd, -config('nipd.sequence_digits'));
        $secondSeq = (int) substr($latest[0]->nipd, -config('nipd.sequence_digits'));
        // Sequence should increase (not necessarily by 1 if prior records exist)
        $this->assertTrue($secondSeq > $firstSeq);
    }
}
