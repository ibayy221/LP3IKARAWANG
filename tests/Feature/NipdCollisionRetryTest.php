<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Mahasiswa;

class NipdCollisionRetryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_with_forced_nipd_collision_retries_and_succeeds()
    {
        // create an existing mahasiswa with a specific nipd that will collide
        $existing = Mahasiswa::create([
            'nama_mhs' => 'Existing',
            'email' => 'exist@example.com',
            'jurusan' => 'OAA',
            'nipd' => '2407810070003'
        ]);

        // prepare new attrs but force the same nipd on first attempt to simulate collision
        $attrs = [
            'nama_mhs' => 'New Student',
            'email' => 'new@example.com',
            'jurusan' => 'OAA',
            'nipd' => '2407810070003'
        ];

        $new = Mahasiswa::createWithUniqueNipd($attrs);

        $this->assertDatabaseHas('mahasiswas', ['id' => $new->id]);
        $this->assertNotEquals('2407810070003', $new->nipd);
    }
}
