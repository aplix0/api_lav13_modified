<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('backup_transaksi', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->char('id_backup', 25);
            $table->dateTime('tgl_jam');
            $table->decimal('nominal', 15, 2);
            $table->string('jenis', 5);
            $table->text('uraian');

            $table->index('id_backup');
            $table->index('tgl_jam');
            $table->index('jenis');

            $table->foreign('id_backup')
                ->references('id')
                ->on('backup')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backup_transaksi');
    }
};