<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        Carbon::setLocale('id');

        $statistics = [
            ['value' => '320+', 'label' => 'Santri Tahfidz Aktif'],
            ['value' => '45', 'label' => 'Pengajar & Pembimbing'],
            ['value' => '15', 'label' => 'Angkatan Wisuda'],
            ['value' => '30', 'label' => 'Program Pembinaan'],
        ];

        $programs = [
            [
                'title' => 'Program Tahfidz 30 Juz',
                'description' => 'Pembinaan intensif dengan target hafalan harian, murajaah terstruktur, dan evaluasi bulanan.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 110 4m0-4v4m0 0h.01M12 14v6m0-6a2 2 0 100 4m0-4V6m0 14a2 2 0 11-4 0m4 0a2 2 0 104 0m-4 0h.01"/></svg>',
            ],
            [
                'title' => 'Madrasah Diniyah Terpadu',
                'description' => 'Kurikulum diniyah modern yang mengintegrasikan kajian kitab, bahasa Arab, dan pembinaan karakter Islami.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75c-1.148 0-2.083.935-2.083 2.083 0 1.148.935 2.084 2.083 2.084s2.083-.936 2.083-2.084A2.083 2.083 0 0012 6.75z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.25 9.75a7.25 7.25 0 11-14.5 0 7.25 7.25 0 0114.5 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.25v4.5"/></svg>',
            ],
            [
                'title' => 'Pengembangan Karakter & Leadership',
                'description' => 'Program kepemimpinan, khidmat sosial, dan mentoring untuk membentuk santri yang berakhlak mulia dan adaptif.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5l3.75-3.75 3.75 3.75"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75v16.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 12l3.75 3.75-3.75 3.75"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 15.75H3"/></svg>',
            ],
        ];

        $values = [
            [
                'title' => 'Keikhlasan',
                'description' => 'Membangun ketulusan niat dalam belajar, menghafal, dan mengabdi kepada Allah SWT.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21.75l-1.485-1.356C5.355 15.685 2.25 12.908 2.25 9.375c0-2.88 2.295-5.25 5.25-5.25 1.8 0 3.555.892 4.5 2.28 0.945-1.388 2.7-2.28 4.5-2.28 2.955 0 5.25 2.37 5.25 5.25 0 3.533-3.105 6.31-8.265 11.019L12 21.75z"/></svg>',
            ],
            [
                'title' => 'Tahfidz & Murajaah',
                'description' => 'Membimbing santri mencapai hafalan mutqin dengan murajaah terjadwal dan tasmi’ berkala.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v12m7.5 0c0 1.243-.894 2.301-2.121 2.474L12 19.5l-5.379-.526A2.495 2.495 0 014.5 16.5v-12c0-1.243.894-2.301 2.121-2.474L12 1.5l5.379.526A2.495 2.495 0 0119.5 4.5z"/></svg>',
            ],
            [
                'title' => 'Kedisiplinan',
                'description' => 'Menumbuhkan budaya disiplin, tanggung jawab, dan kemandirian dalam keseharian santri.',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5h15v15h-15z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 2.25v4.5M15 2.25v4.5M4.5 9h15"/></svg>',
            ],
        ];

        $highlights = [
            'Pesantren modern dengan program tahfidz terukur dan pendampingan personal setiap santri.',
            'Lingkungan asri, nyaman, dan kondusif untuk menghafal dan memahami Al-Qur\'an.',
            'Didukung pengajar bersanad dan kurikulum integratif antara diniyah dan akademik umum.',
        ];

        $blogPosts = BlogPost::published()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('pages.home', compact('statistics', 'programs', 'values', 'highlights', 'blogPosts'));
    }
}
