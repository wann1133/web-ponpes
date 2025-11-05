<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InfoPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_description',
        'registration_url',
        'phone',
        'email',
        'address',
        'maps_url',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create();
    }
}
