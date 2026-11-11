<?php

namespace App\Models;

use App\Services\BlogImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPageSetting extends Model
{
    use HasFactory;

    public const DEFAULT_BANNER_PATH = 'images/promo/banner-psb-default.jpg';

    public const DEFAULT_BROCHURE_PATHS = [
        'images/promo/brosur-psb-1.jpg',
        'images/promo/brosur-psb-2.jpg',
    ];

    protected $fillable = [
        'hero_title',
        'hero_description',
        'registration_url',
        'phone',
        'email',
        'address',
        'maps_url',
        'promo_is_active',
        'promo_banner_path',
        'promo_link_url',
        'promo_auto_close_seconds',
        'brochure_images',
        'registration_fee',
        'registration_fee_note',
        'registration_cta_title',
        'registration_cta_description',
        'registration_button_label',
        'registration_periods',
        'registration_requirements',
        'registration_procedures',
        'registration_contacts',
    ];

    protected $casts = [
        'promo_is_active' => 'boolean',
        'promo_auto_close_seconds' => 'integer',
        'brochure_images' => 'array',
        'registration_periods' => 'array',
        'registration_requirements' => 'array',
        'registration_procedures' => 'array',
        'registration_contacts' => 'array',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create();
    }

    public static function isBundledPromoPath(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        return in_array($path, array_merge(
            [self::DEFAULT_BANNER_PATH, 'poster.png'],
            self::DEFAULT_BROCHURE_PATHS
        ), true);
    }

    public static function defaultRegistrationPeriods(): array
    {
        return [
            ['name' => 'Gelombang 1', 'date' => '1 Oktober 2026 – 20 Februari 2027'],
            ['name' => 'Gelombang 2', 'date' => '21 Februari 2027 – 30 April 2027'],
            ['name' => 'Gelombang 3', 'date' => '1 Mei 2027 – 30 Juni 2027'],
        ];
    }

    public static function defaultRegistrationRequirements(): array
    {
        return [
            'Surat Keterangan Lulus (SKL)',
            'Fotokopi Akta Kelahiran',
            'Fotokopi KTP Orang Tua',
            'Fotokopi Kartu Keluarga',
        ];
    }

    public static function defaultRegistrationProcedures(): array
    {
        return [
            [
                'title' => 'Offline',
                'description' => 'Datang langsung ke pesantren dan membawa seluruh persyaratan.',
            ],
            [
                'title' => 'Online',
                'description' => 'Menghubungi kontak pendaftaran atau mengisi formulir online untuk verifikasi berkas dan biaya.',
            ],
        ];
    }

    public static function defaultRegistrationContacts(): array
    {
        return [
            ['name' => 'Ust. Ian Apriansyah', 'phone' => '0823-1135-5517'],
            ['name' => 'Ust. Bahaudin (SMA)', 'phone' => '0813-8240-8479'],
            ['name' => 'Ust. Ahmad', 'phone' => '0812-9041-8612'],
        ];
    }

    public function getPromoBannerUrlAttribute(): ?string
    {
        $custom = BlogImageService::resolveUrl($this->promo_banner_path);
        if ($custom !== null) {
            return $custom;
        }

        return BlogImageService::resolveUrl(self::DEFAULT_BANNER_PATH)
            ?? BlogImageService::resolveUrl('poster.png');
    }

    public function getHasCustomPromoBannerAttribute(): bool
    {
        return filled($this->promo_banner_path)
            && ! self::isBundledPromoPath($this->promo_banner_path)
            && BlogImageService::resolveUrl($this->promo_banner_path) !== null;
    }

    public function getEffectivePromoLinkAttribute(): string
    {
        return filled($this->promo_link_url) ? $this->promo_link_url : route('pendaftaran.index');
    }

    public function getIsPromoEnabledAttribute(): bool
    {
        return ($this->promo_is_active ?? true) && $this->promo_banner_url !== null;
    }

    /**
     * @return array<int, array{path: string, url: string, label: string}>
     */
    public function getResolvedBrochuresAttribute(): array
    {
        $paths = is_array($this->brochure_images)
            ? $this->brochure_images
            : self::DEFAULT_BROCHURE_PATHS;

        $items = [];
        foreach (array_values($paths) as $index => $path) {
            $url = BlogImageService::resolveUrl((string) $path);
            if ($url === null) {
                continue;
            }

            $items[] = [
                'path' => (string) $path,
                'url' => $url,
                'label' => 'Brosur Halaman '.($index + 1),
            ];
        }

        return $items;
    }

    public function getEffectiveRegistrationUrlAttribute(): string
    {
        if (blank($this->registration_url) || $this->registration_url === 'https://forms.gle/xxxxxx') {
            return route('pendaftaran.index');
        }

        return $this->registration_url;
    }

    public function getEffectiveRegistrationFeeAttribute(): string
    {
        return filled($this->registration_fee) ? $this->registration_fee : 'Rp 250.000,00';
    }

    public function getEffectiveRegistrationFeeNoteAttribute(): string
    {
        return filled($this->registration_fee_note)
            ? $this->registration_fee_note
            : 'Biaya administrasi pendaftaran santri baru. Tersedia potongan biaya Rp 500.000 bagi siswa berprestasi 10 besar atau hafidz minimal 1 juz.';
    }

    public function getEffectiveRegistrationCtaTitleAttribute(): string
    {
        return filled($this->registration_cta_title)
            ? $this->registration_cta_title
            : 'Pendaftaran Online';
    }

    public function getEffectiveRegistrationCtaDescriptionAttribute(): string
    {
        return filled($this->registration_cta_description)
            ? $this->registration_cta_description
            : 'Kami menyediakan brosur resmi dan formulir pendaftaran santri baru secara daring.';
    }

    public function getEffectiveRegistrationButtonLabelAttribute(): string
    {
        return filled($this->registration_button_label)
            ? $this->registration_button_label
            : 'Form Pendaftaran Online';
    }

    public function getResolvedRegistrationPeriodsAttribute(): array
    {
        if (is_array($this->registration_periods)) {
            return $this->registration_periods;
        }

        return self::defaultRegistrationPeriods();
    }

    public function getResolvedRegistrationRequirementsAttribute(): array
    {
        if (is_array($this->registration_requirements)) {
            return $this->registration_requirements;
        }

        return self::defaultRegistrationRequirements();
    }

    public function getResolvedRegistrationProceduresAttribute(): array
    {
        if (is_array($this->registration_procedures)) {
            return $this->registration_procedures;
        }

        return self::defaultRegistrationProcedures();
    }

    public function getResolvedRegistrationContactsAttribute(): array
    {
        if (is_array($this->registration_contacts)) {
            return $this->registration_contacts;
        }

        return self::defaultRegistrationContacts();
    }
}
