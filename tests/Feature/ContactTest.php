<?php

use App\Models\Notifikasi;

test('contact form validation works', function () {
    $this->post('/kontak', [])
        ->assertSessionHasErrors(['nama', 'email', 'pesan']);
});

test('contact form sends message to admin', function () {
    $response = $this->post('/kontak', [
        'nama'  => 'Pengunjung Test',
        'email' => 'pengunjung@example.com',
        'no_hp' => '081234567890',
        'pesan' => 'Saya ingin bertanya tentang membership.',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    expect(
        Notifikasi::where('judul', 'Pesan Kontak Baru')
            ->where('isi', 'like', '%Pengunjung Test%')
            ->exists()
    )->toBeTrue();
});
