<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup', function (Blueprint $table) {
            $table->char('id', 25)->primary();
            $table->text('nama');
            $table->string('channel', 25)->default('laravel');
            $table->dateTime('waktu')->useCurrent();

            $table->index('waktu');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup');
    }
};