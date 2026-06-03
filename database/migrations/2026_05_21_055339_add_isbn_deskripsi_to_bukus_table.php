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
        Schema::table('bukus', function (Blueprint $table) {
            $table->string('isbn', 20)->nullable()->unique()->after('penerbit');
            $table->text('deskripsi')->nullable()->after('isbn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropUnique(['isbn']);
            $table->dropColumn(['isbn', 'deskripsi']);
        });
    }
};
