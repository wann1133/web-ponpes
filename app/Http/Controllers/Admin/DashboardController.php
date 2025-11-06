<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\BlogPost;
use App\Models\DailySchedule;
use App\Models\Faq;
use App\Models\InfoPageSetting;
use App\Models\Registration;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'activities' => Activity::count(),
            'announcements' => Announcement::count(),
            'blog_posts' => BlogPost::count(),
            'faqs' => Faq::count(),
            'daily_schedules' => DailySchedule::count(),
            'has_settings' => InfoPageSetting::query()->exists(),
            'registrations' => Registration::count(),
        ];

        $recentPosts = BlogPost::orderByDesc('published_at')->take(5)->get();
        $recentAnnouncements = Announcement::orderByDesc('announcement_date')->take(5)->get();
        $recentRegistrations = Registration::orderByDesc('created_at')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentAnnouncements', 'recentRegistrations'));
    }
}
