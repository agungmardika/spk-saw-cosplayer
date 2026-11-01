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
        Schema::create('cosplayer', function (Blueprint $table) {
            $table->id('id_cosplayer');
            $table->string('no_peserta', 10)->unique();
            $table->string('nama_peserta', 100);
            $table->string('nama_karakter', 100);
            $table->string('asal_series', 100);
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        Schema::create('kriteria', function (Blueprint $table) {
            $table->id('id_kriteria');
            $table->string('kode_kriteria', 5)->unique();
            $table->string('nama_kriteria', 50);
            $table->float('bobot');
            $table->string('jenis', 10)->default('benefit');
            $table->timestamps();
        });

        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('id_cosplayer')->constrained('cosplayer', 'id_cosplayer')->cascadeOnDelete();
            $table->foreignId('id_kriteria')->constrained('kriteria', 'id_kriteria')->cascadeOnDelete();
            $table->float('nilai');
            $table->timestamps();

            $table->unique(['id_cosplayer', 'id_kriteria']);
        });

        Schema::create('hasil_saw', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_cosplayer')->constrained('cosplayer', 'id_cosplayer')->cascadeOnDelete();
            $table->float('total_nilai');
            $table->integer('ranking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_saw');
        Schema::dropIfExists('penilaian');
        Schema::dropIfExists('kriteria');
        Schema::dropIfExists('cosplayer');
    }
};
