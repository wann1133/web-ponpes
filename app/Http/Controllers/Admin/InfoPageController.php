<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InfoPageSettingRequest;
use App\Models\InfoPageSetting;

class InfoPageController extends Controller
{
    public function edit()
    {
        $settings = InfoPageSetting::current();

        return view('admin.info-page.edit', compact('settings'));
    }

    public function update(InfoPageSettingRequest $request)
    {
        $settings = InfoPageSetting::current();
        $settings->update($request->validated());

        return redirect()
            ->route('admin.info-page.edit')
            ->with('status', 'Pengaturan halaman info berhasil disimpan.');
    }
}
