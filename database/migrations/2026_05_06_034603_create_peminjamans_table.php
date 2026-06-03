<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas');   // Anggota yang meminjam
            $table->foreignId('buku_id')->constrained('bukus');         // Buku yang dipinjam
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali_rencana');                            // Deadline pengembalian (otomatis +7 hari)
            $table->date('tgl_kembali_aktual')->nullable();                 // Tanggal aktual dikembalikan
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->integer('denda')->default(0);                           // Denda keterlambatan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
