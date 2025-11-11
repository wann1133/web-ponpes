<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Pendaftar</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 4px;
        }
        p {
            margin: 0 0 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #cbd5f5;
            padding: 6px 4px;
        }
        th {
            background-color: #e0ebff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        td {
            vertical-align: top;
        }
        .text-muted {
            color: #6b7280;
        }
    </style>
</head>
<body>
    <h1>Data Pendaftar {{ $jenjang ? strtoupper($jenjang) : 'Semua Jenjang' }}</h1>
    <p class="text-muted">Digenerasi pada {{ $generatedAt->format('d M Y H:i') }} WIB</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Jenjang</th>
                <th>Kontak</th>
                <th>Orang Tua</th>
                <th>Asal Sekolah</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $registration)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div><strong>{{ $registration->nama_lengkap }}</strong></div>
                        <div class="text-muted">
                            {{ $registration->tempat_lahir }},
                            {{ $registration->tanggal_lahir?->format('d M Y') ?? '-' }}
                        </div>
                    </td>
                    <td>{{ strtoupper($registration->jenjang) }}</td>
                    <td>
                        <div>WA: {{ $registration->no_wa }}</div>
                        <div>Email: {{ $registration->email ?? '-' }}</div>
                    </td>
                    <td>
                        <div>Ayah: {{ $registration->nama_ayah }}</div>
                        <div>Ibu: {{ $registration->nama_ibu }}</div>
                    </td>
                    <td>
                        <div>{{ $registration->asal_sekolah }}</div>
                        <div class="text-muted">{{ $registration->alamat }}</div>
                    </td>
                    <td>{{ $registration->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
