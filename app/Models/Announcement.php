<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
        'announcement_date',
        'type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'announcement_date' => 'date',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('announcement_date')->orderBy('sort_order');
    }

    public function formattedDate(): ?string
    {
        /** @var Carbon|null $date */
        $date = $this->announcement_date;

        return $date ? $date->translatedFormat('d F Y') : null;
    }
}
