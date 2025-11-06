<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $jenjang = $request->query('jenjang');

        $query = Registration::query()->orderByDesc('created_at');

        if ($jenjang && in_array($jenjang, ['smp', 'sma'], true)) {
            $query->where('jenjang', $jenjang);
        } else {
            $jenjang = null;
        }

        $registrations = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Registration::count(),
            'smp' => Registration::where('jenjang', 'smp')->count(),
            'sma' => Registration::where('jenjang', 'sma')->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'stats', 'jenjang'));
    }
}
