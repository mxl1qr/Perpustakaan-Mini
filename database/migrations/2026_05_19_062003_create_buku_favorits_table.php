<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_favorits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->timestamps();
            
            // Satu user hanya bisa memfavoritkan buku yang sama sekali
            $table->unique(['user_id', 'buku_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_favorits');
    }
};
