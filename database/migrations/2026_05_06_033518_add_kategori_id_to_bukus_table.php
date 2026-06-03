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
            $table->foreignId('kategori_id')
                    ->nullable()
                    ->after('pengarang')
                    ->constrained('kategoris')
                    ->nullOnDelete();    
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropForeignIdFor(App\Models\Kategori::class);
            $table->dropColumn('kategori_id');
        });
    }
};
