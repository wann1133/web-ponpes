# Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas

Website statis modern berbasis **Laravel 11**, **TailwindCSS**, dan **Alpine.js** untuk menampilkan profil, kegiatan, dan blog Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas. Seluruh konten bersifat statis sehingga mudah dipublikasikan di shared hosting tanpa membutuhkan database dinamis.

## Fitur Utama
- Navigasi sticky dengan dukungan menu mobile.
- Hero section dengan overlay hijau lembut dan statistik pesantren.
- Halaman Info berisi program harian, pengumuman, jadwal, FAQ, dan kontak.
- Halaman Blog menampilkan artikel dummy dari berkas JSON statis.
- Komponen Blade reusable (`navbar`, `footer`, `card`) dan layout tunggal.
- Desain responsif dengan tema hijau-putih dan tipografi Poppins & Inter.
- Struktur HTML5 semantik, meta tag SEO, dan optimasi micro-copy untuk lembaga pendidikan Islam.

## Teknologi
- PHP 8.2+, Laravel 11
- TailwindCSS, @tailwindcss/forms, @tailwindcss/typography
- Alpine.js untuk interaksi ringan
- Vite sebagai bundler aset

## Prasyarat
- PHP >= 8.2 dengan ekstensi `mbstring`, `openssl`, `pdo`, `fileinfo`.
- Composer >= 2.6
- Node.js >= 18 dan npm.

## Cara Menjalankan

```bash
# 1. Instal PHP dependencies
composer install

# 2. Salin ENV bila perlu dan set key
cp .env.example .env
php artisan key:generate

# 3. Instal dependensi frontend
npm install

# 4a. Mode pengembangan (Hot Module Replacement)
npm run dev
php artisan serve

# 4b. Build untuk produksi
npm run build
```

> Environment sudah dikonfigurasi untuk zona waktu `Asia/Jakarta` dan locale `id`.

## Struktur Konten

```
resources/
  views/
    layouts/app.blade.php      # layout utama
    components/                # navbar, footer, card
    pages/
      home.blade.php
      info.blade.php
      blog.blade.php
  data/blog.json               # sumber data artikel dummy
public/
  images/pondok-hero.jpg       # taruh foto hero di sini
  images/blog/*.jpg            # thumbnail artikel
```

- **Blog** menggunakan data statis di `resources/data/blog.json`. Tambahkan/ubah entri untuk menyesuaikan isi berita.
- Gambar hero dan thumbnail akan otomatis menggunakan fallback dari Unsplash bila berkas lokal belum tersedia. Tambahkan berkas nyata untuk produksi agar identitas lembaga lebih kuat.

## Penyesuaian Disarankan
1. Ganti data kontak, sosial media, dan koordinat Google Maps di `resources/views/components/footer.blade.php`.
2. Sesuaikan nomor WhatsApp, jadwal, dan pengumuman di `InfoController`.
3. Tambahkan foto asli ke `public/images/pondok-hero.jpg` dan direktori `public/images/blog/`.
4. Jika akan dipublikasikan di shared hosting:
   - Jalankan `npm run build`.
   - Pastikan `APP_ENV=production` dan `APP_DEBUG=false` pada `.env`.
   - Upload folder `public` sebagai root (atau arahkan document root ke `public/`).

## Testing & Pemeliharaan
- Jalankan `npm run build` sebelum deploy untuk memastikan CSS/JS terkompilasi rapi.
- Karena konten statis, perbarui data melalui controller atau JSON tanpa perlu migrasi database.

Selamat menggunakan! Semoga website ini membantu menghadirkan wajah pesantren yang modern dan inspiratif. Jika ada pertanyaan atau butuh pengembangan lanjutan, silakan hubungi tim teknis Anda. 
