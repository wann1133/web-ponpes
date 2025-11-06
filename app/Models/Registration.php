<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Registration extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'jenjang',
        'nama_lengkap',
        'jenis_kelamin',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'asal_sekolah',
        'nama_ayah',
        'nama_ibu',
        'no_wa',
        'email',
        'berkas_akta',
        'berkas_kk',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'berkas_akta_url',
        'berkas_kk_url',
    ];

    public function getBerkasAktaUrlAttribute(): ?string
    {
        return $this->berkas_akta ? Storage::disk('public')->url($this->berkas_akta) : null;
    }

    public function getBerkasKkUrlAttribute(): ?string
    {
        return $this->berkas_kk ? Storage::disk('public')->url($this->berkas_kk) : null;
    }
}
