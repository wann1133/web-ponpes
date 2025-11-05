<?php

namespace Database\Seeders;

use App\Models\DailySchedule;
use Illuminate\Database\Seeder;

class DailyScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['time' => '03.45', 'activity' => 'Qiyamul Lail & Dzikir Pagi', 'sort_order' => 10],
            ['time' => '04.30', 'activity' => 'Halaqah Tahfidz & Setoran Hafalan', 'sort_order' => 20],
            ['time' => '06.30', 'activity' => 'Olahraga & Persiapan Akademik', 'sort_order' => 30],
            ['time' => '08.00', 'activity' => 'Pembelajaran Diniyah Terpadu', 'sort_order' => 40],
            ['time' => '12.30', 'activity' => 'Dzuhur Berjamaah & Istirahat Siang', 'sort_order' => 50],
            ['time' => '14.00', 'activity' => 'Kelas Akademik & Klub Minat (STEM, Bahasa, Jurnalistik)', 'sort_order' => 60],
            ['time' => '17.00', 'activity' => 'Murajaah Mandiri & Kultum Sore', 'sort_order' => 70],
            ['time' => '19.30', 'activity' => 'Kajian Kitab & Tahsin Tilawah', 'sort_order' => 80],
            ['time' => '21.30', 'activity' => 'Evaluasi Harian & Tidur Malam', 'sort_order' => 90],
        ];

        foreach ($items as $item) {
            DailySchedule::firstOrCreate(
                ['time' => $item['time'], 'activity' => $item['activity']],
                $item
            );
        }
    }
}
