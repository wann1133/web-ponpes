<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\BlogPost;
use App\Models\DailySchedule;
use App\Models\Faq;
use App\Models\InfoPageSetting;

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
        ];

        $recentPosts = BlogPost::orderByDesc('published_at')->take(5)->get();
        $recentAnnouncements = Announcement::orderByDesc('announcement_date')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentAnnouncements'));
    }
}
