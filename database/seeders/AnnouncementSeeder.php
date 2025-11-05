<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Pendaftaran Santri Baru Tahun Ajaran 2025/2026',
                'summary' => 'Gelombang pertama dibuka sampai 30 April 2025, dengan kuota terbatas untuk program tahfidz reguler dan intensif.',
                'announcement_date' => Carbon::create(2025, 2, 12),
                'type' => 'Pendaftaran',
                'sort_order' => 10,
            ],
            [
                'title' => 'Kajian Umum Ustadz Dr. Hilmi Fauzan, Lc., MA',
                'summary' => 'Kajian tematik "Menjaga Kemurnian Hafalan" terbuka untuk umum pada 23 Maret 2025 di Masjid Jami Nurul Ikhlas.',
                'announcement_date' => Carbon::create(2025, 3, 5),
                'type' => 'Kajian',
                'sort_order' => 20,
            ],
            [
                'title' => 'Ujian Kenaikan Jilid & Tasmi Akbar',
                'summary' => 'Pelaksanaan ujian semester genap bagi seluruh santri dan tasmi akbar juz 30 oleh santri kelas tahsiliyah.',
                'announcement_date' => Carbon::create(2025, 5, 18),
                'type' => 'Akademik',
                'sort_order' => 30,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::firstOrCreate(
                ['title' => $announcement['title']],
                $announcement
            );
        }
    }
}
