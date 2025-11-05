<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementRequest;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::orderByDesc('announcement_date')
            ->orderBy('sort_order')
            ->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementRequest $request)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $this->nextSortOrder();

        Announcement::create($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $announcement->sort_order;

        $announcement->update($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'Pengumuman berhasil dihapus.');
    }

    private function nextSortOrder(): int
    {
        return (int) Announcement::max('sort_order') + 10;
    }
}
