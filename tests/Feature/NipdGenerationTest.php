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
            'no_tlp' => '081234567890',
            'domisili' => 'Karawang',
            'id_program_studi' => 1,
        ]);

        $response->assertSessionHas('success');

        // Find the latest Mahasiswa with program ASE (id=1) and check nipd
        $m = Mahasiswa::where('id_program_studi', 1)->orderByDesc('id_mahasiswa')->first();
        $this->assertNotNull($m);
        $this->assertNotNull($m->nipd);
        $branchCfg = config('nipd.branch_code');
        $branch = strlen($branchCfg) >= 2 ? (date('y') . substr($branchCfg, 2)) : $branchCfg;
        $this->assertStringStartsWith($branch . config('nipd.program_codes.ASE'), $m->nipd);

        // Now create another and ensure sequence increments relative to previous max
        $this->post('/mahasiswa', [
            'nama_mhs' => 'Second User',
            'no_tlp' => '081234567891',
            'domisili' => 'Karawang',
            'id_program_studi' => 1,
        ]);

        $latest = Mahasiswa::where('id_program_studi', 1)->orderByDesc('id_mahasiswa')->take(2)->get();
        $this->assertCount(2, $latest);
        $firstSeq = (int) substr($latest[1]->nipd, -config('nipd.sequence_digits'));
        $secondSeq = (int) substr($latest[0]->nipd, -config('nipd.sequence_digits'));
        // Sequence should increase (not necessarily by 1 if prior records exist)
        $this->assertTrue($secondSeq > $firstSeq);
    }
}
