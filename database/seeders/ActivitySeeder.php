<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'title' => 'Halaqah Tahfidz Pagi',
                'description' => 'Setoran hafalan dan murajaah juz yang telah ditentukan bersama musyrif setiap hari.',
                'schedule' => 'Setiap Hari | 04.30 - 06.00 WIB',
                'sort_order' => 10,
            ],
            [
                'title' => 'Kelas Diniyah & Kitab Kuning',
                'description' => 'Pembelajaran fiqh, tauhid, hadis, dan bahasa Arab berbasis kitab klasik dan kontemporer.',
                'schedule' => 'Senin - Kamis | 08.00 - 11.30 WIB',
                'sort_order' => 20,
            ],
            [
                'title' => 'Penguatan Karakter & Khidmat Sosial',
                'description' => 'Pembinaan leadership santri, layanan masyarakat, dan pelatihan dakwah kreatif.',
                'schedule' => 'Jumat & Sabtu | 14.00 - 16.30 WIB',
                'sort_order' => 30,
            ],
            [
                'title' => 'Tahsin & Tahqiq Tilawah',
                'description' => 'Pelatihan intensif tajwid dan makharijul huruf dengan metode talaqqi dan tasmi.',
                'schedule' => 'Mingguan | 19.30 - 21.00 WIB',
                'sort_order' => 40,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::firstOrCreate(
                ['title' => $activity['title']],
                $activity
            );
        }
    }
}
