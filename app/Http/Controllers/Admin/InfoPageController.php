<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InfoPageSettingRequest;
use App\Models\InfoPageSetting;
use App\Services\BlogImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class InfoPageController extends Controller
{
    public function __construct(private readonly BlogImageService $imageService)
    {
    }

    public function edit()
    {
        $settings = InfoPageSetting::current();

        return view('admin.info-page.edit', compact('settings'));
    }

    public function update(InfoPageSettingRequest $request)
    {
        $settings = InfoPageSetting::current();
        $validated = $request->validated();

        $data = Arr::except($validated, [
            'promo_banner',
            'reset_promo_banner',
            'brochure_files',
            'existing_brochures',
            'delete_brochures',
            'brochure_form_present',
            'registration_section_present',
        ]);

        if ($request->boolean('reset_promo_banner')) {
            $this->deleteIfCustomPromoFile($settings->promo_banner_path);
            $data['promo_banner_path'] = null;
        }

        if ($request->hasFile('promo_banner')) {
            $this->deleteIfCustomPromoFile($settings->promo_banner_path);
            $data['promo_banner_path'] = $this->imageService->storeCompressed(
                $request->file('promo_banner'),
                'images/promo',
                1600,
                85
            );
        }

        if ($request->boolean('brochure_form_present') || $request->hasFile('brochure_files')) {
            $data['brochure_images'] = $this->syncBrochureImages(
                $settings,
                $validated['existing_brochures'] ?? [],
                $validated['delete_brochures'] ?? [],
                $request->file('brochure_files', [])
            );
        }

        if (array_key_exists('registration_periods', $validated)) {
            $data['registration_periods'] = $this->cleanPairList(
                $validated['registration_periods'] ?? [],
                'name',
                'date'
            );
        }

        if (array_key_exists('registration_requirements', $validated)) {
            $data['registration_requirements'] = array_values(array_filter(
                array_map(fn ($item) => trim((string) $item), $validated['registration_requirements'] ?? []),
                fn ($item) => $item !== ''
            ));
        }

        if (array_key_exists('registration_procedures', $validated)) {
            $data['registration_procedures'] = $this->cleanPairList(
                $validated['registration_procedures'] ?? [],
                'title',
                'description'
            );
        }

        if (array_key_exists('registration_contacts', $validated)) {
            $data['registration_contacts'] = $this->cleanPairList(
                $validated['registration_contacts'] ?? [],
                'name',
                'phone'
            );
        }

        $settings->update($data);

        return redirect()
            ->route('admin.info-page.edit')
            ->with('status', 'Pengaturan halaman info, brosur, & pendaftaran berhasil disimpan.');
    }

    /**
     * @param  array<int, string>  $orderedPaths
     * @param  array<int, string>  $deletePaths
     * @param  array<int, UploadedFile|mixed>  $newFiles
     * @return array<int, string>
     */
    private function syncBrochureImages(
        InfoPageSetting $settings,
        array $orderedPaths,
        array $deletePaths,
        array $newFiles
    ): array {
        $knownPaths = is_array($settings->brochure_images)
            ? $settings->brochure_images
            : InfoPageSetting::DEFAULT_BROCHURE_PATHS;

        $knownLookup = array_flip($knownPaths);
        $deleteLookup = array_flip($deletePaths);

        foreach ($deletePaths as $path) {
            if (isset($knownLookup[$path])) {
                $this->deleteIfCustomPromoFile($path);
            }
        }

        $kept = [];
        foreach ($orderedPaths as $path) {
            if (! isset($knownLookup[$path]) || isset($deleteLookup[$path]) || in_array($path, $kept, true)) {
                continue;
            }
            $kept[] = $path;
        }

        foreach ($newFiles as $file) {
            if (! ($file instanceof UploadedFile) || ! $file->isValid()) {
                continue;
            }

            $kept[] = $this->imageService->storeCompressed($file, 'images/promo', 2000, 86);
        }

        return $kept;
    }

    private function deleteIfCustomPromoFile(?string $path): void
    {
        if (blank($path) || InfoPageSetting::isBundledPromoPath($path)) {
            return;
        }

        $this->imageService->deleteFile($path);
    }

    /**
     * Filter out repeater rows where both fields are empty.
     *
     * @param  array<int, array<string, mixed>>  $rows
     * @return array<int, array<string, string>>
     */
    private function cleanPairList(array $rows, string $firstKey, string $secondKey): array
    {
        $cleaned = [];

        foreach ($rows as $row) {
            $first = trim((string) ($row[$firstKey] ?? ''));
            $second = trim((string) ($row[$secondKey] ?? ''));

            if ($first === '' && $second === '') {
                continue;
            }

            $cleaned[] = [
                $firstKey => $first,
                $secondKey => $second,
            ];
        }

        return $cleaned;
    }
}
