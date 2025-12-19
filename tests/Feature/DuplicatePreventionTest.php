<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Mahasiswa;

class DuplicatePreventionTest extends TestCase
{
    use RefreshDatabase;

    public function test_prevents_quick_duplicate_submissions()
    {
        $data = ['nama_mhs' => 'Dup Test', 'email' => 'dup@example.com', 'no_hp' => '08123456789', 'jurusan' => 'ASE'];

        $this->post('/mahasiswa', $data)->assertSessionHas('success');
        $this->post('/mahasiswa', $data)->assertSessionHas('success');

        $this->assertDatabaseCount('mahasiswas', 1);
    }
}
