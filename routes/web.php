<?php

use App\Http\Controllers\Admin\ActivityController as AdminActivityController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DailyScheduleController as AdminDailyScheduleController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\InfoPageController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/info', [InfoController::class, 'index'])->name('info');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
Route::get('/pendaftaran/{jenjang}', [PendaftaranController::class, 'create'])
    ->whereIn('jenjang', ['smp', 'sma'])
    ->name('pendaftaran.create');
Route::post('/pendaftaran/{jenjang}', [PendaftaranController::class, 'store'])
    ->whereIn('jenjang', ['smp', 'sma'])
    ->name('pendaftaran.store');
Route::get('/pendaftaran/sukses', [PendaftaranController::class, 'success'])->name('pendaftaran.success');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])->name('admin.login.store');

    Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
    Route::post('/login', fn () => redirect()->route('admin.login'));
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('activities', AdminActivityController::class)->except(['show']);
    Route::resource('announcements', AdminAnnouncementController::class)->except(['show']);
    Route::resource('daily-schedules', AdminDailyScheduleController::class)
        ->parameters(['daily-schedules' => 'daily_schedule'])
        ->except(['show']);
    Route::resource('faqs', AdminFaqController::class)->except(['show']);
    Route::resource('blog-posts', AdminBlogPostController::class)->except(['show']);
    Route::resource('registrations', AdminRegistrationController::class)->only(['index']);

    Route::get('info-page', [InfoPageController::class, 'edit'])->name('info-page.edit');
    Route::put('info-page', [InfoPageController::class, 'update'])->name('info-page.update');
});
