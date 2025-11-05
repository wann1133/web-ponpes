<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => "Wisuda Hifdzil Qur'an Angkatan 2025",
                'slug' => 'wisuda-hifdzil-quran-angkatan-2025',
                'excerpt' => 'Sebanyak 45 santri berhasil menyelesaikan hafalan 30 juz dalam wisuda tahunan Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas.',
                'category' => 'Prestasi Santri',
                'author' => 'Ustadz Ahmad Fauzi',
                'reading_time' => '4 menit',
                'thumbnail_path' => 'images/blog/wisuda-2025.jpg',
                'external_url' => null,
                'body' => <<<BODY
Momentum wisuda tahun ini menjadi bukti kesungguhan santri dan pembimbing dalam menjaga hafalan Al-Qur'an. Selama satu tahun terakhir, para wisudawan mengikuti program murajaah intensif, tasmi', dan bimbingan karakter yang dirancang untuk menjaga hafalan tetap terjaga.

Acara dilaksanakan di aula utama pesantren dan dihadiri oleh wali santri, tokoh masyarakat, serta para masyayikh. Setiap wisudawan membacakan pilihan ayat di hadapan tamu undangan dan menerima sanad hafalan dari dewan musyrif.

Kami mengucapkan terima kasih kepada seluruh pihak yang telah mendukung perjalanan tahfidz para santri. Semoga para hafidz dan hafidzah ini menjadi penjaga Kalamullah yang amanah dan rendah hati.
BODY,
                'published_at' => Carbon::create(2025, 5, 30),
                'is_featured' => true,
            ],
            [
                'title' => 'Program Pesantren Kilat Ramadhan 1446 H',
                'slug' => 'program-pesantren-kilat-ramadhan-1446-h',
                'excerpt' => 'Pesantren kilat menghadirkan rangkaian kajian tematik, halaqah tahfidz, dan kegiatan sosial bagi santri dan masyarakat sekitar.',
                'category' => 'Program Pesantren',
                'author' => 'Ustadzah Siti Hasanah',
                'reading_time' => '3 menit',
                'thumbnail_path' => 'images/blog/pesantren-kilat.jpg',
                'external_url' => null,
                'body' => <<<BODY
Pesantren kilat Ramadhan menjadi agenda tahunan yang dinantikan masyarakat sekitar. Tahun ini, program dibagi menjadi tiga jalur: halaqah tahfidz remaja, kajian tematik untuk umum, serta kelas keterampilan dan bakti sosial.

Seluruh rangkaian difasilitasi oleh asatidzah dengan pendekatan dialogis dan aplikatif. Peserta juga diajak untuk menghidupkan malam Ramadhan dengan qiyamul lail berjamaah serta tadarus Al-Qur'an terarah.

Kami membuka pendaftaran hingga H-3 sebelum Ramadhan. Silakan hubungi admin pesantren untuk detail jadwal dan kebutuhan administrasi.
BODY,
                'published_at' => Carbon::create(2025, 3, 12),
            ],
            [
                'title' => 'Peluncuran Rumah Tahfidz Cabang Nurul Ikhlas',
                'slug' => 'peluncuran-rumah-tahfidz-cabang-nurul-ikhlas',
                'excerpt' => 'Pondok Pesantren Nurul Ikhlas resmi membuka rumah tahfidz cabang yang akan fokus pada pembinaan hafalan anak usia 7-12 tahun.',
                'category' => 'Ekspansi & Kemitraan',
                'author' => 'Humas Nurul Ikhlas',
                'reading_time' => '5 menit',
                'thumbnail_path' => 'images/blog/rumah-tahfidz.jpg',
                'external_url' => null,
                'body' => <<<BODY
Rumah tahfidz cabang pertama ini hadir sebagai bagian dari program perluasan layanan tahfidz usia dini. Kurikulum dirancang menyesuaikan kebutuhan anak dengan porsi hafalan harian ringan, tahsin dasar, serta pendampingan akhlak.

Gedung cabang berlokasi di pusat kota sehingga memudahkanakses masyarakat. Fasilitas mencakup ruang kelas tematik, studio tilawah, hingga perpustakaan mini yang mendukung literasi Qur'ani.

Kami mengundang orang tua untuk bergabung dalam sesi sosialisasi setiap akhir pekan. Informasi lebih lanjut tersedia melalui kanal resmi pesantren.
BODY,
                'published_at' => Carbon::create(2025, 2, 8),
            ],
            [
                'title' => 'Rihlah Ilmiah Santri ke Museum Konferensi Asia-Afrika',
                'slug' => 'rihlah-ilmiah-santri-ke-museum-k-aa',
                'excerpt' => 'Rihlah ilmiah memberikan pengalaman sejarah dan menumbuhkan rasa cinta tanah air bagi santri Nurul Ikhlas.',
                'category' => 'Kegiatan Santri',
                'author' => 'Ustadz Yusuf Maulana',
                'reading_time' => '6 menit',
                'thumbnail_path' => 'images/blog/rihlah-ilmiah.jpg',
                'external_url' => null,
                'body' => <<<BODY
Sebagai bagian dari program literasi sejarah, santri kelas menengah mengikuti rihlah ilmiah ke Museum Konferensi Asia-Afrika. Mereka mempelajari kiprah para tokoh bangsa dan nilai persaudaraan antarnegara yang sejalan dengan pesan universal Al-Qur'an.

Kegiatan diisi dengan tur edukatif, diskusi tematik, dan penugasan membuat jurnal perjalanan. Santri diajak menuliskan refleksi tentang peran pemuda muslim dalam menjaga persatuan dan perdamaian.

Rihlah akan terus dilaksanakan dengan tujuan berbeda setiap semester agar santri memiliki perspektif luas dan siap mengabdi kepada masyarakat.
BODY,
                'published_at' => Carbon::create(2025, 1, 18),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(
                ['slug' => $post['slug']],
                array_merge($post, [
                    'is_published' => true,
                ])
            );
        }
    }
}
