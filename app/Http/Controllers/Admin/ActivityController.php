<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActivityRequest;
use App\Models\Activity;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::ordered()->get();

        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $request)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $this->nextSortOrder();

        Activity::create($data);

        return redirect()
            ->route('admin.activities.index')
            ->with('status', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $activity->sort_order;

        $activity->update($data);

        return redirect()
            ->route('admin.activities.index')
            ->with('status', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()
            ->route('admin.activities.index')
            ->with('status', 'Kegiatan berhasil dihapus.');
    }

    private function nextSortOrder(): int
    {
        return (int) Activity::max('sort_order') + 10;
    }
}
