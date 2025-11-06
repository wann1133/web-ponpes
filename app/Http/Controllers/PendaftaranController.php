<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    private const JENJANG_OPTIONS = ['smp', 'sma'];

    public function index(): View
    {
        return view('pendaftaran.index');
    }

    public function create(string $jenjang): View
    {
        $jenjang = $this->ensureJenjang($jenjang);

        return view('pendaftaran.form', [
            'jenjang' => $jenjang,
        ]);
    }

    public function store(Request $request, string $jenjang): RedirectResponse
    {
        $jenjang = $this->ensureJenjang($jenjang);

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'nisn' => ['nullable', 'string', 'max:20'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'alamat' => ['required', 'string'],
            'asal_sekolah' => ['required', 'string', 'max:255'],
            'nama_ayah' => ['required', 'string', 'max:255'],
            'nama_ibu' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'regex:/^(\\+62|0)\\d{9,15}$/'],
            'email' => ['nullable', 'email'],
            'berkas_akta' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'berkas_kk' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $paths = [];

        foreach (['berkas_akta', 'berkas_kk'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $paths[$fileField] = $request->file($fileField)->store('pendaftaran', 'public');
            }
        }

        Registration::create(array_merge(
            ['jenjang' => $jenjang],
            $validated,
            $paths
        ));

        return redirect()
            ->route('pendaftaran.success')
            ->with('registered_jenjang', $jenjang);
    }

    public function success(): View
    {
        $jenjang = session('registered_jenjang');

        return view('pendaftaran.success', [
            'jenjang' => $jenjang,
        ]);
    }

    private function ensureJenjang(string $jenjang): string
    {
        $jenjang = strtolower($jenjang);

        if (! in_array($jenjang, self::JENJANG_OPTIONS, true)) {
            abort(404);
        }

        return $jenjang;
    }
}
