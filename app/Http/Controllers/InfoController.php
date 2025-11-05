<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\DailySchedule;
use App\Models\Faq;
use App\Models\InfoPageSetting;
use Illuminate\View\View;

class InfoController extends Controller
{
    public function index(): View
    {
        $activities = Activity::ordered()->get();
        $announcements = Announcement::active()->orderByDesc('announcement_date')->orderBy('sort_order')->get();
        $dailySchedule = DailySchedule::ordered()->get();
        $settings = InfoPageSetting::current();
        $faq = Faq::active()->ordered()->get();

        return view('pages.info', compact('activities', 'announcements', 'dailySchedule', 'settings', 'faq'));
    }
}
