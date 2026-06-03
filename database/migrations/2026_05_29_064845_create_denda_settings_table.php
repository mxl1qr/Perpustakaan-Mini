<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denda_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->string('label');
            $table->string('satuan')->nullable();
            $table->timestamps();
        });

        // Seed default values
        DB::table('denda_settings')->insert([
            ['key' => 'tarif_per_hari',   'value' => '1000', 'label' => 'Tarif Denda per Hari',        'satuan' => 'Rp', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'toleransi_hari',   'value' => '0',    'label' => 'Toleransi Keterlambatan',     'satuan' => 'hari', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'denda_maksimal',   'value' => '0',    'label' => 'Denda Maksimal (0 = tidak ada batas)', 'satuan' => 'Rp', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('denda_settings');
    }
};
