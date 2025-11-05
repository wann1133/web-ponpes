<?php

namespace Database\Seeders;

use App\Models\InfoPageSetting;
use Illuminate\Database\Seeder;

class InfoPageSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InfoPageSetting::firstOrCreate([], [
            'hero_title' => 'Kegiatan & Pengumuman Pondok Pesantren Nurul Ikhlas',
            'hero_description' => 'Jadwal rutin, program unggulan, dan informasi pendaftaran santri baru yang mendukung perjalanan tahfidzul Qur\'an dan pembinaan karakter santri.',
            'registration_url' => 'https://forms.gle/xxxxxx',
            'phone' => '+62 812-3456-7890',
            'email' => 'info@nurulikhlas.sch.id',
            'address' => 'Jl. Pesantren No. 123, Desa Sejahtera, Kecamatan Cendikia, Kabupaten Bandung, Jawa Barat',
            'maps_url' => 'https://goo.gl/maps/5V7h1a9nKeL9WvJ9',
        ]);
    }
}
