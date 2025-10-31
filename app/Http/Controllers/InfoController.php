<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class InfoController extends Controller
{
    public function index(): View
    {
        $activities = [
            [
                'title' => 'Halaqah Tahfidz Pagi',
                'description' => 'Setoran hafalan dan murajaah juz yang telah ditentukan bersama musyrif setiap hari.',
                'schedule' => 'Setiap Hari | 04.30 - 06.00 WIB',
            ],
            [
                'title' => 'Kelas Diniyah & Kitab Kuning',
                'description' => 'Pembelajaran fiqh, tauhid, hadis, dan bahasa Arab berbasis kitab klasik dan kontemporer.',
                'schedule' => 'Senin - Kamis | 08.00 - 11.30 WIB',
            ],
            [
                'title' => 'Penguatan Karakter & Khidmat Sosial',
                'description' => 'Pembinaan leadership santri, layanan masyarakat, dan pelatihan dakwah kreatif.',
                'schedule' => 'Jumat & Sabtu | 14.00 - 16.30 WIB',
            ],
            [
                'title' => 'Tahsin & Tahqiq Tilawah',
                'description' => 'Pelatihan intensif tajwid dan makharijul huruf dengan metode talaqqi dan tasmi’.',
                'schedule' => 'Mingguan | 19.30 - 21.00 WIB',
            ],
        ];

        $announcements = [
            [
                'title' => 'Pendaftaran Santri Baru Tahun Ajaran 2025/2026',
                'summary' => 'Gelombang pertama dibuka sampai 30 April 2025, dengan kuota terbatas untuk program tahfidz reguler dan intensif.',
                'date' => '12 Februari 2025',
                'type' => 'Pendaftaran',
            ],
            [
                'title' => 'Kajian Umum Ustadz Dr. Hilmi Fauzan, Lc., MA',
                'summary' => 'Kajian tematik “Menjaga Kemurnian Hafalan” terbuka untuk umum pada 23 Maret 2025 di Masjid Jami Nurul Ikhlas.',
                'date' => '05 Maret 2025',
                'type' => 'Kajian',
            ],
            [
                'title' => 'Ujian Kenaikan Jilid & Tasmi’ Akbar',
                'summary' => 'Pelaksanaan ujian semester genap bagi seluruh santri dan tasmi’ akbar juz 30 oleh santri kelas tahsiliyah.',
                'date' => '18 Mei 2025',
                'type' => 'Akademik',
            ],
        ];

        $dailySchedule = [
            ['time' => '03.45', 'activity' => 'Qiyamul Lail & Dzikir Pagi'],
            ['time' => '04.30', 'activity' => 'Halaqah Tahfidz & Setoran Hafalan'],
            ['time' => '06.30', 'activity' => 'Olahraga & Persiapan Akademik'],
            ['time' => '08.00', 'activity' => 'Pembelajaran Diniyah Terpadu'],
            ['time' => '12.30', 'activity' => 'Dzuhur Berjamaah & Istirahat Siang'],
            ['time' => '14.00', 'activity' => 'Kelas Akademik & Klub Minat (STEM, Bahasa, Jurnalistik)'],
            ['time' => '17.00', 'activity' => 'Murajaah Mandiri & Kultum Sore'],
            ['time' => '19.30', 'activity' => 'Kajian Kitab & Tahsin Tilawah'],
            ['time' => '21.30', 'activity' => 'Evaluasi Harian & Tidur Malam'],
        ];

        $contact = [
            'phone' => '+62 812-3456-7890',
            'email' => 'info@nurulikhlas.sch.id',
            'address' => 'Jl. Pesantren No. 123, Desa Sejahtera, Kecamatan Cendikia, Kabupaten Bandung, Jawa Barat',
            'maps_url' => 'https://goo.gl/maps/5V7h1a9nKeL9wXvJ9',
        ];

        $faq = [
            [
                'question' => 'Bagaimana alur pendaftaran santri baru?',
                'answer' => 'Calon santri mengisi formulir online, melengkapi berkas administrasi, mengikuti seleksi baca Qur\'an dan wawancara orang tua, kemudian melakukan daftar ulang.',
            ],
            [
                'question' => 'Apakah tersedia program beasiswa?',
                'answer' => 'Tersedia beasiswa prestasi tahfidz dan beasiswa bantuan keringanan biaya bagi santri yatim/piatu atau keluarga dhuafa melalui seleksi khusus.',
            ],
            [
                'question' => 'Bagaimana fasilitas asrama dan kegiatan harian santri?',
                'answer' => 'Asrama berkapasitas 8 santri per kamar, dilengkapi ruang belajar, perpustakaan, laboratorium bahasa, dapur sehat, dan klinik kesehatan pesantren.',
            ],
        ];

        return view('pages.info', compact('activities', 'announcements', 'dailySchedule', 'contact', 'faq'));
    }
}
