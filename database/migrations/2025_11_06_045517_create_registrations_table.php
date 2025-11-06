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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->enum('jenjang', ['smp', 'sma']);
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('nisn', 20)->nullable();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('asal_sekolah');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('no_wa', 20);
            $table->string('email')->nullable();
            $table->string('berkas_akta')->nullable();
            $table->string('berkas_kk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
