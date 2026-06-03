<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan:
     * 1. Kolom `nisn` (nullable, unique) ke tabel `users`
     * 2. Kolom `user_id` (nullable FK ke users.id) ke tabel `anggotas`
     */
    public function up(): void
    {
        // 1. Tambah nisn ke users
        Schema::table('users', function (Blueprint $table) {
            $table->string('nisn', 20)->nullable()->unique()->after('name');
        });

        // 2. Tambah user_id FK ke anggotas (penghubung resmi)
        Schema::table('anggotas', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nisn');
        });
    }
};
