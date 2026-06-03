<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Alter status column to include 'diajukan'
        // Since SQLite doesn't support MODIFY COLUMN natively and MySQL does, we check the driver first.
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('diajukan', 'dipinjam', 'dikembalikan', 'terlambat') NOT NULL DEFAULT 'diajukan'");
        } else {
            // SQLite or fallback
            // In SQLite, altering enum columns is usually ignored or works with standard change, but SQLite doesn't enforce enums anyway.
            Schema::table('peminjamans', function (Blueprint $table) {
                $table->string('status')->default('diajukan')->change();
            });
        }

        // 2. Add anggota_notified column
        Schema::table('peminjamans', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjamans', 'anggota_notified')) {
                $table->boolean('anggota_notified')->default(false)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            if (Schema::hasColumn('peminjamans', 'anggota_notified')) {
                $table->dropColumn('anggota_notified');
            }
        });

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'terlambat') NOT NULL DEFAULT 'dipinjam'");
        } else {
            Schema::table('peminjamans', function (Blueprint $table) {
                $table->string('status')->default('dipinjam')->change();
            });
        }
    }
};
