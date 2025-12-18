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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Milik siapa portfolio ini?
            $table->string('title');       // Judul Portfolio
            $table->integer('template_id'); // ID Template yang dipakai
            $table->json('content')->nullable(); // Isi konten (disimpan dalam JSON)
            $table->string('status')->default('draft'); // Status: draft/published
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
