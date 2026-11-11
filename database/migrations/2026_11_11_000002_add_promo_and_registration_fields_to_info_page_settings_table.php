<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('info_page_settings', function (Blueprint $table) {
            $table->boolean('promo_is_active')->default(true)->after('maps_url');
            $table->string('promo_banner_path')->nullable()->after('promo_is_active');
            $table->string('promo_link_url')->nullable()->after('promo_banner_path');
            $table->unsignedSmallInteger('promo_auto_close_seconds')->default(0)->after('promo_link_url');
            $table->json('brochure_images')->nullable()->after('promo_auto_close_seconds');

            $table->string('registration_fee')->nullable()->after('brochure_images');
            $table->text('registration_fee_note')->nullable()->after('registration_fee');
            $table->string('registration_cta_title')->nullable()->after('registration_fee_note');
            $table->text('registration_cta_description')->nullable()->after('registration_cta_title');
            $table->string('registration_button_label')->nullable()->after('registration_cta_description');
            $table->json('registration_periods')->nullable()->after('registration_button_label');
            $table->json('registration_requirements')->nullable()->after('registration_periods');
            $table->json('registration_procedures')->nullable()->after('registration_requirements');
            $table->json('registration_contacts')->nullable()->after('registration_procedures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('info_page_settings', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};
