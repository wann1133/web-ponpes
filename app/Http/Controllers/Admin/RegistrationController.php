<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RegistrationsExport;
use App\Http\Controllers\Controller;
use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RegistrationController extends Controller
{
    private const ALLOWED_JENJANG = ['smp', 'sma'];

    public function index(Request $request): View
    {
        [$query, $jenjang] = $this->filteredQuery($request->query('jenjang'));

        $registrations = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Registration::count(),
            'smp' => Registration::where('jenjang', 'smp')->count(),
            'sma' => Registration::where('jenjang', 'sma')->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'stats', 'jenjang'));
    }

    public function exportExcel(Request $request): BinaryFileResponse
    {
        [, $jenjang] = $this->filteredQuery($request->query('jenjang'));

        $fileName = $this->buildExportFileName('excel', $jenjang, 'xlsx');

        return Excel::download(new RegistrationsExport($jenjang), $fileName);
    }

    public function exportPdf(Request $request): Response
    {
        [$query, $jenjang] = $this->filteredQuery($request->query('jenjang'));
        $registrations = $query->get();

        $pdf = Pdf::loadView('admin.registrations.pdf', [
            'registrations' => $registrations,
            'jenjang' => $jenjang,
            'generatedAt' => now()->timezone(config('app.timezone')),
        ])->setPaper('a4', 'landscape');

        return $pdf->download($this->buildExportFileName('pdf', $jenjang, 'pdf'));
    }

    /**
     * @return array{0:\Illuminate\Database\Eloquent\Builder, 1:?string}
     */
    private function filteredQuery(?string $requestedJenjang): array
    {
        $query = Registration::query()->orderByDesc('created_at');
        $jenjang = null;

        if ($requestedJenjang && in_array($requestedJenjang, self::ALLOWED_JENJANG, true)) {
            $jenjang = $requestedJenjang;
            $query->where('jenjang', $jenjang);
        }

        return [$query, $jenjang];
    }

    private function buildExportFileName(string $format, ?string $jenjang, string $extension): string
    {
        $parts = ['pendaftar'];
        $parts[] = $jenjang ?? 'semua';
        $parts[] = $format;
        $parts[] = now()->format('Ymd_His');

        return implode('-', $parts) . '.' . $extension;
    }
}
