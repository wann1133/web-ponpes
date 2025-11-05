<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DailyScheduleRequest;
use App\Models\DailySchedule;

class DailyScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = DailySchedule::ordered()->get();

        return view('admin.daily-schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.daily-schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DailyScheduleRequest $request)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $this->nextSortOrder();

        DailySchedule::create($data);

        return redirect()
            ->route('admin.daily-schedules.index')
            ->with('status', 'Jadwal harian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailySchedule $dailySchedule)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailySchedule $dailySchedule)
    {
        return view('admin.daily-schedules.edit', ['schedule' => $dailySchedule]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DailyScheduleRequest $request, DailySchedule $dailySchedule)
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? $dailySchedule->sort_order;

        $dailySchedule->update($data);

        return redirect()
            ->route('admin.daily-schedules.index')
            ->with('status', 'Jadwal harian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailySchedule $dailySchedule)
    {
        $dailySchedule->delete();

        return redirect()
            ->route('admin.daily-schedules.index')
            ->with('status', 'Jadwal harian berhasil dihapus.');
    }

    private function nextSortOrder(): int
    {
        return (int) DailySchedule::max('sort_order') + 10;
    }
}
