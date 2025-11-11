<?php

namespace App\Exports;

use App\Models\Registration;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private readonly ?string $jenjang = null)
    {
    }

    /**
     * @return Collection<int, Registration>
     */
    public function collection(): Collection
    {
        $query = Registration::query()->orderByDesc('created_at');

        if ($this->jenjang !== null) {
            $query->where('jenjang', $this->jenjang);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'Jenjang',
            'NISN',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Asal Sekolah',
            'Nama Ayah',
            'Nama Ibu',
            'No. WA',
            'Email',
            'Tanggal Daftar',
        ];
    }

    /**
     * @param Registration $registration
     */
    public function map($registration): array
    {
        return [
            $registration->nama_lengkap,
            strtoupper($registration->jenjang),
            $registration->nisn ?? '-',
            $registration->tempat_lahir,
            optional($registration->tanggal_lahir)?->format('Y-m-d'),
            $registration->alamat,
            $registration->asal_sekolah,
            $registration->nama_ayah,
            $registration->nama_ibu,
            $registration->no_wa,
            $registration->email ?? '-',
            $registration->created_at
                ->timezone(config('app.timezone'))
                ->format('Y-m-d H:i'),
        ];
    }
}
