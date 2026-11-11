<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InfoPageSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $safeUrlRule = function (string $attribute, mixed $value, \Closure $fail): void {
            if (filled($value) && ! preg_match('#^(/|https?://)#i', (string) $value)) {
                $fail('Tautan harus diawali dengan https://, http://, atau /.');
            }
        };

        return [
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'registration_url' => ['nullable', 'string', 'max:255', $safeUrlRule],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable', 'string', 'max:255'],
            'maps_url' => ['nullable', 'url', 'max:255'],

            'promo_is_active' => ['sometimes', 'boolean'],
            'promo_banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'reset_promo_banner' => ['sometimes', 'boolean'],
            'promo_link_url' => ['nullable', 'string', 'max:255', $safeUrlRule],
            'promo_auto_close_seconds' => ['nullable', 'integer', 'min:0', 'max:120'],

            'brochure_files' => ['nullable', 'array', 'max:10'],
            'brochure_files.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'existing_brochures' => ['nullable', 'array'],
            'existing_brochures.*' => ['string', 'max:255'],
            'delete_brochures' => ['nullable', 'array'],
            'delete_brochures.*' => ['string', 'max:255'],
            'brochure_form_present' => ['sometimes', 'boolean'],

            'registration_fee' => ['nullable', 'string', 'max:100'],
            'registration_fee_note' => ['nullable', 'string', 'max:500'],
            'registration_cta_title' => ['nullable', 'string', 'max:150'],
            'registration_cta_description' => ['nullable', 'string', 'max:500'],
            'registration_button_label' => ['nullable', 'string', 'max:100'],

            'registration_periods' => ['nullable', 'array', 'max:15'],
            'registration_periods.*.name' => ['nullable', 'string', 'max:100'],
            'registration_periods.*.date' => ['nullable', 'string', 'max:150'],

            'registration_requirements' => ['nullable', 'array', 'max:30'],
            'registration_requirements.*' => ['nullable', 'string', 'max:255'],

            'registration_procedures' => ['nullable', 'array', 'max:15'],
            'registration_procedures.*.title' => ['nullable', 'string', 'max:100'],
            'registration_procedures.*.description' => ['nullable', 'string', 'max:500'],

            'registration_contacts' => ['nullable', 'array', 'max:15'],
            'registration_contacts.*.name' => ['nullable', 'string', 'max:120'],
            'registration_contacts.*.phone' => ['nullable', 'string', 'max:50'],
            'registration_section_present' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'promo_banner.image' => 'Banner pop-up harus berupa file gambar yang valid.',
            'promo_banner.mimes' => 'Format banner pop-up harus JPG, JPEG, PNG, atau WebP.',
            'promo_banner.max' => 'Ukuran banner pop-up maksimal 10 MB.',
            'brochure_files.max' => 'Maksimal 10 gambar brosur dalam satu kali unggah.',
            'brochure_files.*.image' => 'Semua file brosur harus berupa gambar yang valid.',
            'brochure_files.*.mimes' => 'Format gambar brosur harus JPG, JPEG, PNG, atau WebP.',
            'brochure_files.*.max' => 'Ukuran setiap gambar brosur maksimal 10 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $payload = [
            'promo_is_active' => $this->boolean('promo_is_active'),
            'reset_promo_banner' => $this->boolean('reset_promo_banner'),
            'brochure_form_present' => $this->boolean('brochure_form_present'),
            'registration_section_present' => $this->boolean('registration_section_present'),
            'promo_auto_close_seconds' => $this->filled('promo_auto_close_seconds')
                ? (int) $this->input('promo_auto_close_seconds')
                : 0,
        ];

        if ($this->boolean('registration_section_present')) {
            $payload['registration_periods'] = $this->input('registration_periods', []);
            $payload['registration_requirements'] = $this->input('registration_requirements', []);
            $payload['registration_procedures'] = $this->input('registration_procedures', []);
            $payload['registration_contacts'] = $this->input('registration_contacts', []);
        }

        $this->merge($payload);
    }
}
