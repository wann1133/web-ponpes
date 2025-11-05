<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Bagaimana alur pendaftaran santri baru?',
                'answer' => 'Calon santri mengisi formulir online, melengkapi berkas administrasi, mengikuti seleksi baca Qur\'an dan wawancara orang tua, kemudian melakukan daftar ulang.',
                'sort_order' => 10,
            ],
            [
                'question' => 'Apakah tersedia program beasiswa?',
                'answer' => 'Tersedia beasiswa prestasi tahfidz dan beasiswa bantuan keringanan biaya bagi santri yatim atau dhuafa melalui seleksi khusus.',
                'sort_order' => 20,
            ],
            [
                'question' => 'Bagaimana fasilitas asrama dan kegiatan harian santri?',
                'answer' => 'Asrama berkapasitas 8 santri per kamar, dilengkapi ruang belajar, perpustakaan, laboratorium bahasa, dapur sehat, dan klinik kesehatan pesantren.',
                'sort_order' => 30,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
